<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PLUGIN_NAMESPACE\Deps\Twig\Extension;

/**
 * Enables usage of the deprecated Twig\Extension\AbstractExtension::getGlobals() method.
 *
 * Explicitly implement this interface if you really need to implement the
 * deprecated getGlobals() method in your extensions.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
interface GlobalsInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getGlobals() : array;
}
