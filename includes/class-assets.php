<?php
/**
 * Assets class
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Assets
 *
 * Handles plugin assets loading
 *
 * @since 1.0.0
 */
class Assets {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init Hooks
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_hooks() {
		// Frontend assets
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );

		// Admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		// Elementor editor assets
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_editor_styles' ) );

		// Elementor preview assets
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_styles' ) );
	}

	/**
	 * Enqueue Frontend Scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_frontend_scripts() {
		// Only load on pages with Elementor content
		if ( ! $this->is_elementor_page() ) {
			return;
		}

		// Enqueue Bootstrap JavaScript (Latest Version 5.3.2)
		wp_enqueue_script(
			'elementor-edge-bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
			array( 'jquery' ),
			'5.3.2',
			true
		);

		$script_path = ELEMENTOR_edge_ASSETS . 'frontend/js/frontend.js';

		wp_enqueue_script(
			'elementor-edge-frontend',
			$script_path,
			array( 'jquery', 'elementor-frontend', 'elementor-edge-bootstrap' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Enqueue banner widget script
		$banner_script_path = ELEMENTOR_edge_ASSETS . 'frontend/js/banner.js';

		wp_enqueue_script(
			'elementor-edge-banner-widget',
			$banner_script_path,
			array( 'jquery', 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Enqueue workflow widget script
		$workflow_script_path = ELEMENTOR_edge_ASSETS . 'frontend/js/workflow.js';

		wp_enqueue_script(
			'elementor-edge-workflow-widget',
			$workflow_script_path,
			array( 'jquery', 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Enqueue grap widget script
		$grap_script_path = ELEMENTOR_edge_ASSETS . 'frontend/js/grap.js';

		wp_enqueue_script(
			'elementor-edge-grap-widget',
			$grap_script_path,
			array( 'jquery', 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Localize script
		wp_localize_script(
			'elementor-edge-frontend',
			'elementoredge',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'elementor_edge_nonce' ),
				'strings' => array(
					'loading'       => __( 'Loading...', 'elementor-edge' ),
					'error'         => __( 'Error', 'elementor-edge' ),
					'success'       => __( 'Success', 'elementor-edge' ),
					'confirm'       => __( 'Are you sure?', 'elementor-edge' ),
					'cancel'        => __( 'Cancel', 'elementor-edge' ),
					'save'          => __( 'Save', 'elementor-edge' ),
					'close'         => __( 'Close', 'elementor-edge' ),
					'next'          => __( 'Next', 'elementor-edge' ),
					'previous'      => __( 'Previous', 'elementor-edge' ),
					'search'        => __( 'Search', 'elementor-edge' ),
					'no_results'    => __( 'No results found', 'elementor-edge' ),
					'select_option' => __( 'Select an option', 'elementor-edge' ),
				),
				'debug'   => array(
					'script_path' => $script_path,
					'assets_url'  => ELEMENTOR_edge_ASSETS,
				),
			)
		);
	}

	/**
	 * Enqueue Frontend Styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_frontend_styles() {
		// Only load on pages with Elementor content
		if ( ! $this->is_elementor_page() ) {
			return;
		}

		// Enqueue Bootstrap CSS (Latest Version 5.3.2)
		wp_enqueue_style(
			'elementor-edge-bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
			array(),
			'5.3.2'
		);

		$style_path = ELEMENTOR_edge_ASSETS . 'frontend/css/frontend.css';

		wp_enqueue_style(
			'elementor-edge-frontend',
			$style_path,
			array( 'elementor-edge-bootstrap' ),
			ELEMENTOR_edge_VERSION
		);

		// Enqueue banner widget styles
		$banner_style_path = ELEMENTOR_edge_ASSETS . 'frontend/css/banner.css';

		wp_enqueue_style(
			'elementor-edge-banner',
			$banner_style_path,
			array( 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION
		);

		// Enqueue workflow widget styles
		$workflow_style_path = ELEMENTOR_edge_ASSETS . 'frontend/css/workflow.css';

		wp_enqueue_style(
			'elementor-edge-workflow',
			$workflow_style_path,
			array( 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION
		);

		// Enqueue grap widget styles
		$grap_style_path = ELEMENTOR_edge_ASSETS . 'frontend/css/grap.css';

		wp_enqueue_style(
			'elementor-edge-grap',
			$grap_style_path,
			array( 'elementor-edge-frontend' ),
			ELEMENTOR_edge_VERSION
		);
	}

	/**
	 * Enqueue Admin Scripts
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_scripts( $hook ) {
		// Only load on plugin admin pages
		if ( strpos( $hook, 'elementor-edge' ) === false ) {
			return;
		}

		// Enqueue Bootstrap JavaScript for admin pages
		wp_enqueue_script(
			'elementor-edge-admin-bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
			array( 'jquery' ),
			'5.3.2',
			true
		);

		$script_path = ELEMENTOR_edge_ASSETS . 'admin/js/admin.js';

		wp_enqueue_script(
			'elementor-edge-admin',
			$script_path,
			array( 'jquery', 'elementor-edge-admin-bootstrap' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Localize script
		wp_localize_script(
			'elementor-edge-admin',
			'elementoredgeAdmin',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'elementor_edge_admin_nonce' ),
				'strings' => array(
					'settings_saved' => __( 'Settings saved successfully!', 'elementor-edge' ),
					'settings_error' => __( 'Error saving settings. Please try again.', 'elementor-edge' ),
					'confirm_delete' => __( 'Are you sure you want to delete this item?', 'elementor-edge' ),
					'confirm_reset'  => __( 'Are you sure you want to reset all settings?', 'elementor-edge' ),
					'widget_added'   => __( 'Widget added successfully!', 'elementor-edge' ),
					'widget_removed' => __( 'Widget removed successfully!', 'elementor-edge' ),
					'invalid_input'  => __( 'Please enter valid information.', 'elementor-edge' ),
					'processing'     => __( 'Processing...', 'elementor-edge' ),
					'upload_file'    => __( 'Upload File', 'elementor-edge' ),
					'select_image'   => __( 'Select Image', 'elementor-edge' ),
					'remove_image'   => __( 'Remove Image', 'elementor-edge' ),
				),
			)
		);
	}

	/**
	 * Enqueue Admin Styles
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_styles( $hook ) {
		// Only load on plugin admin pages.
		if ( strpos( $hook, 'elementor-edge' ) === false ) {
			return;
		}

		// Enqueue Bootstrap CSS for admin pages
		wp_enqueue_style(
			'elementor-edge-admin-bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
			array(),
			'5.3.2'
		);

		$style_path = ELEMENTOR_edge_ASSETS . 'admin/css/admin.css';

		wp_enqueue_style(
			'elementor-edge-admin',
			$style_path,
			array( 'elementor-edge-admin-bootstrap' ),
			ELEMENTOR_edge_VERSION
		);
	}

	/**
	 * Enqueue Editor Scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_editor_scripts() {
		$script_path = ELEMENTOR_edge_ASSETS . 'editor/js/editor.js';

		wp_enqueue_script(
			'elementor-edge-editor',
			$script_path,
			array( 'jquery', 'elementor-editor' ),
			ELEMENTOR_edge_VERSION,
			true
		);

		// Localize script
		wp_localize_script(
			'elementor-edge-editor',
			'elementoredgeEditor',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'elementor_edge_editor_nonce' ),
				'strings' => array(
					'widget_title'       => __( 'Elementor edge Widget', 'elementor-edge' ),
					'widget_description' => __( 'Advanced widget for Elementor', 'elementor-edge' ),
					'content_tab'        => __( 'Content', 'elementor-edge' ),
					'style_tab'          => __( 'Style', 'elementor-edge' ),
					'advanced_tab'       => __( 'Advanced', 'elementor-edge' ),
					'general_section'    => __( 'General', 'elementor-edge' ),
					'typography_section' => __( 'Typography', 'elementor-edge' ),
					'spacing_section'    => __( 'Spacing', 'elementor-edge' ),
					'border_section'     => __( 'Border', 'elementor-edge' ),
					'background_section' => __( 'Background', 'elementor-edge' ),
				),
			)
		);
	}

	/**
	 * Enqueue Editor Styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_editor_styles() {
		wp_enqueue_style(
			'elementor-edge-editor',
			ELEMENTOR_edge_ASSETS . 'editor/css/editor.css',
			array(),
			ELEMENTOR_edge_VERSION
		);
	}

	/**
	 * Enqueue Preview Styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_preview_styles() {
		wp_enqueue_style(
			'elementor-edge-preview',
			ELEMENTOR_edge_ASSETS . 'frontend/css/frontend.css',
			array(),
			ELEMENTOR_edge_VERSION
		);
	}

	/**
	 * Check if current page has Elementor content
	 *
	 * @since 1.0.0
	 * @access private
	 * @return bool
	 */
	private function is_elementor_page() {
		global $post;

		if ( ! $post ) {
			return false;
		}

		// Check if page is built with Elementor
		$elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
		if ( ! empty( $elementor_data ) ) {
			return true;
		}

		// Check if Elementor is in edit mode
		if ( isset( $_GET['elementor-preview'] ) && ! empty( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		return false;
	}
}
