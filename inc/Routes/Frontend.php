<?php
/**
 * Frontend Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin_boilerplate
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Boilerplate
 * @since   1.0.0
 */

namespace Devkit\Plugin\Routes;

use Devkit\Plugin\Deps\Devkit\WPCore,
	Devkit\Plugin\Deps\Devkit\WPCore\DI\OnMount;

/**
 * Frontend router class
 *
 * @subpackage Route
 */
class Frontend extends WPCore\Abstracts\Mountable implements
	WPCore\Interfaces\Uses\ScriptDispatcher,
	WPCore\Interfaces\Uses\StyleDispatcher
{
	use WPCore\Traits\Uses\ScriptDispatcher;
	use WPCore\Traits\Uses\StyleDispatcher;

	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	#[OnMount]
	public function mount(): void
	{
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}
	/**
	 * Enqueue admin styles and JS bundles
	 *
	 * @return void
	 */
	public function enqueueAssets(): void
	{
		$this->enqueueScript(
			'frontend',
			'frontend/bundle.js'
		);
		$this->enqueueStyle(
			'frontend',
			'frontend/bundle.css'
		);
	}
}
