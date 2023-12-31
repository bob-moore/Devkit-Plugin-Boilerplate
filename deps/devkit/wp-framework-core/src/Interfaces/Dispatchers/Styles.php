<?php

/**
 * Style Dispatcher interface definition
 *
 * PHP Version 8.0.28
 *
 * @package WP Plugin Skeleton
 * @author  AUTHOR_NAME <AUTHOR_EMAIL>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */
namespace PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Interfaces\Dispatchers;

/**
 * Dispatcher\Style interface
 *
 * Used to type hint against Devkit\WPCore\Interfaces\Dispatchers\Styles.
 *
 * @subpackage Interfaces
 * @internal
 */
interface Styles
{
    /**
     * Enqueue a style in the dist/build directories
     *
     * @param string             $handle : handle to register.
     * @param string             $path : relative path to css file.
     * @param array<int, string> $dependencies : any dependencies that should be loaded first, optional.
     * @param string             $version : version of CSS file, optional.
     * @param string             $screens : what screens to register for, optional.
     *
     * @return void
     */
    public function enqueue(string $handle, string $path, array $dependencies = [], string $version = null, $screens = 'all') : void;
    /**
     * Register a CSS stylesheet with WP
     *
     * @param string             $handle : handle to register.
     * @param string             $path : relative path to css file.
     * @param array<int, string> $dependencies : any dependencies that should be loaded first, optional.
     * @param string             $version : version of CSS file, optional.
     * @param string             $screens : what screens to register for, optional.
     *
     * @return string
     */
    public function register(string $handle, string $path, array $dependencies = [], string $version = null, $screens = 'all') : string;
}
