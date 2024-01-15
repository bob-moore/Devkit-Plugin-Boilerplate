<?php
/**
 * Frontend Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package devkit_plugin
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
class Login extends WPCore\Abstracts\Mountable implements
	WPCore\Interfaces\Uses\Scripts,
	WPCore\Interfaces\Uses\Styles
{
	use WPCore\Traits\Uses\Scripts;
	use WPCore\Traits\Uses\Styles;

	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	#[OnMount]
	public function mount(): void
	{
		add_action( 'login_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}
	/**
	 * Enqueue styles and JS bundles
	 *
	 * @return void
	 */
	public function enqueueAssets(): void
	{
		$this->enqueueScript(
			'login',
			'login/bundle.js'
		);
		$this->enqueueStyle(
			'login',
			'login/bundle.css'
		);
	}
}
