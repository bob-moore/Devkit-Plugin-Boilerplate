<?php
/**
 * Handler Controller
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

use Devkit\Plugin\Handlers as Handler;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\OnMount,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder;

/**
 * Handler controller class
 *
 * Controls and orchestrates the execution of specific handlers.
 *
 * @subpackage Controllers
 */
class Handlers extends WPCore\Controllers\Handlers
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
				Handler\Posts::class  => ContainerBuilder::autowire(),
				Handler\Terms::class  => ContainerBuilder::autowire(),
				Handler\Blocks::class => ContainerBuilder::autowire(),
			]
		);
	}
	/**
	 * Mount blocks handler
	 *
	 * @param Handler\Blocks $handler : instance of block handler.
	 *
	 * @return void
	 */
	#[OnMount]
	public function mountBlocks( Handler\Blocks $handler ): void
	{
		add_action( 'init', [ $handler, 'registerBlocks' ] );
	}
	/**
	 * Mount post handler
	 *
	 * @param Handler\Posts $handler : instance of block handler.
	 *
	 * @return void
	 */
	#[OnMount]
	public function mountPosts( Handler\Posts $handler ): void
	{
		add_action( 'init', [ $handler, 'registerPostTypes' ] );
	}
	/**
	 * Mount term/taxonomy handler
	 *
	 * @param Handler\Terms $handler : instance of block handler.
	 *
	 * @return void
	 */
	#[OnMount]
	public function mountTaxonomies( Handler\Terms $handler ): void
	{
		add_action( 'init', [ $handler, 'registerTaxonomies' ] );
	}
}
