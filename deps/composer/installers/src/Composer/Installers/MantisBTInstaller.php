<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

use Devkit\Plugin\Deps\Composer\DependencyResolver\Pool;
/** @internal */
class MantisBTInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('plugin' => 'plugins/{$name}/');
    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars) : array
    {
        $vars['name'] = \strtolower($this->pregReplace('/(?<=\\w)([A-Z])/', 'Devkit\\Plugin\\Deps\\_\\1', $vars['name']));
        $vars['name'] = \str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = \str_replace(' ', '', \ucwords($vars['name']));
        return $vars;
    }
}
