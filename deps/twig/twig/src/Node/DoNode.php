<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PLUGIN_NAMESPACE\Deps\Twig\Node;

use PLUGIN_NAMESPACE\Deps\Twig\Compiler;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\AbstractExpression;
/**
 * Represents a do node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
class DoNode extends Node
{
    public function __construct(AbstractExpression $expr, int $lineno, string $tag = null)
    {
        parent::__construct(['expr' => $expr], [], $lineno, $tag);
    }
    public function compile(Compiler $compiler) : void
    {
        $compiler->addDebugInfo($this)->write('')->subcompile($this->getNode('expr'))->raw(";\n");
    }
}
