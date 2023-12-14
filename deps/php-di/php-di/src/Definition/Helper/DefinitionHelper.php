<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI\Definition\Helper;

use Devkit\Plugin\Deps\DI\Definition\Definition;
/**
 * Helps defining container entries.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
interface DefinitionHelper
{
    /**
     * @param string $entryName Container entry name
     */
    public function getDefinition(string $entryName) : Definition;
}
