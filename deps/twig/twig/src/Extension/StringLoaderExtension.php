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

use PLUGIN_NAMESPACE\Deps\Twig\TwigFunction;
/** @internal */
final class StringLoaderExtension extends AbstractExtension
{
    public function getFunctions() : array
    {
        return [new TwigFunction('template_from_string', 'twig_template_from_string', ['needs_environment' => \true])];
    }
}
namespace PLUGIN_NAMESPACE\Deps;

use PLUGIN_NAMESPACE\Deps\Twig\Environment;
use PLUGIN_NAMESPACE\Deps\Twig\TemplateWrapper;
/**
 * Loads a template from a string.
 *
 *     {{ include(template_from_string("Hello {{ name }}")) }}
 *
 * @param string $template A template as a string or object implementing __toString()
 * @param string $name     An optional name of the template to be used in error messages
 * @internal
 */
function twig_template_from_string(Environment $env, $template, string $name = null) : TemplateWrapper
{
    return $env->createTemplate((string) $template, $name);
}
