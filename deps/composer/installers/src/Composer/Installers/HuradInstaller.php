<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class HuradInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('plugin' => 'plugins/{$name}/', 'theme' => 'plugins/{$name}/');
    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars) : array
    {
        $nameParts = \explode('/', $vars['name']);
        foreach ($nameParts as &$value) {
            $value = \strtolower($this->pregReplace('/(?<=\\w)([A-Z])/', 'Devkit\\Plugin\\Deps\\_\\1', $value));
            $value = \str_replace(array('-', '_'), ' ', $value);
            $value = \str_replace(' ', '', \ucwords($value));
        }
        $vars['name'] = \implode('/', $nameParts);
        return $vars;
    }
}
