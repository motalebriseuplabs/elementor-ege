<?php
/**
 * Admin class
 *
 * @package Elementoredge\Admin
 * @since 1.0.0
 */

namespace Elementoredge\Admin;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin
 *
 * Handles admin functionality
 *
 * @since 1.0.0
 */
class Admin {

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
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add Admin Menu
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_admin_menu() {
		add_menu_page(
			esc_html__( 'Elementor edge', 'elementor-edge' ),
			esc_html__( 'Elementor edge', 'elementor-edge' ),
			'manage_options',
			'elementor-edge',
			array( $this, 'admin_page' ),
			'dashicons-star-filled',
			58
		);

		add_submenu_page(
			'elementor-edge',
			esc_html__( 'Settings', 'elementor-edge' ),
			esc_html__( 'Settings', 'elementor-edge' ),
			'manage_options',
			'elementor-edge',
			array( $this, 'admin_page' )
		);

		add_submenu_page(
			'elementor-edge',
			esc_html__( 'Widgets', 'elementor-edge' ),
			esc_html__( 'Widgets', 'elementor-edge' ),
			'manage_options',
			'elementor-edge-widgets',
			array( $this, 'widgets_page' )
		);
	}

	/**
	 * Register Settings
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_settings() {
		register_setting( 'elementor_edge_options', 'elementor_edge_options' );

		add_settings_section(
			'elementor_edge_general_section',
			esc_html__( 'General Settings', 'elementor-edge' ),
			array( $this, 'general_section_callback' ),
			'elementor_edge_options'
		);

		add_settings_field(
			'enable_widgets',
			esc_html__( 'Enable Widgets', 'elementor-edge' ),
			array( $this, 'enable_widgets_callback' ),
			'elementor_edge_options',
			'elementor_edge_general_section'
		);
	}

	/**
	 * Admin Page
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_page() {
		?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form method="post" action="options.php">
		<?php
				settings_fields( 'elementor_edge_options' );
				do_settings_sections( 'elementor_edge_options' );
				submit_button();
		?>
	</form>
</div>
		<?php
	}

	/**
	 * Widgets Page
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widgets_page() {
		?>
<div class="wrap">
	<h1><?php esc_html_e( 'Elementor edge Widgets', 'elementor-edge' ); ?></h1>
	<div class="elementor-edge-widgets-grid">
		<div class="widget-card">
			<h3><?php esc_html_e( 'Hello Widget', 'elementor-edge' ); ?></h3>
			<p><?php esc_html_e( 'A simple gredgeting widget for testing.', 'elementor-edge' ); ?></p>
		</div>
		<div class="widget-card">
			<h3><?php esc_html_e( 'Team Member', 'elementor-edge' ); ?></h3>
			<p><?php esc_html_e( 'Display team member information.', 'elementor-edge' ); ?></p>
		</div>
		<div class="widget-card">
			<h3><?php esc_html_e( 'Testimonial', 'elementor-edge' ); ?></h3>
			<p><?php esc_html_e( 'Show customer testimonials.', 'elementor-edge' ); ?></p>
		</div>
		<div class="widget-card">
			<h3><?php esc_html_e( 'Pricing Table', 'elementor-edge' ); ?></h3>
			<p><?php esc_html_e( 'Create beautiful pricing tables.', 'elementor-edge' ); ?></p>
		</div>
	</div>
</div>
		<?php
	}

	/**
	 * General Section Callback
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function general_section_callback() {
		echo '<p>' . esc_html__( 'Configure general plugin settings.', 'elementor-edge' ) . '</p>';
	}

	/**
	 * Enable Widgets Callback
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enable_widgets_callback() {
		$options = get_option( 'elementor_edge_options' );
		$value   = isset( $options['enable_widgets'] ) ? $options['enable_widgets'] : 1;
		echo '<input type="checkbox" name="elementor_edge_options[enable_widgets]" value="1" ' . checked( $value, 1, false ) . ' />';
		echo '<label>' . esc_html__( 'Enable all Elementor edge widgets', 'elementor-edge' ) . '</label>';
	}
}
