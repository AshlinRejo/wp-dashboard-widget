<?php
/**
 * Admin Dashboard controller
 *
 * @package WPDWidget
 */

namespace WPDWidget\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Dashboard
 */
class Dashboard {

	/**
	 * Register the event
	 * */
	public function hooks() {
		add_action( 'wp_dashboard_setup', array( $this, 'register_widgets' ) );
	}

	/**
	 * Register widgets.
	 */
	public function register_widgets() {
		global $wp_meta_boxes;

		wp_add_dashboard_widget( 'wpdw_graph_widget', esc_html__( 'Graph Widget', 'wp-dashbard-widget' ), array( $this, 'load_graph_widget' ) );
	}

	/**
	 * Load graph widget.
	 */
	public function load_graph_widget() {
		?>
		<wpdw-graph-widget></wpdw-graph-widget>
		<?php
	}
}
