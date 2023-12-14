<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PLUGIN_NAMESPACE\Deps\Twig\Node\Expression;

use PLUGIN_NAMESPACE\Deps\Twig\Compiler;
/** @internal */
class AssignNameExpression extends NameExpression
{
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('$context[')->string($this->getAttribute('name'))->raw(']');
    }
}
