<?php
/**
 * Plugin requirement checks
 *
 * @package WPDWidget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class to check PHP and WordPress versions to meet plugin requirement
 * */
class WPD_Widget_Requirement_Checks {

	/**
	 * Check the plugin requirement pass
	 *
	 * @return boolean
	 * */
	public function check() {
		if ( $this->is_valid_php() && $this->is_valid_wordpress() ) {
			return true;
		} else {
			add_action( 'admin_notices', array( $this, 'display_notice' ) );
			return false;
		}
	}

	/**
	 * Display error message on admin screen
	 * */
	public function display_notice() {
		echo '<div class="notice notice-warning	"><p>' . esc_html__( 'WP Dashboard Widget plugin needs to meet the following requirement to functional', 'wp-dashbard-widget' ) . '</p><ul>';
		if ( ! $this->is_valid_php() ) {
			/* translators: %1$s - php version of current website, %2$s - php supported version. */
			echo '<li>' . sprintf( esc_html__( 'Your PHP version: %1$s, Needs at-least %2$s or higher', 'wp-dashbard-widget' ), esc_html( PHP_VERSION ), esc_html( WPD_WIDGET_PHP_VERSION ) ) . '</li>';
		}
		if ( ! $this->is_valid_wordpress() ) {
			global $wp_version;
			/* translators: %1$s - Current WordPress version, %2$s - supported version. */
			echo '<li>' . sprintf( esc_html__( 'Your WordPress version: %1$s, Needs at-least %2$s or higher', 'wp-dashbard-widget' ), esc_html( $wp_version ), esc_html( WPD_WIDGET_WP_VERSION ) ) . '</li>';
		}
		echo '</ul></div>';
	}

	/**
	 * Checks is PHP version meet plugin requirement
	 *
	 * @return boolean
	 * */
	private function is_valid_php() {
		return version_compare( PHP_VERSION, WPD_WIDGET_PHP_VERSION, '>=' );
	}

	/**
	 * Checks is WordPress version meet plugin requirement
	 *
	 * @return boolean
	 * */
	private function is_valid_wordpress() {
		global $wp_version;
		return version_compare( $wp_version, WPD_WIDGET_WP_VERSION, '>=' );
	}
}
