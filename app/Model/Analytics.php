<?php
/**
 * Model Analytics
 *
 * @package WPDWidget
 */

namespace WPDWidget\Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Analytics
 */
class Analytics {

	/**
	 * Class instance.
	 *
	 * @var Analytics $instance
	 * */
	protected static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return Analytics
	 */
	public static function instance() {
		if ( ! static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Get table name
	 *
	 * @return string identifier
	 * */
	public static function get_table_name() {
		global $wpdb;
		return $wpdb->prefix . 'wpdw_analytics';
	}

	/**
	 * Get analytics
	 *
	 * @param string $date_from Date from.
	 * @return mixed
	 * */
	public function get_analytics( $date_from ) {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$wpdb->hide_errors();
		$table_name = self::get_table_name();
		$cache_name = 'wpdw_analytics_items_' . str_replace( array( ':', ' ' ), '_', $date_from );
		$items      = wp_cache_get( $cache_name );
		if ( ! $items ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$items = $wpdb->get_results( $wpdb->prepare( "SELECT title, SUM(uv) as uv, SUM(pv) as pv FROM `$table_name` WHERE `created_at` > %s GROUP BY `title` ORDER BY `title`", esc_sql( $date_from ) ), OBJECT );
			wp_cache_set( $cache_name, $items );
		}

		return $items;
	}

	/**
	 * Add to DB
	 *
	 * @param array $data column to add.
	 * @return boolean|integer
	 * */
	public function add( $data ) {
		if ( empty( $data['title'] ) || empty( $data['uv'] ) || empty( $data['pv'] ) ) {
			return false;
		}
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$wpdb->hide_errors();
		$table_name = $wpdb->prefix . 'wpdw_analytics';
		$values     = array(
			'title'      => $data['title'],
			'uv'         => $data['uv'],
			'pv'         => $data['pv'],
			'created_at' => $data['created_at'],
		);

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$result = $wpdb->insert( $table_name, $values );
		if ( false === $result ) {
			return false;
		}
		// Returns the last inserted ID.
		return $wpdb->insert_id;
	}
}
