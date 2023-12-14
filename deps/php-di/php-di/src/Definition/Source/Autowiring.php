<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI\Definition\Source;

use Devkit\Plugin\Deps\DI\Definition\Exception\InvalidDefinition;
use Devkit\Plugin\Deps\DI\Definition\ObjectDefinition;
/**
 * Source of definitions for entries of the container.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
interface Autowiring
{
    /**
     * Autowire the given definition.
     *
     * @throws InvalidDefinition An invalid definition was found.
     */
    public function autowire(string $name, ObjectDefinition $definition = null) : ObjectDefinition|null;
}
