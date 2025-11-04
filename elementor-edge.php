<?php
/**
 * Plugin Name: Elementor edge
 * Plugin URI: https://example.com/elementor-edge
 * Description: Professional Elementor widgets collection following WordPress.org standards. Advanced widgets for modern website building.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-edge
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Elementor tested up to: 3.17.0
 * Elementor Pro tested up to: 3.17.0
 * Network: false
 *
 * @package Elementoredge
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Elementor edge Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elementor_edge {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Elementor_edge The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Elementor_edge An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Localization files
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/elementor-edge/elementor-edge-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/elementor-edge-LOCALE.mo
	 *      - wp-content/plugins/elementor-edge/languages/elementor-edge-LOCALE.mo
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		$domain = 'elementor-edge';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		// Load from WordPress language directory first
		load_textdomain( $domain, WP_LANG_DIR . '/plugins/' . $domain . '-' . $locale . '.mo' );

		// Load from plugin language directory
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/init', array( $this, 'elementor_init' ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-edge' ),
			'<strong>' . esc_html__( 'Elementor edge', 'elementor-edge' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-edge' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-edge' ),
			'<strong>' . esc_html__( 'Elementor edge', 'elementor-edge' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-edge' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-edge' ),
			'<strong>' . esc_html__( 'Elementor edge', 'elementor-edge' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-edge' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Init Elementor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function elementor_init() {

		// Define constants
		$this->define_constants();

		// Include files
		$this->includes();

		// Init classes
		$this->init_classes();

		// Hook into actions and filters
		$this->init_hooks();
	}

	/**
	 * Define Constants
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_constants() {
		define( 'ELEMENTOR_edge_VERSION', self::VERSION );
		define( 'ELEMENTOR_edge_FILE', __FILE__ );
		define( 'ELEMENTOR_edge_PATH', plugin_dir_path( __FILE__ ) );
		define( 'ELEMENTOR_edge_URL', plugin_dir_url( __FILE__ ) );
		define( 'ELEMENTOR_edge_ASSETS', ELEMENTOR_edge_URL . 'assets/' );
		define( 'ELEMENTOR_edge_BASENAME', plugin_basename( __FILE__ ) );
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function includes() {
		require_once ELEMENTOR_edge_PATH . 'includes/class-plugin.php';
	}

	/**
	 * Init Classes
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_classes() {
		new \Elementoredge\Plugin();
	}

	/**
	 * Init Hooks
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_hooks() {
		// Plugin action links
		add_filter( 'plugin_action_links_' . ELEMENTOR_edge_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Plugin action links
	 *
	 * @since 1.0.0
	 * @param array $links Plugin action links.
	 * @return array Plugin action links.
	 */
	public function plugin_action_links( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=elementor-edge' ) ),
			esc_html__( 'Settings', 'elementor-edge' )
		);
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Plugin Activation
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function activate() {
		// Set default options
		$default_options = array(
			'version' => self::VERSION,
		);
		add_option( 'elementor_edge_options', $default_options );

		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Plugin Deactivation
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function deactivate() {
		// Flush rewrite rules
		flush_rewrite_rules();
	}
}

// Activation/Deactivation hooks
register_activation_hook( __FILE__, array( 'Elementor_edge', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Elementor_edge', 'deactivate' ) );

// Instantiate Elementor_edge.
Elementor_edge::instance();
