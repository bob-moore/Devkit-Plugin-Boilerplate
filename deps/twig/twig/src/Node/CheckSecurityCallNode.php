<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Devkit\Plugin\Deps\Twig\Node;

use Devkit\Plugin\Deps\Twig\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
class CheckSecurityCallNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $compiler->write("\$this->sandbox = \$this->env->getExtension('\\Devkit\\Plugin\\Deps\\Twig\\Extension\\SandboxExtension');\n")->write("\$this->checkSecurity();\n");
    }
}
