<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

/** @internal */
class MagentoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('theme' => 'app/design/frontend/{$name}/', 'skin' => 'skin/frontend/default/{$name}/', 'library' => 'lib/{$name}/');
}
