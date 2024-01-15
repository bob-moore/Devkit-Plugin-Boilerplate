<?php
/**
 * Entities Controller
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

use Devkit\Plugin\Entities as Entity;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\OnMount,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder;

use Devkit\Plugin\Deps\Psr\Container\ContainerInterface;

/**
 * Entities controller class
 *
 * Controls and orchestrates the execution of entities (post types, taxonomies, etc).
 *
 * @subpackage Controllers
 */
class Entities extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Controller
{
	/**
	 * Array of entities to register
	 *
	 * @var array<string, array<string>>
	 */
	protected const ENTITIES = [
		'blocks'     => [
			'blocks/sample/block.json',
		],
		'taxonomies' => [
			Entity\ExampleTaxonomy::class,
		],
		'post_types' => [
			Entity\ExamplePostType::class,
		],
	];
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		$definitions = [];
		/**
		 * Loop over and register block definitions, and block factory.
		 */
		foreach ( self::ENTITIES['blocks'] as $definition ) {
			$definitions[ $definition ] = ContainerBuilder::string( '{config.dir}/{config.blocks.dir}/' . $definition );
		}
		$definitions['blocks'] = ContainerBuilder::factory(
			function ( ContainerInterface $container ) {
				return array_map( fn( $definition ) => $container->get( $definition ), self::ENTITIES['blocks'] );
			}
		);
		/**
		 * Loop over and register taxonomy definitions, and taxonomy factory.
		 */
		foreach ( self::ENTITIES['taxonomies'] as $definition ) {
			$definitions[ $definition ] = ContainerBuilder::autowire();
		}
		$definitions['taxonomies'] = ContainerBuilder::factory(
			function ( ContainerInterface $container ) {
				return array_map( fn( $definition ) => $container->get( $definition ), self::ENTITIES['taxonomies'] );
			}
		);
		/**
		 * Loop over and register post type definitions, and post type factory.
		 */
		foreach ( self::ENTITIES['post_types'] as $definition ) {
			$definitions[ $definition ] = ContainerBuilder::autowire();
		}
		$definitions['post_types'] = ContainerBuilder::factory(
			function ( ContainerInterface $container ) {
				return array_map( fn( $definition ) => $container->get( $definition ), self::ENTITIES['post_types'] );
			}
		);

		return $definitions;
	}
}
