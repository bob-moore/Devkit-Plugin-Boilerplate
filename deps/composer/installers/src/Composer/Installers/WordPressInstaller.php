<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class WordPressInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('plugin' => 'wp-content/plugins/{$name}/', 'theme' => 'wp-content/themes/{$name}/', 'muplugin' => 'wp-content/mu-plugins/{$name}/', 'dropin' => 'wp-content/{$name}/');
}
