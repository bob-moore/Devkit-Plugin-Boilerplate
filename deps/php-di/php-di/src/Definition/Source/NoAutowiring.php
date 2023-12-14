<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI\Definition\Source;

use Devkit\Plugin\Deps\DI\Definition\Exception\InvalidDefinition;
use Devkit\Plugin\Deps\DI\Definition\ObjectDefinition;
/**
 * Implementation used when autowiring is completely disabled.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
class NoAutowiring implements Autowiring
{
    public function autowire(string $name, ObjectDefinition $definition = null) : ObjectDefinition|null
    {
        throw new InvalidDefinition(\sprintf('Cannot autowire entry "%s" because autowiring is disabled', $name));
    }
}
