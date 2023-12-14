<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class LavaLiteInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('package' => 'packages/{$vendor}/{$name}/', 'theme' => 'public/themes/{$name}/');
}
