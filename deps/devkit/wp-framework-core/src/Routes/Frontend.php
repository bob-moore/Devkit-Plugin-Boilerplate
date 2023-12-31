<?php

/**
 * Frontend Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package WP Plugin Skeleton
 * @author  AUTHOR_NAME <AUTHOR_EMAIL>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/wp-framework-core
 * @since   1.0.0
 */
namespace PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Routes;

use PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Abstracts, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Traits, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\Interfaces, PLUGIN_NAMESPACE\Deps\Devkit\WPCore\DI\OnMount;
/**
 * Frontend router class
 *
 * @subpackage Route
 * @internal
 */
class Frontend extends Abstracts\Mountable implements Interfaces\Uses\ScriptDispatcher, Interfaces\Uses\StyleDispatcher
{
    use Traits\Uses\ScriptDispatcher;
    use Traits\Uses\StyleDispatcher;
    /**
     * Load actions and filters, and other setup requirements
     *
     * @return void
     */
    #[OnMount]
    public function mount() : void
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }
    /**
     * Enqueue admin styles and JS bundles
     *
     * @return void
     */
    public function enqueueAssets() : void
    {
        $this->enqueueScript('frontend', 'frontend/bundle.js');
        $this->enqueueStyle('frontend', 'frontend/bundle.css');
    }
}
