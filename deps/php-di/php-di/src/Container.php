<?php

declare (strict_types=1);
namespace PLUGIN_NAMESPACE\Deps\DI;

use PLUGIN_NAMESPACE\Deps\DI\Definition\Definition;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Exception\InvalidDefinition;
use PLUGIN_NAMESPACE\Deps\DI\Definition\FactoryDefinition;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Helper\DefinitionHelper;
use PLUGIN_NAMESPACE\Deps\DI\Definition\InstanceDefinition;
use PLUGIN_NAMESPACE\Deps\DI\Definition\ObjectDefinition;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Resolver\DefinitionResolver;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Resolver\ResolverDispatcher;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Source\DefinitionArray;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Source\MutableDefinitionSource;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Source\ReflectionBasedAutowiring;
use PLUGIN_NAMESPACE\Deps\DI\Definition\Source\SourceChain;
use PLUGIN_NAMESPACE\Deps\DI\Definition\ValueDefinition;
use PLUGIN_NAMESPACE\Deps\DI\Invoker\DefinitionParameterResolver;
use PLUGIN_NAMESPACE\Deps\DI\Proxy\ProxyFactory;
use InvalidArgumentException;
use PLUGIN_NAMESPACE\Deps\Invoker\Invoker;
use PLUGIN_NAMESPACE\Deps\Invoker\InvokerInterface;
use PLUGIN_NAMESPACE\Deps\Invoker\ParameterResolver\AssociativeArrayResolver;
use PLUGIN_NAMESPACE\Deps\Invoker\ParameterResolver\Container\TypeHintContainerResolver;
use PLUGIN_NAMESPACE\Deps\Invoker\ParameterResolver\DefaultValueResolver;
use PLUGIN_NAMESPACE\Deps\Invoker\ParameterResolver\NumericArrayResolver;
use PLUGIN_NAMESPACE\Deps\Invoker\ParameterResolver\ResolverChain;
use Psr\Container\ContainerInterface;
/**
 * Dependency Injection Container.
 *
 * @api
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
class Container implements ContainerInterface, FactoryInterface, InvokerInterface
{
    /**
     * Map of entries that are already resolved.
     */
    protected array $resolvedEntries = [];
    protected MutableDefinitionSource $definitionSource;
    protected DefinitionResolver $definitionResolver;
    /**
     * Map of definitions that are already fetched (local cache).
     *
     * @var array<Definition|null>
     */
    protected array $fetchedDefinitions = [];
    /**
     * Array of entries being resolved. Used to avoid circular dependencies and infinite loops.
     */
    protected array $entriesBeingResolved = [];
    protected ?InvokerInterface $invoker = null;
    /**
     * Container that wraps this container. If none, points to $this.
     */
    protected ContainerInterface $delegateContainer;
    protected ProxyFactory $proxyFactory;
    public static function create(array $definitions) : static
    {
        $source = new SourceChain([new ReflectionBasedAutowiring()]);
        $source->setMutableDefinitionSource(new DefinitionArray($definitions, new ReflectionBasedAutowiring()));
        return new static($definitions);
    }
    /**
     * Use `$container = new Container()` if you want a container with the default configuration.
     *
     * If you want to customize the container's behavior, you are discouraged to create and pass the
     * dependencies yourself, the ContainerBuilder class is here to help you instead.
     *
     * @see ContainerBuilder
     *
     * @param ContainerInterface $wrapperContainer If the container is wrapped by another container.
     */
    public function __construct(array|MutableDefinitionSource $definitions = [], ProxyFactory $proxyFactory = null, ContainerInterface $wrapperContainer = null)
    {
        if (\is_array($definitions)) {
            $this->definitionSource = $this->createDefaultDefinitionSource($definitions);
        } else {
            $this->definitionSource = $definitions;
        }
        $this->delegateContainer = $wrapperContainer ?: $this;
        $this->proxyFactory = $proxyFactory ?: new ProxyFactory();
        $this->definitionResolver = new ResolverDispatcher($this->delegateContainer, $this->proxyFactory);
        // Auto-register the container
        $this->resolvedEntries = [self::class => $this, ContainerInterface::class => $this->delegateContainer, FactoryInterface::class => $this, InvokerInterface::class => $this];
    }
    /**
     * Returns an entry of the container by its name.
     *
     * @template T
     * @param string|class-string<T> $id Entry name or a class name.
     *
     * @return mixed|T
     * @throws DependencyException Error while resolving the entry.
     * @throws NotFoundException No entry found for the given name.
     */
    public function get(string $id) : mixed
    {
        // If the entry is already resolved we return it
        if (isset($this->resolvedEntries[$id]) || \array_key_exists($id, $this->resolvedEntries)) {
            return $this->resolvedEntries[$id];
        }
        $definition = $this->getDefinition($id);
        if (!$definition) {
            throw new NotFoundException("No entry or class found for '{$id}'");
        }
        $value = $this->resolveDefinition($definition);
        $this->resolvedEntries[$id] = $value;
        return $value;
    }
    protected function getDefinition(string $name) : ?Definition
    {
        // Local cache that avoids fetching the same definition twice
        if (!\array_key_exists($name, $this->fetchedDefinitions)) {
            $this->fetchedDefinitions[$name] = $this->definitionSource->getDefinition($name);
        }
        return $this->fetchedDefinitions[$name];
    }
    /**
     * Build an entry of the container by its name.
     *
     * This method behave like get() except resolves the entry again every time.
     * For example if the entry is a class then a new instance will be created each time.
     *
     * This method makes the container behave like a factory.
     *
     * @template T
     * @param string|class-string<T> $name       Entry name or a class name.
     * @param array                  $parameters Optional parameters to use to build the entry. Use this to force
     *                                           specific parameters to specific values. Parameters not defined in this
     *                                           array will be resolved using the container.
     *
     * @return mixed|T
     * @throws InvalidArgumentException The name parameter must be of type string.
     * @throws DependencyException Error while resolving the entry.
     * @throws NotFoundException No entry found for the given name.
     */
    public function make(string $name, array $parameters = []) : mixed
    {
        $definition = $this->getDefinition($name);
        if (!$definition) {
            // If the entry is already resolved we return it
            if (\array_key_exists($name, $this->resolvedEntries)) {
                return $this->resolvedEntries[$name];
            }
            throw new NotFoundException("No entry or class found for '{$name}'");
        }
        return $this->resolveDefinition($definition, $parameters);
    }
    public function has(string $id) : bool
    {
        if (\array_key_exists($id, $this->resolvedEntries)) {
            return \true;
        }
        $definition = $this->getDefinition($id);
        if ($definition === null) {
            return \false;
        }
        return $this->definitionResolver->isResolvable($definition);
    }
    /**
     * Inject all dependencies on an existing instance.
     *
     * @template T
     * @param object|T $instance Object to perform injection upon
     * @return object|T $instance Returns the same instance
     * @throws InvalidArgumentException
     * @throws DependencyException Error while injecting dependencies
     */
    public function injectOn(object $instance) : object
    {
        $className = $instance::class;
        // If the class is anonymous, don't cache its definition
        // Checking for anonymous classes is cleaner via Reflection, but also slower
        $objectDefinition = \str_contains($className, '@anonymous') ? $this->definitionSource->getDefinition($className) : $this->getDefinition($className);
        if (!$objectDefinition instanceof ObjectDefinition) {
            return $instance;
        }
        $definition = new InstanceDefinition($instance, $objectDefinition);
        $this->definitionResolver->resolve($definition);
        return $instance;
    }
    /**
     * Call the given function using the given parameters.
     *
     * Missing parameters will be resolved from the container.
     *
     * @param callable|array|string $callable Function to call.
     * @param array    $parameters Parameters to use. Can be indexed by the parameter names
     *                             or not indexed (same order as the parameters).
     *                             The array can also contain DI definitions, e.g. DI\get().
     *
     * @return mixed Result of the function.
     */
    public function call($callable, array $parameters = []) : mixed
    {
        return $this->getInvoker()->call($callable, $parameters);
    }
    /**
     * Define an object or a value in the container.
     *
     * @param string $name Entry name
     * @param mixed|DefinitionHelper $value Value, use definition helpers to define objects
     */
    public function set(string $name, mixed $value) : void
    {
        if ($value instanceof DefinitionHelper) {
            $value = $value->getDefinition($name);
        } elseif ($value instanceof \Closure) {
            $value = new FactoryDefinition($name, $value);
        }
        if ($value instanceof ValueDefinition) {
            $this->resolvedEntries[$name] = $value->getValue();
        } elseif ($value instanceof Definition) {
            $value->setName($name);
            $this->setDefinition($name, $value);
        } else {
            $this->resolvedEntries[$name] = $value;
        }
    }
    /**
     * Get defined container entries.
     *
     * @return string[]
     */
    public function getKnownEntryNames() : array
    {
        $entries = \array_unique(\array_merge(\array_keys($this->definitionSource->getDefinitions()), \array_keys($this->resolvedEntries)));
        \sort($entries);
        return $entries;
    }
    /**
     * Get entry debug information.
     *
     * @param string $name Entry name
     *
     * @throws InvalidDefinition
     * @throws NotFoundException
     */
    public function debugEntry(string $name) : string
    {
        $definition = $this->definitionSource->getDefinition($name);
        if ($definition instanceof Definition) {
            return (string) $definition;
        }
        if (\array_key_exists($name, $this->resolvedEntries)) {
            return $this->getEntryType($this->resolvedEntries[$name]);
        }
        throw new NotFoundException("No entry or class found for '{$name}'");
    }
    /**
     * Get formatted entry type.
     */
    protected function getEntryType(mixed $entry) : string
    {
        if (\is_object($entry)) {
            return \sprintf("Object (\n    class = %s\n)", $entry::class);
        }
        if (\is_array($entry)) {
            return \preg_replace(['/^array \\(/', '/\\)$/'], ['[', ']'], \var_export($entry, \true));
        }
        if (\is_string($entry)) {
            return \sprintf('Value (\'%s\')', $entry);
        }
        if (\is_bool($entry)) {
            return \sprintf('Value (%s)', $entry === \true ? 'true' : 'false');
        }
        return \sprintf('Value (%s)', \is_scalar($entry) ? (string) $entry : \ucfirst(\gettype($entry)));
    }
    /**
     * Resolves a definition.
     *
     * Checks for circular dependencies while resolving the definition.
     *
     * @throws DependencyException Error while resolving the entry.
     */
    protected function resolveDefinition(Definition $definition, array $parameters = []) : mixed
    {
        $entryName = $definition->getName();
        // Check if we are already getting this entry -> circular dependency
        if (isset($this->entriesBeingResolved[$entryName])) {
            throw new DependencyException("Circular dependency detected while trying to resolve entry '{$entryName}'");
        }
        $this->entriesBeingResolved[$entryName] = \true;
        // Resolve the definition
        try {
            $value = $this->definitionResolver->resolve($definition, $parameters);
        } finally {
            unset($this->entriesBeingResolved[$entryName]);
        }
        return $value;
    }
    protected function setDefinition(string $name, Definition $definition) : void
    {
        // Clear existing entry if it exists
        if (\array_key_exists($name, $this->resolvedEntries)) {
            unset($this->resolvedEntries[$name]);
        }
        $this->fetchedDefinitions = [];
        // Completely clear this local cache
        $this->definitionSource->addDefinition($definition);
    }
    protected function getInvoker() : InvokerInterface
    {
        if (!$this->invoker) {
            $parameterResolver = new ResolverChain([new DefinitionParameterResolver($this->definitionResolver), new NumericArrayResolver(), new AssociativeArrayResolver(), new DefaultValueResolver(), new TypeHintContainerResolver($this->delegateContainer)]);
            $this->invoker = new Invoker($parameterResolver, $this);
        }
        return $this->invoker;
    }
    protected function createDefaultDefinitionSource(array $definitions) : SourceChain
    {
        $autowiring = new ReflectionBasedAutowiring();
        $source = new SourceChain([$autowiring]);
        $source->setMutableDefinitionSource(new DefinitionArray($definitions, $autowiring));
        return $source;
    }
}
