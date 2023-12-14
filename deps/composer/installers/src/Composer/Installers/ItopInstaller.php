<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class ItopInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('extension' => 'extensions/{$name}/');
}
