<?php

namespace PLUGIN_NAMESPACE\Deps\Composer\Installers;

/** @internal */
class KodiCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('plugin' => 'cms/plugins/{$name}/', 'media' => 'cms/media/vendor/{$name}/');
}
