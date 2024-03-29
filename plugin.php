<?php
/**
 * Plugin bootstrap file
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Devkit Plugin Boilerplate
 * Plugin URI:  https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * Description: PLUGIN_DESCRIPTION
 * Version:     1.0.3
 * Author:      Bob Moore
 * Author URI:  https://www.bobmoore.dev
 * Requires at least: 6.0
 * Tested up to: 6.3
 * Requires PHP: 8.0.28
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: devkit_plugin
 */

namespace Devkit\Plugin;

defined( 'ABSPATH' ) || exit;

require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vendor/scoped/autoload.php';
require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vendor/scoped/scoper-autoload.php';
require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vendor/autoload.php';

Main::mount( [
    'dir'     => untrailingslashit( plugin_dir_path( __FILE__ ) ),
    'url'     => untrailingslashit( plugin_dir_url( __FILE__ ) ),
    'assets'  => [ 'dir' => 'build/assets' ],
    'blocks'  => [ 'dir' => 'build/blocks' ],
    'views'   => [ 'dir' => 'views' ]
] );
