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
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
		<div id="wpdw-graph-widget"></div>
		<?php
	}

	/**
	 * Include javascript files
	 * */
	public function enqueue_scripts() {
		$current_screen = get_current_screen();
		$admin_asset = include WPD_WIDGET_PATH . 'assets/js/admin.asset.php';
		if ( 'dashboard' === $current_screen->id ) {
			wp_enqueue_script( 'wp-dashbard-widget-admin', WPD_WIDGET_URL . 'assets/js/admin.js', $admin_asset['dependencies'], $admin_asset['version'], true );
			wp_localize_script(
				'wp-dashbard-widget-admin',
				'wPDWA',
				array(
					'_ajax_nonce' => wp_create_nonce( 'wp-dashbard-widget-ajax-nonce' ),
					'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
					'title_text'  => esc_html__( 'Graph Widget', 'wp-dashbard-widget' )
				)
			);
		}
	}
}
