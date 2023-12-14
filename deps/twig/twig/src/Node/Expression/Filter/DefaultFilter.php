<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\Filter;

use PLUGIN_NAMESPACE\Deps\Twig\Compiler;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\ConditionalExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\ConstantExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\FilterExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\GetAttrExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\NameExpression;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Expression\Test\DefinedTest;
use PLUGIN_NAMESPACE\Deps\Twig\Node\Node;
/**
 * Returns the value or the default value when it is undefined or empty.
 *
 *  {{ var.foo|default('foo item on var is not defined') }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
class DefaultFilter extends FilterExpression
{
    public function __construct(Node $node, ConstantExpression $filterName, Node $arguments, int $lineno, string $tag = null)
    {
        $default = new FilterExpression($node, new ConstantExpression('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());
        if ('default' === $filterName->getAttribute('value') && ($node instanceof NameExpression || $node instanceof GetAttrExpression)) {
            $test = new DefinedTest(clone $node, 'defined', new Node(), $node->getTemplateLine());
            $false = \count($arguments) ? $arguments->getNode(0) : new ConstantExpression('', $node->getTemplateLine());
            $node = new ConditionalExpression($test, $default, $false, $node->getTemplateLine());
        } else {
            $node = $default;
        }
        parent::__construct($node, $filterName, $arguments, $lineno, $tag);
    }
    public function compile(Compiler $compiler) : void
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
