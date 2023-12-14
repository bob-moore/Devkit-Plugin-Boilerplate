<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI\Definition\Source;

use Devkit\Plugin\Deps\DI\Definition\Definition;
use Devkit\Plugin\Deps\DI\Definition\Exception\InvalidDefinition;
/**
 * Source of definitions for entries of the container.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
interface DefinitionSource
{
    /**
     * Returns the DI definition for the entry name.
     *
     * @throws InvalidDefinition An invalid definition was found.
     */
    public function getDefinition(string $name) : Definition|null;
    /**
     * @return array<string,Definition> Definitions indexed by their name.
     */
    public function getDefinitions() : array;
}
