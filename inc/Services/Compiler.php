<?php
/**
 * Compiler Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package Devkit_WP_Framework
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */

namespace Devkit\Plugin\Services;

use Devkit\Plugin\Deps\Devkit\WPCore;

use Devkit\Plugin\Deps\Timber\Timber,
	Devkit\Plugin\Deps\Timber\Loader;

use Devkit\Plugin\Deps\Twig\Error\SyntaxError;

use Devkit\Plugin\Deps\DI\Attribute\Inject;

/**
 * Service class to compile twig files and provide timber functions
 * - Add twig functions & filters
 * - Define template locations
 * - Filter timber context
 * - Add render and compile functions
 *
 * @subpackage Services
 */
class Compiler extends WPCore\Abstracts\Mountable implements WPCore\Interfaces\Services\Compiler, WPCore\Interfaces\Handlers\Directory
{
	use WPCore\Traits\Handlers\Directory;
	use WPCore\Traits\Handlers\Environment;

	/**
	 * Cached template locations for timber to search for templates
	 *
	 * @var array<string>
	 */
	protected array $template_locations = [];
	/**
	 * Directory path to twig view files
	 *
	 * @var string
	 */
	protected string $views_dir = '';
	/**
	 * Directory path to blocks
	 *
	 * @var string
	 */
	protected string $blocks_dir = '';
	/**
	 * Array for timber context
	 *
	 * @var array<mixed>
	 */
	protected array $context = [];
	/**
	 * Setter for the views directory
	 *
	 * @param string $views_dir : path to twig files directory.
	 *
	 * @return void
	 */
	#[Inject]
	public function setViewsDirectory( #[Inject( 'config.views.dir' )] string $views_dir ): void
	{
		$this->views_dir = $views_dir;
	}
	/**
	 * Setter for the assets directory
	 *
	 * @param string $blocks_dir : path to assets directory.
	 *
	 * @return void
	 */
	#[Inject]
	public function setBlocksDirectory( #[Inject( 'config.blocks.dir' )] string $blocks_dir ): void
	{
		$this->blocks_dir = $blocks_dir;
	}
	/**
	 * Add the 'post' to context, if not already present.
	 *
	 * @param array<string, mixed> $context : optional context to merge.
	 *
	 * @return array<int, string>
	 */
	public function context( array $context = [] ): array
	{
		if ( empty( $this->context ) ) {
			$this->context = apply_filters( "{$this->package}_context", [] );
		}
		array_merge(
			Timber::context(),
			$this->context,
			$context
		);
	}
	/**
	 * Filters the default locations array for twig to search for templates. We never use some paths, so there's
	 * no reason to waste overhead looking for templates there.
	 *
	 * @param array<string,mixed> $locations : Array of absolute paths to
	 *                                        available templates.
	 *
	 * @return array<string,mixed> $locations
	 */
	public function templateLocations( array $locations ): array
	{
		if ( empty( $this->template_locations ) ) {
			$template_directories = $locations['__main__'];

			array_push(
				$template_directories,
				trailingslashit( get_stylesheet_directory() . '/' . $this->views_dir ),
				trailingslashit( get_template_directory() . '/' . $this->views_dir )
			);

			$template_directories = apply_filters(
				"{$this->package}_template_directories",
				array_filter( $template_directories, [ $this, 'shouldIncludeDir' ] )
			);

			array_push(
				$template_directories,
				trailingslashit( $this->dir( $this->views_dir ) ),
				trailingslashit( $this->dir( $this->blocks_dir ) )
			);

			$template_directories = array_filter( $template_directories, [ $this, 'shouldIncludeDir' ] );

			$locations[ $this->package ] = array_unique( $template_directories );

			$this->template_locations = $locations;
		}

		return $this->template_locations;
	}
	/**
	 * Array filter to remove directories that should not be included in the template locations array
	 *
	 * @param string $dir : directory path to check.
	 *
	 * @return boolean
	 */
	protected function shouldIncludeDir( string $dir ): bool
	{
		return ( trailingslashit( __DIR__ ) !== trailingslashit( $dir ) )
			&& is_dir( trailingslashit( $dir ) )
			&& ! empty( untrailingslashit( $dir ) );
	}
	/**
	 * Compile a twig/html template file using Timber
	 *
	 * @param string|array<int, string> $template_file : relative path to template file.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compile( $template_file, array $context = [] ): string
	{
		try {
			$template_file = is_array( $template_file ) ? $template_file : [ $template_file ];

			ob_start();

			Timber::render( $template_file, $this->context( $context ), 600, Loader::CACHE_NONE );

			$contents = ob_get_contents();

			return apply_filters( "{$this->package}_compiled", $contents );
		} catch ( SyntaxError | \Error $e ) {
			return $this->isDev() ? esc_html( $e->getMessage() ) : '';
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Compile a string with timber/twig
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compileString( string $content, array $context = [] ): string
	{
		try {
			ob_start();
			Timber::render_string( $content, $this->context( $context ) );
			return apply_filters( "{$this->package}_compiled", ob_get_contents() );
		} catch ( SyntaxError | \Error $e ) {
			WPCore\Helpers::debug( $e->getMessage() );
			return $this->isDev() ? esc_html( $e->getMessage() ) : $content;
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Render a frontend twig template with timber/twig
	 *
	 * Wrapper for `compile` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string|array<int, string> $template_file : file to render.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function render( $template_file, array $context = [] ): void
	{
		// phpcs:ignore
		echo $this->compile( $template_file, $context );
	}
	/**
	 * Render a string with timber/twig
	 *
	 * Wrapper for `compileString` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function renderString( string $content, array $context = [] ): void
	{
		// phpcs:ignore
		echo $this->compileString( $content, $context );
	}
}
