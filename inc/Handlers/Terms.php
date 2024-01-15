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

namespace Devkit\Plugin\Handlers;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Main,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\ContainerBuilder,
	Devkit\Plugin\Deps\DI\Attribute\Inject;

/**
 * Controls the registration and execution of services
 *
 * @subpackage Controllers
 */
class Terms extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Handlers\Terms
{
	/**
	 * Array of custom taxonomies
	 *
	 * @var array<WPCore\Interfaces\Entities\Taxonomy>
	 */
	protected array $taxonomies = [];
	/**
	 * Taxonomies array setter
	 *
	 * @param array<WPCore\Interfaces\Entities\Taxonomy> $taxonomies : array of taxonomy objects.
	 *
	 * @return void
	 */
	#[Inject]
	public function setTaxonomiesArray( #[Inject( 'taxonomies' )] array $taxonomies = [] ): void
	{
		$this->setTaxonomies( ...$taxonomies );
	}
	/**
	 * Taxonomies setter
	 *
	 * @param WPCore\Interfaces\Entities\Taxonomy ...$taxonomies : array of taxonomy objects.
	 *
	 * @return void
	 */
	public function setTaxonomies( WPCore\Interfaces\Entities\Taxonomy ...$taxonomies ): void
	{
		$this->taxonomies = array_merge( $this->taxonomies, $taxonomies );
	}
	/**
	 * Taxonomies getter
	 *
	 * @return array<WPCore\Interfaces\Entities\Taxonomy>
	 */
	public function getTaxonomies(): array
	{
		return apply_filters( "{$this->package}_taxonomies", $this->taxonomies );
	}
	/**
	 * Register custom taxonomies
	 *
	 * @return void
	 */
	public function registerTaxonomies(): void
	{
		foreach ( $this->getTaxonomies() as $taxonomy ) {
			if ( ! WPCore\Helpers::implements( $taxonomy, WPCore\Interfaces\Entities\Taxonomy::class ) ) {
				continue;
			}
			register_taxonomy(
				$taxonomy->getName(),
				$taxonomy->getPostTypes(),
				$taxonomy->getDefinition()
			);

			foreach ( $taxonomy->getPostTypes() as $post_type ) {
				register_taxonomy_for_object_type( $taxonomy->getName(), $post_type );
			}
		}
	}
}
