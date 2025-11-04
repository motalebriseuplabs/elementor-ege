<?php
/**
 * Banner Widget
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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Banner_Widget
 *
 * @since 1.0.0
 */
class Banner_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elementor-edge-banner';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Banner Widget', 'elementor-edge' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-banner';
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
		return array( 'banner', 'hero', 'promo', 'marketing', 'cta', 'video' );
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
				'label' => esc_html__( 'Content', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'badge_text',
			array(
				'label'       => esc_html__( 'Badge Text', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '#1 AI Content Marketing Plugin In WordPress', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Enter badge text', 'elementor-edge' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Stop Writing Content That Doesn\'t Rank', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Enter your title', 'elementor-edge' ),
				'rows'        => 3,
			)
		);

		$this->add_control(
			'highlight_word',
			array(
				'label'       => esc_html__( 'Highlight Word', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Content', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Word to highlight in purple', 'elementor-edge' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Google has changed the game. People-first content now outranks keyword-stuffed AI posts. WriteRush helps you create content that sounds human, ranks on Google, and converts readers without becoming a prompt enginedger yourself.', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Enter description', 'elementor-edge' ),
				'rows'        => 5,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Join Waitlist', 'elementor-edge' ),
				'placeholder' => esc_html__( 'Enter button text', 'elementor-edge' ),
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'elementor-edge' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'elementor-edge' ),
				'default'     => array(
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'Video URL', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter video URL (YouTube, Vimeo, etc.)', 'elementor-edge' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'video_poster',
			array(
				'label'     => esc_html__( 'Video Poster Image', 'elementor-edge' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'video_url!' => '',
				),
			)
		);

		$this->add_control(
			'background_image',
			array(
				'label'   => esc_html__( 'Background Image', 'elementor-edge' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => ELEMENTOR_edge_ASSETS . 'images/banner.png',
				),
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
				'name'     => 'background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-banner',
				'default'  => 'gradient',
			)
		);

		$this->add_responsive_control(
			'padding',
			array(
				'label'      => esc_html__( 'Padding', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 80,
					'right'  => 40,
					'bottom' => 80,
					'left'   => 40,
					'unit'   => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'min_height',
			array(
				'label'      => esc_html__( 'Min Height', 'elementor-edge' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1000,
					),
					'vh' => array(
						'min' => 50,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'vh',
					'size' => 80,
				),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Badge
		$this->start_controls_section(
			'style_badge',
			array(
				'label' => esc_html__( 'Badge', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .edge-banner__badge',
			)
		);

		$this->add_control(
			'badge_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__badge' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'badge_background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-banner__badge',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'badge_border',
				'label'    => esc_html__( 'Border', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-banner__badge',
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 20,
					'right'  => 20,
					'bottom' => 20,
					'left'   => 20,
					'unit'   => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 8,
					'right'  => 16,
					'bottom' => 8,
					'left'   => 16,
					'unit'   => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'badge_margin',
			array(
				'label'      => esc_html__( 'Margin', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 20,
					'left'   => 0,
					'unit'   => 'px',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Title
		$this->start_controls_section(
			'style_title',
			array(
				'label' => esc_html__( 'Title', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .edge-banner__title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2c2c2c',
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'title_highlight_color',
			array(
				'label'     => esc_html__( 'Highlight Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8B5CF6',
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__title .highlight' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 20,
					'left'   => 0,
					'unit'   => 'px',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Description
		$this->start_controls_section(
			'style_description',
			array(
				'label' => esc_html__( 'Description', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .edge-banner__description',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__description' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 30,
					'left'   => 0,
					'unit'   => 'px',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Button
		$this->start_controls_section(
			'style_button',
			array(
				'label' => esc_html__( 'Button', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'elementor-edge' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .edge-banner__button',
			)
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_normal',
			array(
				'label' => esc_html__( 'Normal', 'elementor-edge' ),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-banner__button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			array(
				'label' => esc_html__( 'Hover', 'elementor-edge' ),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .edge-banner__button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_hover_background',
				'label'    => esc_html__( 'Background', 'elementor-edge' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .edge-banner__button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'label'    => esc_html__( 'Border', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-banner__button',
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 25,
					'right'  => 25,
					'bottom' => 25,
					'left'   => 25,
					'unit'   => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 15,
					'right'  => 30,
					'bottom' => 15,
					'left'   => 30,
					'unit'   => 'px',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-banner__button',
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 40,
					'left'   => 0,
					'unit'   => 'px',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Video
		$this->start_controls_section(
			'style_video',
			array(
				'label' => esc_html__( 'Video', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'video_width',
			array(
				'label'      => esc_html__( 'Width', 'elementor-edge' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 200,
						'max' => 800,
					),
					'%'  => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__video' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'video_max_width',
			array(
				'label'      => esc_html__( 'Max Width', 'elementor-edge' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 600,
				),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__video' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'video_border',
				'label'    => esc_html__( 'Border', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-banner__video',
			)
		);

		$this->add_responsive_control(
			'video_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elementor-edge' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .edge-banner__video'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .edge-banner__video img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 15,
					'right'  => 15,
					'bottom' => 15,
					'left'   => 15,
					'unit'   => 'px',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'video_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-banner__video',
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

		// Button link attributes
		$button_link_attrs = '';
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button_link', $settings['button_link'] );
			$button_link_attrs = $this->get_render_attribute_string( 'button_link' );
		}

		// Highlight word in title
		$title = $settings['title'];
		if ( ! empty( $settings['highlight_word'] ) ) {
			$title = str_replace( $settings['highlight_word'], '<span class="highlight">' . $settings['highlight_word'] . '</span>', $title );
		}
		?>

<section id="eldg-banner"
	style="background-image: url('<?php echo ! empty( $settings['background_image']['url'] ) ? esc_url( $settings['background_image']['url'] ) : ELEMENTOR_edge_ASSETS . 'images/banner.png'; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
	<div class="container text-center">
		<div class="eldg-banner-content">
			<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
			<div class="eldg-banner-sub-heading">
				<h1 class="eldg-banner-heading-tag"><?php echo esc_html( $settings['badge_text'] ); ?></h1>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['title'] ) ) : ?>
			<h2 class="eldg-banner-heading"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
			<p class="eldg-banner-para"><?php echo esc_html( $settings['description'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
			<div class="eldg-banner-button">
				<a
					<?php echo wp_kses_post( $button_link_attrs ); ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
			</div>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $settings['video_url'] ) ) : ?>
		<div class="eldg-youtube">
			<?php
			// Extract video ID from YouTube URL
			$video_id = '';
			if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $settings['video_url'], $matches ) ) {
				$video_id = $matches[1];
			}

			if ( $video_id ) :
				// Check if we have a custom poster image, otherwise use YouTube thumbnail
				$poster_url = '';
				if ( ! empty( $settings['video_poster']['url'] ) ) {
					$poster_url = $settings['video_poster']['url'];
				} else {
					$poster_url = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
				}
				?>
			<div class="eldg-video-container" data-video-id="<?php echo esc_attr( $video_id ); ?>">
				<div class="eldg-video-poster" style="background-image: url('<?php echo esc_url( $poster_url ); ?>');">
					<button class="eldg-video-play-btn" aria-label="Play Video">
						<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="40" cy="40" r="40" fill="rgba(255, 255, 255, 0.9)" />
							<path d="M35 25L60 40L35 55V25Z" fill="#FF0000" />
						</svg>
					</button>
				</div>
				<iframe width="100%" height="651" src=""
					data-src="https://www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?autoplay=1"
					title="YouTube video player" frameborder="0"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
					referrerpolicy="strict-origin-when-cross-origin" allowfullscredgen style="display: none;">
				</iframe>
			</div>
			<?php else : ?>
			<p><?php esc_html_e( 'Please enter a valid YouTube URL in the widget settings.', 'elementor-edge' ); ?></p>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
		<?php
	}
}
