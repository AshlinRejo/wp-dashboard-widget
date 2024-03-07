<?php
/**
 * Admin Installation controller
 *
 * @package WPDWidget
 */

namespace WPDWidget\Admin;

use WPDWidget\Helper\Common;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Plugin installation
 */
class Installation {

	/**
	 * Class instance.
	 *
	 * @var Installation $instance
	 * */
	private static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return Installation
	 */
	public static function instance() {
		if ( ! static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Process plugin installation
	 * */
	public function activated() {
		if ( ! Common::is_administrator() ) {
			return;
		}
		$this->add_database_tables();
	}

	/**
	 * Add tables if not exists.
	 * */
	private function add_database_tables() {
		// TODO: Add tables.
	}
}
