<?php

/**
 * Handler Controller
 *
 * PHP Version 8.0.28
 *
 * @package WP Plugin Skeleton
 * @author  AUTHOR_NAME <AUTHOR_EMAIL>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */
namespace PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Controllers;

use PLUGIN_NAMESPACE\Deps\Devkit\WPCore\DI\ContainerBuilder, PLUGIN_NAMESPACE\Deps\Twig\Environment, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\DI\OnMount, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Services as Service, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Interfaces, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Abstracts, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Helpers;
/**
 * Controls the registration and execution of services
 *
 * @subpackage Controllers
 * @internal
 */
class Services extends Abstracts\Mountable implements Interfaces\Controller
{
    /**
     * Get definitions that should be added to the service container
     *
     * @return array<string, mixed>
     */
    public static function getServiceDefinitions() : array
    {
        return [
            /**
             * Class implementations
             */
            Service\Router::class => ContainerBuilder::autowire(),
            Service\Compiler::class => ContainerBuilder::autowire(),
            /**
             * Interfaces mapping
             */
            Interfaces\Services\Router::class => ContainerBuilder::get(Service\Router::class),
            Interfaces\Services\Compiler::class => ContainerBuilder::get(Service\Compiler::class),
        ];
    }
    /**
     * Mount router functions/filters
     *
     * @param Interfaces\Services\Router $router : instance of router service.
     *
     * @return void
     */
    #[OnMount]
    public function mountRouter(Interfaces\Services\Router $router) : void
    {
        \add_action('wp', [$router, 'dispatchRoutes']);
        \add_action('admin_init', [$router, 'dispatchRoutes']);
        \add_action('login_init', [$router, 'dispatchRoutes']);
        \add_filter("{$this->package}_get_routes", [$router, 'getRoutes']);
    }
    /**
     * Mount compiler filters & add twig functions
     *
     * @param Interfaces\Services\Compiler $compiler : instance of compiler service.
     *
     * @return void
     */
    #[OnMount]
    public function mountCompiler(Interfaces\Services\Compiler $compiler) : void
    {
        \add_filter('timber/locations', [$compiler, 'templateLocations']);
        \add_action("{$this->package}_render_template", [$compiler, 'render'], 10, 2);
        \add_filter("{$this->package}_compile_template", [$compiler, 'compile'], 10, 2);
        \add_action("{$this->package}_render_string", [$compiler, 'renderString'], 10, 2);
        \add_filter("{$this->package}_compile_string", [$compiler, 'compileString'], 10, 2);
    }
}
