<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class PhpBBInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('extension' => 'ext/{$vendor}/{$name}/', 'language' => 'language/{$name}/', 'style' => 'styles/{$name}/');
}
