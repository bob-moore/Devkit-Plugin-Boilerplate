<?php

declare (strict_types=1);
namespace PLUGIN_NAMESPACE\Deps\DI\Definition\Helper;

use PLUGIN_NAMESPACE\Deps\DI\Definition\Definition;
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
