<?php
/**
 * Main theme handler
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * @since   1.0.0
 */

namespace Devkit\Plugin;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder;

/**
 * Main file
 *
 * @subpackage Main
 */
class Main extends WPCore\Main
{
	/**
	 * The optional package name.
	 *
	 * @var string
	 */
	protected const PACKAGE = 'devkit_plugin';
	/**
	 * Get service definitions to add to service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			Controllers\Handlers::class  => ContainerBuilder::autowire(),
			Controllers\Router::class    => ContainerBuilder::autowire(),
			Controllers\Providers::class => ContainerBuilder::autowire(),
			Controllers\Entities::class  => ContainerBuilder::autowire(),
			Controllers\Compiler::class  => ContainerBuilder::autowire(),
		];
	}
}
