<?php
/**
 * Workflow Widget
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Workflow_Widget
 *
 * @since 1.0.0
 */
class Workflow_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elementor-edge-workflow';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Workflow Diagram', 'elementor-edge' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-flow';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'elementor-edge' );
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'workflow', 'process', 'diagram', 'flow', 'steps', 'visual' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Workflow Steps', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'step_text',
			array(
				'label'       => esc_html__( 'Step Text', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Enter step description', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Enter step description', 'elementor-edge' ),
				'rows'        => 3,
			)
		);

		$repeater->add_control(
			'step_status',
			array(
				'label'   => esc_html__( 'Step Status', 'elementor-edge' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'elementor-edge' ),
					'error'   => esc_html__( 'Error', 'elementor-edge' ),
					'warning' => esc_html__( 'Warning', 'elementor-edge' ),
					'success' => esc_html__( 'Success', 'elementor-edge' ),
				),
			)
		);

		$repeater->add_control(
			'step_icon',
			array(
				'label'   => esc_html__( 'Custom Icon', 'elementor-edge' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'step_position',
			array(
				'label'   => esc_html__( 'Position', 'elementor-edge' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'elementor-edge' ),
					'bottom' => esc_html__( 'Bottom', 'elementor-edge' ),
					'left'   => esc_html__( 'Left', 'elementor-edge' ),
					'right'  => esc_html__( 'Right', 'elementor-edge' ),
				),
			)
		);

		$this->add_control(
			'workflow_steps',
			array(
				'label'       => esc_html__( 'Workflow Steps', 'elementor-edge' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'step_text'     => 'It has no idea about your business or product.',
						'step_status'   => 'error',
						'step_position' => 'top',
					),
					array(
						'step_text'     => 'The content is technically correct but completely soulless',
						'step_status'   => 'warning',
						'step_position' => 'right',
					),
					array(
						'step_text'     => 'You rewrite entire paragraphs',
						'step_status'   => 'error',
						'step_position' => 'left',
					),
					array(
						'step_text'     => 'Create visuals in another tool',
						'step_status'   => 'error',
						'step_position' => 'right',
					),
					array(
						'step_text'     => 'Spend forever formatting everything in WordPress',
						'step_status'   => 'warning',
						'step_position' => 'bottom',
					),
				),
				'title_field' => '{{{ step_text }}}',
			)
		);

		$this->end_controls_section();

		// Style Section - General
		$this->start_controls_section(
			'style_general',
			array(
				'label' => esc_html__( 'General', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'workflow_background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-workflow',
			)
		);

		$this->end_controls_section();

		// Style Section - Steps
		$this->start_controls_section(
			'style_steps',
			array(
				'label' => esc_html__( 'Steps', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'step_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .edge-workflow-step-text',
			)
		);

		$this->add_control(
			'step_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .edge-workflow-step-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'step_background',
				'label'    => esc_html__( 'Step Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-workflow-step',
			)
		);

		$this->end_controls_section();

		// Style Section - Connectors
		$this->start_controls_section(
			'style_connectors',
			array(
				'label' => esc_html__( 'Connectors', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['workflow_steps'] ) ) {
			return;
		}

		// Get background image URL (fallback to default if not set)
		$background_image = '';
		if ( ! empty( $settings['workflow_background_image']['url'] ) ) {
			$background_image = esc_url( $settings['workflow_background_image']['url'] );
		} else {
			$background_image = ELEMENTOR_edge_ASSETS . 'images/workflow-bg.png';
		}
		?>
<div class="edge-workflow" style="background-image: url('<?php echo $background_image; ?>');">
	<div class="container">`
		<div class="row">
			<div class="col-md-6">
				<div class="edge-workflow-step wrong-cross">
					<p>It hs no idea about your business or product.</p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="edge-workflow-step b-warning">
					<p>The content is technically correct but completely soulless</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="edge-workflow-step wrong-red">
					<p>You rewrite entire paragraphs</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="edge-workflow-step wrong-yellow">
					<p>Create visuals in another tool </p>
				</div>
			</div>
			<div class="col-md-12">
				<div class="edge-workflow-step right-green">
					<p>Spend forever formatting everything in WordPress</p>
				</div>
			</div>
		</div>

	</div>

		<?php
	}
}
