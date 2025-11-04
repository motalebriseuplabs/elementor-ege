<?php
/**
 * Uninstall Elementor edge
 *
 * Fired when the plugin is uninstalled.
 *
 * @package Elementoredge
 * @since 1.0.0
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete plugin options
 */
delete_option( 'elementor_edge_options' );
delete_option( 'elementor_edge_version' );
delete_option( 'elementor_edge_settings' );

/**
 * Delete plugin transients
 */
delete_transient( 'elementor_edge_cache' );

/**
 * For multisite installations
 */
if ( is_multisite() ) {
	global $wpdb;

	// Get all blog ids
	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

	foreach ( $blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );

		// Delete options
		delete_option( 'elementor_edge_options' );
		delete_option( 'elementor_edge_version' );
		delete_option( 'elementor_edge_settings' );

		// Delete transients
		delete_transient( 'elementor_edge_cache' );

		restore_current_blog();
	}
}

/**
 * Clear any cached data
 */
wp_cache_flush();
