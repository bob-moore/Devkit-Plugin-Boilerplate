<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class AkauntingInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('module' => 'modules/{$name}');
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
