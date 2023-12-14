<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class EliasisInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('component' => 'components/{$name}/', 'module' => 'modules/{$name}/', 'plugin' => 'plugins/{$name}/', 'template' => 'templates/{$name}/');
}
