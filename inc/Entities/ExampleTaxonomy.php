<?php
/**
 * Page Category taxonomy definition
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * @since   1.0.0
 */

namespace Devkit\Plugin\Entities;

use Devkit\Plugin\Deps\Devkit\WPCore;

/**
 * Custom Taxonomy class
 *
 * @subpackage Controllers
 */
class ExampleTaxonomy extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Entities\Taxonomy
{
	/**
	 * Getter for taxonomy name
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return 'page-category';
	}
	/**
	 * Getter for taxonomy definition
	 *
	 * @see https://generatewp.com/taxonomy/ to generate definitions.
	 * @return array<string, mixed>
	 */
	public function getDefinition(): array
	{
		$labels = [
			'name'                       => _x( 'Categories', 'Taxonomy General Name', 'devkit_plugin' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'devkit_plugin' ),
			'menu_name'                  => __( 'Categories', 'devkit_plugin' ),
			'all_items'                  => __( 'All Items', 'devkit_plugin' ),
			'parent_item'                => __( 'Parent Item', 'devkit_plugin' ),
			'parent_item_colon'          => __( 'Parent Item:', 'devkit_plugin' ),
			'new_item_name'              => __( 'New Item Name', 'devkit_plugin' ),
			'add_new_item'               => __( 'Add New Item', 'devkit_plugin' ),
			'edit_item'                  => __( 'Edit Item', 'devkit_plugin' ),
			'update_item'                => __( 'Update Item', 'devkit_plugin' ),
			'view_item'                  => __( 'View Item', 'devkit_plugin' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'devkit_plugin' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'devkit_plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'devkit_plugin' ),
			'popular_items'              => __( 'Popular Items', 'devkit_plugin' ),
			'search_items'               => __( 'Search Items', 'devkit_plugin' ),
			'not_found'                  => __( 'Not Found', 'devkit_plugin' ),
			'no_terms'                   => __( 'No items', 'devkit_plugin' ),
			'items_list'                 => __( 'Items list', 'devkit_plugin' ),
			'items_list_navigation'      => __( 'Items list navigation', 'devkit_plugin' ),
		];
		return [
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_in_rest'      => true,
			'post_types'        => $this->getPostTypes(),
		];
	}
	/**
	 * Getter for taxonomy post types
	 *
	 * @return array<string>
	 */
	public function getPostTypes(): array
	{
		return [ 'page' ];
	}
}
