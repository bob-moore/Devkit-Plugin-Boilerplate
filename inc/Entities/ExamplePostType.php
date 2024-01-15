<?php
/**
 * Custom post type definition
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
 * Sample post type definition
 *
 * @subpackage Entities
 */
class ExamplePostType extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Entities\PostType
{
	/**
	 * Getter for post type name
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return 'layout-elements';
	}
	/**
	 * Getter for post type definition
	 *
	 * @see https://generatewp.com/post-type/ to generate new types
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 * @return array<string, mixed>
	 */
	public function getDefinition(): array
	{
		$labels = [
			'name'                  => _x( 'Elements', 'Post Type General Name', 'devkit_plugin' ),
			'singular_name'         => _x( 'Element', 'Post Type Singular Name', 'devkit_plugin' ),
			'menu_name'             => __( 'Elements', 'devkit_plugin' ),
			'name_admin_bar'        => __( 'Elements', 'devkit_plugin' ),
			'parent_item_colon'     => __( 'Parent Element:', 'devkit_plugin' ),
			'all_items'             => __( 'MWF Elements', 'devkit_plugin' ),
			'add_new_item'          => __( 'Add New Element', 'devkit_plugin' ),
			'add_new'               => __( 'Add New', 'devkit_plugin' ),
			'new_item'              => __( 'New Element', 'devkit_plugin' ),
			'edit_item'             => __( 'Edit Element', 'devkit_plugin' ),
			'update_item'           => __( 'Update Element', 'devkit_plugin' ),
			'view_item'             => __( 'View Element', 'devkit_plugin' ),
			'search_items'          => __( 'Search Elements', 'devkit_plugin' ),
			'not_found'             => __( 'Not found', 'devkit_plugin' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'devkit_plugin' ),
			'items_list'            => __( 'Element list', 'devkit_plugin' ),
			'items_list_navigation' => __( 'Element list navigation', 'devkit_plugin' ),
			'filter_items_list'     => __( 'Filter list', 'devkit_plugin' ),
		];

		$rewrite = [
			'slug'       => 'layout-elements',
			'with_front' => false,
			'pages'      => false,
			'feeds'      => false,
		];

		return [
			'description'         => __( 'Custom Layout Elements', 'devkit_plugin' ),
			'label'               => __( 'Elements', 'devkit_plugin' ),
			'taxonomies'          => [],
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor', 'revisions', 'custom-fields' ],
			'hierarchical'        => true,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 99999,
			'menu_icon'           => 'dashicons-text',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => is_user_logged_in(),
			'capability_type'     => 'page',
			'show_in_rest'        => true,
			'rewrite'             => $rewrite,
		];
	}
}
