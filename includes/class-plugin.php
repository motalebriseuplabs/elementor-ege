<?php
namespace Elementoredge;

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Plugin The single instance of the class.
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
	 * @return Plugin An instance of the class.
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
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function includes() {
		// Admin
		if ( is_admin() ) {
			require_once ELEMENTOR_edge_PATH . 'includes/admin/class-admin.php';
		}

		// Assets
		require_once ELEMENTOR_edge_PATH . 'includes/class-assets.php';

		// Widgets
		require_once ELEMENTOR_edge_PATH . 'includes/class-widgets.php';

		// Controls
		require_once ELEMENTOR_edge_PATH . 'includes/class-controls.php';
	}

	/**
	 * Init Hooks
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_hooks() {
		// Init Assets.
		new Assets();

		// Init Admin.
		if ( is_admin() ) {
			new Admin\Admin();
		}

		// Init Widgets.
		add_action( 'elementor/widgets/register', array( $this, 'init_widgets' ) );

		// Init Controls.
		add_action( 'elementor/controls/register', array( $this, 'init_controls' ) );

		// Widget Categories.
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_widgets( $widgets_manager ) {
		new Widgets( $widgets_manager );
	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_controls( $controls_manager ) {
		new Controls( $controls_manager );
	}

	/**
	 * Add Elementor Widget Categories
	 *
	 * Register widget categories for Elementor edge widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'elementor-edge',
			array(
				'title' => esc_html__( 'Elementor edge', 'elementor-edge' ),
				'icon'  => 'fa fa-plug',
			)
		);

		$elements_manager->add_category(
			'elementor-edge-pro',
			array(
				'title' => esc_html__( 'Elementor edge Pro', 'elementor-edge' ),
				'icon'  => 'fa fa-star',
			)
		);
	}
}
