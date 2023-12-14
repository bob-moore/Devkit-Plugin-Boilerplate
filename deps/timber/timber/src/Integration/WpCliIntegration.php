<?php

namespace PLUGIN_NAMESPACE\Deps\Timber\Integration;

use PLUGIN_NAMESPACE\Deps\Timber\Integration\CLI\TimberCommand;
use WP_CLI;
/**
 * Class WpCliIntegration
 *
 * Adds a "timber" command to WP CLI.
 * @internal
 */
class WpCliIntegration implements IntegrationInterface
{
    public function should_init() : bool
    {
        return \defined('WP_CLI') && \class_exists('Devkit\\Plugin\\Deps\\WP_CLI');
    }
    public function init() : void
    {
        WP_CLI::add_command('timber', TimberCommand::class);
    }
}
