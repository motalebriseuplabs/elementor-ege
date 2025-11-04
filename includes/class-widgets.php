<?php
/**
 * Widgets class
 *
 * @package ElementorEdge
 * @since 1.0.0
 */

namespace ElementorEdge;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Widgets
 *
 * Handles widgets registration
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Widgets Manager
	 *
	 * @since 1.0.0
	 * @access private
	 * @var object
	 */
	private $widgets_manager;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 * @param object $widgets_manager Elementor widgets manager.
	 */
	public function __construct( $widgets_manager ) {
		$this->widgets_manager = $widgets_manager;
		$this->include_widgets_files();
		$this->register_widgets();
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once ELEMENTOR_edge_PATH . 'includes/widgets/class-banner-widget.php';
		require_once ELEMENTOR_edge_PATH . 'includes/widgets/class-workflow-widget.php';
		require_once ELEMENTOR_edge_PATH . 'includes/widgets/class-grap-widget.php';
	}

	/**
	 * Register Widgets
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function register_widgets() {
		// Banner Widget
		$this->widgets_manager->register( new \Elementoredge\Widgets\Banner_Widget() );

		// Workflow Widget
		$this->widgets_manager->register( new \Elementoredge\Widgets\Workflow_Widget() );

		// Circular Diagram Widget
		$this->widgets_manager->register( new \Elementoredge\Widgets\Grap_Widget() );
	}
}
