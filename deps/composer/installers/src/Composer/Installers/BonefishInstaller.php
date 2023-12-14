<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class BonefishInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('package' => 'Packages/{$vendor}/{$name}/');
}
