<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class AttogramInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('module' => 'modules/{$name}/');
}
