<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class PhiftyInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('bundle' => 'bundles/{$name}/', 'library' => 'libraries/{$name}/', 'framework' => 'frameworks/{$name}/');
}
