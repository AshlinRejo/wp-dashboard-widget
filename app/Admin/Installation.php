<?php
/**
 * Admin Installation controller
 *
 * @package WPDWidget
 */

namespace WPDWidget\Admin;

use WPDWidget\Helper\Common;
use WPDWidget\Model\Analytics;

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
		$this->add_dummy_data();
	}

	/**
	 * On plugin deactivate.
	 */
	public function deactivated() {
		if ( ! Common::is_administrator() ) {
			return;
		}
		$this->remove_database_tables();
	}

	/**
	 * Remove table if exists. This usually written in uninstall script, here it written because of sample plugin.
	 * */
	private function remove_database_tables() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$wpdb->hide_errors();
		$table_name = Analytics::get_table_name();
		$sql        = "DROP TABLE IF EXISTS $table_name";
		// phpcs:ignore WordPress.DB
		$wpdb->query( $sql );
	}

	/**
	 * Add tables if not exists.
	 * */
	private function add_database_tables() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$wpdb->hide_errors();
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = Analytics::get_table_name();
		$query           = "CREATE TABLE $table_name (
                                  `id` bigint NOT NULL AUTO_INCREMENT,
                                  `title` varchar(255) NOT NULL,
                                  `uv` int NOT NULL,
                                  `pv` int NOT NULL,
                                  `created_at` timestamp NOT NULL,
                                 PRIMARY KEY (`id`)
                            ) $charset_collate;";
		dbDelta( $query );
	}

	/**
	 * Add dummy data.
	 * */
	private function add_dummy_data() {
		$pages = array( 'Page 1', 'Page 2', 'Page 3', 'page 4', 'page 5' );
		for ( $i = 0; $i < 30; $i++ ) {
			$date = gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $i + 1 ) . ' day', strtotime( current_time( 'mysql' ) ) ) );
			foreach ( $pages as $page ) {
				$data = array(
					'title'      => $page,
					'uv'         => wp_rand( 100, 200 ),
					'pv'         => wp_rand( 100, 200 ),
					'created_at' => $date,
				);
				Analytics::instance()->add( $data );
			}
		}
	}
}
