<?php
/**
 * Plugin main file
 *
 * @package WPDWidget
 */

/**
 * Plugin name: WP Dashboard Widget
 * Description: A plugin with React UI on dashboard.
 * Author: Ashlin
 * Author URI: https://github.com/AshlinRejo
 * Version: 1.0.0
 * Slug: wp-dashbard-widget
 * Text Domain: wp-dashbard-widget
 * Domain Path: languages
 * Requires at least: 5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPD_WIDGET_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
define( 'WPD_WIDGET_URL', plugin_dir_url( __FILE__ ) );
define( 'WPD_WIDGET_PHP_VERSION', '7.2' );
define( 'WPD_WIDGET_WP_VERSION', '5.0' );
define( 'WPD_WIDGET_VERSION', '1.0.0' );

require WPD_WIDGET_PATH . 'inc/wpd-widget-requirement-checks.php';

// Checks plugin requirement.
if ( ( new WPD_Widget_Requirement_Checks() )->check() ) {
	// Composer autoload.
	if ( file_exists( WPD_WIDGET_PATH . 'vendor/autoload.php' ) ) {
		require WPD_WIDGET_PATH . 'vendor/autoload.php';
	}

	// While activate plugin.
	register_activation_hook( __FILE__, array( WPDWidget\Admin\Installation::instance(), 'activated' ) );

	add_action( 'plugins_loaded', array( WPDWidget\Plugin::instance(), 'load' ) );
}
