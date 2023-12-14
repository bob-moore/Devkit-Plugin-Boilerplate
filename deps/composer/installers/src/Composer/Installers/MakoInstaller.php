<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class MakoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('package' => 'app/packages/{$name}/');
}
