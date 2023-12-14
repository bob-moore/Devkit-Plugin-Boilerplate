<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class LaravelInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('library' => 'libraries/{$name}/');
}
