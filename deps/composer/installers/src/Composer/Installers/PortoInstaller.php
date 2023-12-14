<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class PortoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('container' => 'app/Containers/{$name}/');
}
