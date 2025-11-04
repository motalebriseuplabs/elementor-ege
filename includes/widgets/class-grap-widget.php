<?php
/**
 * Circular Diagram Widget - User Types Around Central Logo
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grap_Widget
 *
 * @since 1.0.0
 */
class Grap_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elementor-edge-grap';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Circular Diagram', 'elementor-edge' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-circle';
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
		return array( 'circular', 'diagram', 'users', 'center', 'logo' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// Content Section - Center Logo
		$this->start_controls_section(
			'center_logo_section',
			array(
				'label' => esc_html__( 'Center Logo', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'center_logo_text',
			array(
				'label'   => esc_html__( 'Logo Text', 'elementor-edge' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'WR',
			)
		);

		$this->add_control(
			'center_logo_image',
			array(
				'label' => esc_html__( 'Logo Image (Optional)', 'elementor-edge' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->end_controls_section();

		// Content Section - User Types
		$this->start_controls_section(
			'user_types_section',
			array(
				'label' => esc_html__( 'User Types', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$user_repeater = new Repeater();

		$user_repeater->add_control(
			'user_type_title',
			array(
				'label'   => esc_html__( 'User Type Title', 'elementor-edge' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Content Marketers',
			)
		);

		// Individual radius control to allow staggered positioning for pixel-perfect layout.
		$user_repeater->add_control(
			'position_radius',
			array(
				'label'   => esc_html__( 'Position Radius', 'elementor-edge' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 120,
						'max' => 300,
					),
				),
				'default' => array(
					'size' => 210,
				),
			)
		);

		$user_repeater->add_control(
			'badge_color',
			array(
				'label'   => esc_html__( 'Badge Color', 'elementor-edge' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'purple',
				'options' => array(
					'purple' => esc_html__( 'Purple', 'elementor-edge' ),
					'blue'   => esc_html__( 'Blue', 'elementor-edge' ),
					'green'  => esc_html__( 'Green', 'elementor-edge' ),
					'orange' => esc_html__( 'Orange', 'elementor-edge' ),
					'pink'   => esc_html__( 'Pink', 'elementor-edge' ),
					'brown'  => esc_html__( 'Brown', 'elementor-edge' ),
				),
			)
		);

		$user_repeater->add_control(
			'position_angle',
			array(
				'label'   => esc_html__( 'Position (Degrees)', 'elementor-edge' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 0,
						'max' => 360,
					),
				),
				'default' => array(
					'size' => 0,
				),
			)
		);

		$this->add_control(
			'user_types',
			array(
				'label'       => esc_html__( 'User Types', 'elementor-edge' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $user_repeater->get_controls(),
				'default'     => array(
					array(
						'user_type_title' => 'Content Marketers',
						'badge_color'     => 'purple',
						'position_angle'  => array( 'size' => 0 ),
						'position_radius' => array( 'size' => 305 ),
					),
					array(
						'user_type_title' => 'Ecommerce Businesses',
						'badge_color'     => 'pink',
						'position_angle'  => array( 'size' => 210 ),
						'position_radius' => array( 'size' => 305 ),
					),
					array(
						'user_type_title' => 'Freelancers',
						'badge_color'     => 'blue',
						'position_angle'  => array( 'size' => 30 ),
						'position_radius' => array( 'size' => 305 ),
					),
					array(
						'user_type_title' => 'Founders & Entrepreneurs',
						'badge_color'     => 'orange',
						'position_angle'  => array( 'size' => 85 ),
						'position_radius' => array( 'size' => 305 ),
					),
					array(
						'user_type_title' => 'Beginners',
						'badge_color'     => 'purple',
						'position_angle'  => array( 'size' => 260 ),
						'position_radius' => array( 'size' => 205 ),
					),
					array(
						'user_type_title' => 'Agencies',
						'badge_color'     => 'brown',
						'position_angle'  => array( 'size' => 225 ),
						'position_radius' => array( 'size' => 205 ),
					),
					array(
						'user_type_title' => 'Content Writers',
						'badge_color'     => 'green',
						'position_angle'  => array( 'size' => 125 ),
						'position_radius' => array( 'size' => 205 ),
					),
					array(
						'user_type_title' => 'Bloggers',
						'badge_color'     => 'blue',
						'position_angle'  => array( 'size' => 180 ),
						'position_radius' => array( 'size' => 245 ),
					),
				),
				'title_field' => '{{{ user_type_title }}}',
			)
		);

		$this->end_controls_section();

		// Style Section - General
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General Styling', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'diagram_size',
			array(
				'label'     => esc_html__( 'Diagram Size', 'elementor-edge' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 300,
						'max' => 800,
					),
				),
				'default'   => array(
					'size' => 500,
				),
				'selectors' => array(
					'{{WRAPPER}} .edge-circular-diagram' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'widget_background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-grap-widget',
			)
		);

		$this->end_controls_section();

		// Style Section - Center Logo
		$this->start_controls_section(
			'center_logo_style_section',
			array(
				'label' => esc_html__( 'Center Logo Styling', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'center_logo_size',
			array(
				'label'     => esc_html__( 'Logo Size', 'elementor-edge' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 60,
						'max' => 150,
					),
				),
				'default'   => array(
					'size' => 100,
				),
				'selectors' => array(
					'{{WRAPPER}} .center-logo' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'center_logo_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .center-logo .logo-text',
			)
		);

		$this->end_controls_section();

		// Style Section - User Badges
		$this->start_controls_section(
			'user_badges_style_section',
			array(
				'label' => esc_html__( 'User Badges Styling', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .user-badge .badge-text',
			)
		);

		$this->add_control(
			'badge_radius',
			array(
				'label'   => esc_html__( 'Badge Radius', 'elementor-edge' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min' => 120,
						'max' => 250,
					),
				),
				'default' => array(
					'size' => 180,
				),
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

		if ( empty( $settings['user_types'] ) ) {
			return;
		}

		$badge_radius = isset( $settings['badge_radius']['size'] ) ? $settings['badge_radius']['size'] : 180;

		// Determine the maximum individual radius among user types to use as reference for orbit dots.
		$max_radius = $badge_radius;
		foreach ( $settings['user_types'] as $ut ) {
			if ( isset( $ut['position_radius']['size'] ) && $ut['position_radius']['size'] > $max_radius ) {
				$max_radius = $ut['position_radius']['size'];
			}
		}
		?>
<div class="edge-grap-widget">
	<div class="edge-circular-diagram">
		<!-- Static Orbit Rings -->
		<div class="background-circles">
			<div class="circle circle-outer"></div>
			<div class="circle circle-mid"></div>
			<div class="circle circle-inner"></div>
		</div>

		<!-- Layered Center Core -->
		<div class="center-core">
			<div class="core-layer layer-1"></div>
			<div class="core-layer layer-2"></div>
			<div class="core-layer layer-3"></div>
			<div class="center-logo">
				<?php if ( ! empty( $settings['center_logo_image']['url'] ) ) : ?>
				<img src="<?php echo esc_url( $settings['center_logo_image']['url'] ); ?>"
					alt="<?php echo esc_attr( $settings['center_logo_text'] ); ?>" class="logo-image" />
				<?php else : ?>
				<div class="logo-text"><?php echo esc_html( $settings['center_logo_text'] ); ?></div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Orbit dots - positioned via CSS -->
		<div class="orbit-dots">
			<span class="orbit-dot orbit-dot-1 orbit-dot-green"></span>
			<span class="orbit-dot orbit-dot-2 orbit-dot-red"></span>
			<span class="orbit-dot orbit-dot-3 orbit-dot-orange"></span>
			<span class="orbit-dot orbit-dot-4 orbit-dot-green"></span>
			<span class="orbit-dot orbit-dot-5 orbit-dot-purple"></span>
			<span class="orbit-dot orbit-dot-6 orbit-dot-blue"></span>
			<span class="orbit-dot orbit-dot-7 orbit-dot-purple"></span>
			<span class="orbit-dot orbit-dot-8 orbit-dot-purple"></span>
		</div>

		<!-- User Type Badges (white pills) -->
		<div class="user-badges-container">
			<?php foreach ( $settings['user_types'] as $index => $user_type ) : ?>
				<?php
					$angle       = isset( $user_type['position_angle']['size'] ) ? $user_type['position_angle']['size'] : 0;
					$item_radius = isset( $user_type['position_radius']['size'] ) ? $user_type['position_radius']['size'] : $badge_radius;
					$x           = $item_radius * cos( deg2rad( $angle - 90 ) );
					$y           = $item_radius * sin( deg2rad( $angle - 90 ) );
					$color_class = ! empty( $user_type['badge_color'] ) ? 'badge-' . sanitize_html_class( $user_type['badge_color'] ) : 'badge-purple';
				?>
			<div class="user-badge <?php echo esc_attr( $color_class ); ?>"
				style="--translate-x: <?php echo $x; ?>px; --translate-y: <?php echo $y; ?>px;">
				<div class="badge-text"><?php echo esc_html( $user_type['user_type_title'] ); ?></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
		<?php
	}
}
