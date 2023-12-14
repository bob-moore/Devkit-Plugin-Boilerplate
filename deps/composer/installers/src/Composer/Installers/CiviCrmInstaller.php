<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class CiviCrmInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('ext' => 'ext/{$name}/');
}
