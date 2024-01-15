<?php
/**
 * Route controller
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * @since   1.0.0
 */

namespace Devkit\Plugin\Controllers;

use Devkit\Plugin\Routes as Route;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder;

/**
 * Route controller class
 *
 * Defines routes to be loaded
 *
 * @subpackage Controllers
 */
class Router extends WPCore\Controllers\Router
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return array_merge(
			parent::getServiceDefinitions(),
			[
				Route\Archive::class  => ContainerBuilder::autowire(),
				Route\Search::class   => ContainerBuilder::autowire(),
				Route\Blog::class     => ContainerBuilder::autowire(),
				Route\Single::class   => ContainerBuilder::autowire(),
				Route\Admin::class    => ContainerBuilder::autowire(),
				Route\Frontend::class => ContainerBuilder::autowire(),
				Route\Login::class    => ContainerBuilder::autowire(),
				'route'               => ContainerBuilder::array(
					[
						'archive'  => ContainerBuilder::get( Route\Archive::class ),
						'search'   => ContainerBuilder::get( Route\Search::class ),
						'blog'     => ContainerBuilder::get( Route\Blog::class ),
						'single'   => ContainerBuilder::get( Route\Single::class ),
						'admin'    => ContainerBuilder::get( Route\Admin::class ),
						'frontend' => ContainerBuilder::get( Route\Frontend::class ),
						'login'    => ContainerBuilder::get( Route\Login::class ),
					]
				),
			]
		);
	}
}
