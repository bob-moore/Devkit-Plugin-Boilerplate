<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/**
 * Class DolibarrInstaller
 *
 * @package Composer\Installers
 * @author  Raphaël Doursenaud <rdoursenaud@gpcsolutions.fr>
 * @internal
 */
class DolibarrInstaller extends BaseInstaller
{
    //TODO: Add support for scripts and themes
    /** @var array<string, string> */
    protected $locations = array('module' => 'htdocs/custom/{$name}/');
}
