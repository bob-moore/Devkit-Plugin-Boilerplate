<?php
/**
 * Providers Controller
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

use Devkit\Plugin\Providers as Provider;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder;

use Devkit\Plugin\Deps\Psr\Container\ContainerInterface;

/**
 * Providers controller class
 *
 * Controls and orchestrates the execution of any 3rd party providers.
 *
 * @subpackage Controllers
 */
class Providers extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			Provider\ACF::class => ContainerBuilder::autowire(),
			static::class       => ContainerBuilder::decorate(
				[
					static::class,
					'decorateInstance',
				]
			),
		];
	}
	/**
	 * Class decorator
	 *
	 * Mounts active providers
	 *
	 * @param self               $instance : instance of this class.
	 * @param ContainerInterface $container : container instance.
	 *
	 * @return self
	 */
	public static function decorateInstance( self $instance, ContainerInterface $container ): self
	{
		/**
		 * Mount Advanced Custom Fields Provider IF the plugin is active
		 */
		if (
			WPCore\Helpers::isPluginActive( 'advanced-custom-fields-pro/acf.php' )
			|| WPCore\Helpers::isPluginActive( 'advanced-custom-fields/acf.php' )
		) {
			$instance->mountAcf( $container->get( Provider\ACF::class ) );
		}

		return $instance;
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @param Provider\ACF $provider : acf provider instance.
	 *
	 * @return void
	 */
	public function mountAcf( Provider\ACF $provider ): void
	{
		add_filter( 'acf/settings/save_json', [ $provider, 'savePaths' ] );
		add_filter( 'acf/settings/load_json', [ $provider, 'loadPaths' ] );
	}
}
