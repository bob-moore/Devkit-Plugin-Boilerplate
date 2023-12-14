<?php

declare (strict_types=1);
namespace Devkit\Plugin\Deps\DI\Definition;

/**
 * A definition that extends a previous definition with the same name.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @internal
 */
interface ExtendsPreviousDefinition extends Definition
{
    public function setExtendedDefinition(Definition $definition) : void;
}
