<?php

declare (strict_types=1);
namespace PLUGIN_NAMESPACE\Deps\DI\Compiler;

use PLUGIN_NAMESPACE\Deps\DI\Factory\RequestedEntry;
/**
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
class RequestedEntryHolder implements RequestedEntry
{
    public function __construct(private string $name)
    {
    }
    public function getName() : string
    {
        return $this->name;
    }
}
