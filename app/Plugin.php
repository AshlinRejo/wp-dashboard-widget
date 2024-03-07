<?php
/**
 * Plugin core file
 *
 * @package WPDWidget
 */

namespace WPDWidget;

use WPDWidget\Admin\Installation;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plugin
 */
class Plugin {

	/**
	 * Class instance.
	 *
	 * @var Plugin $instance
	 * */
	private static $instance = null;

	/**
	 * Plugin loaded state
	 *
	 * @var boolean $loaded
	 * */
	private $loaded = false;

	/**
	 * Get class instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( ! static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Initialise the plugin
	 * */
	public function load() {
		if ( true === $this->loaded ) {
			return;
		}
		$this->load_text_domain();
		$this->register_events();
		$this->loaded = true;
	}

	/**
	 * Register events
	 * */
	private function register_events() {
		$event_classes = array(
			'\WPDWidget\Admin\Dashboard',
		);
		foreach ( $event_classes as $event_class ) {
			( new $event_class() )->hooks();
		}
	}

	/**
	 * Load plugin text-domain
	 * */
	private function load_text_domain() {
		load_plugin_textdomain( 'wp-dashbard-widget', false, 'wp-dashbard-widget/languages/' );
	}
}
