<?php

/**
 * Router Service interface definition
 *
 * PHP Version 8.0.28
 *
 * @package WP Plugin Skeleton
 * @author  AUTHOR_NAME <AUTHOR_EMAIL>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */
namespace PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Interfaces\Services;

/**
 * Services\Router interface
 *
 * Used to type hint against Devkit\WPCore\Interfaces\Services\Router.
 *
 * @subpackage Interfaces
 * @internal
 */
interface Router
{
    /**
     * Getter for routes
     * 
     * @param array<string> $default_routes : routes to prepend to the list.
     *
     * @return array<string>
     */
    public function getRoutes(array $default_routes = []) : array;
    /**
     * Fire router ready action
     *
     * @return void
     */
    public function dispatchRoutes() : void;
}
