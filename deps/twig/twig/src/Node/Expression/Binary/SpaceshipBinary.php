<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Devkit\Plugin\Deps\Twig\Node\Expression\Binary;

use Devkit\Plugin\Deps\Twig\Compiler;
/** @internal */
class SpaceshipBinary extends AbstractBinary
{
    public function operator(Compiler $compiler) : Compiler
    {
        return $compiler->raw('<=>');
    }
}
