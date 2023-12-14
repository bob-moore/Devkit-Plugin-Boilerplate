<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class UserFrostingInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('sprinkle' => 'app/sprinkles/{$name}/');
}
