<?php

namespace Devkit\Plugin\Deps\Composer\Installers;

use Devkit\Plugin\Deps\Composer\Composer;
use Devkit\Plugin\Deps\Composer\IO\IOInterface;
use Devkit\Plugin\Deps\Composer\Plugin\PluginInterface;
/** @internal */
class Plugin implements PluginInterface
{
    /** @var Installer */
    private $installer;
    public function activate(Composer $composer, IOInterface $io) : void
    {
        $this->installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }
    public function deactivate(Composer $composer, IOInterface $io) : void
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }
    public function uninstall(Composer $composer, IOInterface $io) : void
    {
    }
}
