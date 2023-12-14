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
namespace PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\Binary;

use PLUGIN_NAMESPACE\Deps\Twig\Compiler;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\AbstractExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Node;
/** @internal */
abstract class AbstractBinary extends AbstractExpression
{
    public function __construct(Node $left, Node $right, int $lineno)
    {
        parent::__construct(['left' => $left, 'right' => $right], [], $lineno);
    }
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('(')->subcompile($this->getNode('left'))->raw(' ');
        $this->operator($compiler);
        $compiler->raw(' ')->subcompile($this->getNode('right'))->raw(')');
    }
    public abstract function operator(Compiler $compiler) : Compiler;
}
