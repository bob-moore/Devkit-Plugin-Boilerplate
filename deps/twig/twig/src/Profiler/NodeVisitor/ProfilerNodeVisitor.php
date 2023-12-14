<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Devkit\Plugin\Deps\Twig\Profiler\NodeVisitor;

use Devkit\Plugin\Deps\Twig\Environment;
use Devkit\Plugin\Deps\Twig\Node\BlockNode;
use Devkit\Plugin\Deps\Twig\Node\BodyNode;
use Devkit\Plugin\Deps\Twig\Node\MacroNode;
use Devkit\Plugin\Deps\Twig\Node\ModuleNode;
use Devkit\Plugin\Deps\Twig\Node\Node;
use Devkit\Plugin\Deps\Twig\NodeVisitor\NodeVisitorInterface;
use Devkit\Plugin\Deps\Twig\Profiler\Node\EnterProfileNode;
use Devkit\Plugin\Deps\Twig\Profiler\Node\LeaveProfileNode;
use Devkit\Plugin\Deps\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
final class ProfilerNodeVisitor implements NodeVisitorInterface
{
    private $extensionName;
    private $varName;
    public function __construct(string $extensionName)
    {
        $this->extensionName = $extensionName;
        $this->varName = \sprintf('__internal_%s', \hash(\PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $extensionName));
    }
    public function enterNode(Node $node, Environment $env) : Node
    {
        return $node;
    }
    public function leaveNode(Node $node, Environment $env) : ?Node
    {
        if ($node instanceof ModuleNode) {
            $node->setNode('display_start', new Node([new EnterProfileNode($this->extensionName, Profile::TEMPLATE, $node->getTemplateName(), $this->varName), $node->getNode('display_start')]));
            $node->setNode('display_end', new Node([new LeaveProfileNode($this->varName), $node->getNode('display_end')]));
        } elseif ($node instanceof BlockNode) {
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::BLOCK, $node->getAttribute('name'), $this->varName), $node->getNode('body'), new LeaveProfileNode($this->varName)]));
        } elseif ($node instanceof MacroNode) {
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::MACRO, $node->getAttribute('name'), $this->varName), $node->getNode('body'), new LeaveProfileNode($this->varName)]));
        }
        return $node;
    }
    public function getPriority() : int
    {
        return 0;
    }
}
