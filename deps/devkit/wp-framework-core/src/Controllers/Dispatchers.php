<?php

/**
 * Dispatcher Controller
 *
 * PHP Version 8.0.28
 *
 * @package WP Plugin Skeleton
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */
namespace Devkit\Plugin\Deps\Devkit\WPCore\Controllers;

use Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder, Devkit\Plugin\Deps\Devkit\WPCore\Dispatchers as Dispatcher, Devkit\Plugin\Deps\Devkit\WPCore\Interfaces, Devkit\Plugin\Deps\Devkit\WPCore\Abstracts;
/**
 * Controls the registration and execution of Dispatchers
 *
 * @subpackage Controllers
 * @internal
 */
class Dispatchers extends Abstracts\Mountable implements Interfaces\Controller
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
             * Class Aliases
             */
            Dispatcher\Styles::class => ContainerBuilder::autowire(),
            Dispatcher\Scripts::class => ContainerBuilder::autowire(),
            /**
             * Interfaces
             */
            Interfaces\Dispatchers\Styles::class => ContainerBuilder::get(Dispatcher\Styles::class),
            Interfaces\Dispatchers\Scripts::class => ContainerBuilder::get(Dispatcher\Scripts::class),
        ];
    }
}
