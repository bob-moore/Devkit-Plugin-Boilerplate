<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Devkit\Plugin\Deps\Twig\Node\Expression;

use Devkit\Plugin\Deps\Twig\Compiler;
/** @internal */
class VariadicExpression extends ArrayExpression
{
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('...');
        parent::compile($compiler);
    }
}
