<?php
/**
 * Button Widget
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Button Widget Class
 */
class Button_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'edge-button';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Edge Button', 'elementor-edge' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return array( 'elementor-edge' );
	}

	/**
	 * Get widget keywords.
	 */
	public function get_keywords() {
		return array( 'button', 'link', 'cta', 'download', 'circular' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Button', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'   => esc_html__( 'Icon', 'elementor-edge' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-arrow-down',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'       => esc_html__( 'Link', 'elementor-edge' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'elementor-edge' ),
				'default'     => array(
					'url' => '#',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Button
		$this->start_controls_section(
			'button_style',
			array(
				'label' => esc_html__( 'Button Style', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'elementor-edge' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'elementor-edge' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'elementor-edge' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'elementor-edge' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .edge-button-widget' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'      => esc_html__( 'Button Size', 'elementor-edge' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => 80,
				),
				'selectors'  => array(
					'{{WRAPPER}} .edge-button-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'elementor-edge' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 16,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 32,
				),
				'selectors'  => array(
					'{{WRAPPER}} .edge-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .edge-button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6624E3',
				'selectors' => array(
					'{{WRAPPER}} .edge-button-inner' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .edge-button-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .edge-button-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ring_1_color',
			array(
				'label'     => esc_html__( 'Ring 1 Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(102, 36, 227, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .edge-button-ring-1' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ring_2_color',
			array(
				'label'     => esc_html__( 'Ring 2 Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(102, 36, 227, 0.15)',
				'selectors' => array(
					'{{WRAPPER}} .edge-button-ring-2' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_shadow',
				'label'    => esc_html__( 'Box Shadow', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-button-inner',
			)
		);

		$this->end_controls_section();

		// Hover Effects
		$this->start_controls_section(
			'hover_style',
			array(
				'label' => esc_html__( 'Hover Effects', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label'   => esc_html__( 'Hover Animation', 'elementor-edge' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale',
				'options' => array(
					'none'   => esc_html__( 'None', 'elementor-edge' ),
					'scale'  => esc_html__( 'Scale', 'elementor-edge' ),
					'rotate' => esc_html__( 'Rotate', 'elementor-edge' ),
					'pulse'  => esc_html__( 'Pulse', 'elementor-edge' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$link     = $settings['button_link'];
		$animation_class = 'hover-' . $settings['hover_animation'];

		// Link attributes
		$this->add_render_attribute( 'button-link', 'class', 'edge-button-link' );
		if ( ! empty( $link['url'] ) ) {
			$this->add_link_attributes( 'button-link', $link );
		}
		?>
		<div class="edge-button-widget">
			<a <?php echo $this->get_render_attribute_string( 'button-link' ); ?>>
				<div class="edge-button-container <?php echo esc_attr( $animation_class ); ?>">
					<!-- Outer Ring 2 -->
					<div class="edge-button-ring-2"></div>
					<!-- Middle Ring 1 -->
					<div class="edge-button-ring-1"></div>
					<!-- Inner Button -->
					<div class="edge-button-inner">
						<span class="edge-button-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], array( 'aria-hidden' => 'true' ) ); ?>
						</span>
					</div>
				</div>
			</a>
		</div>
		<?php
	}
}
