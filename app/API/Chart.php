<?php
/**
 * API Routes for Chart
 *
 * @package WPDWidget
 */

namespace WPDWidget\API;

use WPDWidget\Helper\Common;
use WPDWidget\Model\Analytics;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * API Routes
 */
class Chart extends \WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'wp-dashboard-widget/v' . $version;
		$base      = 'chart';
		register_rest_route(
			$namespace,
			'/' . $base,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	/**
	 * Check permission.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 */
	public function get_items_permissions_check( $request ) {
		if ( Common::is_administrator() ) {
			return true;
		}
		return false;
	}

	/**
	 * Retrieves a collection of items.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 */
	public function get_items( $request ) {
		$last_days = $request->get_param( 'last' );
		$last_days = sanitize_text_field( wp_unslash( $last_days ) );
		if ( '1-month' === $last_days ) {
			$last_day = 30;
		} elseif ( '15-days' === $last_days ) {
			$last_day = 15;
		} else {
			$last_day = 7;
		}
		$date             = gmdate( 'Y-m-d H:i:s', strtotime( '-' . $last_day . ' day', strtotime( current_time( 'mysql' ) ) ) );
		$analytics_result = Analytics::instance()->get_analytics( $date );
		wp_send_json_success( $analytics_result, 200 );
	}
}
