<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class DecibelInstaller extends BaseInstaller
{
    /** @var array */
    /** @var array<string, string> */
    protected $locations = array('app' => 'app/{$name}/');
}
