<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class DecibelInstaller extends BaseInstaller
{
    /** @var array */
    /** @var array<string, string> */
    protected $locations = array('app' => 'app/{$name}/');
}
