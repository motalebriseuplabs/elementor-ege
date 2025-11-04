<?php
/**
 * Tab Image Widget
 *
 * @package Elementor_Edge
 */

namespace Elementoredge\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tab Image Widget Class
 */
class Tab_Image_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'edge-tab-image';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Tab Image', 'elementor-edge' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return array( 'elementor-edge' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		// Content Section - Tabs
		$this->start_controls_section(
			'tabs_section',
			array(
				'label' => esc_html__( 'Tabs', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_number',
			array(
				'label'   => esc_html__( 'Tab Number', 'elementor-edge' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '01',
			)
		);

		$repeater->add_control(
			'tab_title',
			array(
				'label'       => esc_html__( 'Tab Title (HTML allowed)', 'elementor-edge' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Tab Title',
				'description' => esc_html__( 'You can use HTML tags like <br> for line breaks', 'elementor-edge' ),
			)
		);

		$repeater->add_control(
			'tab_image',
			array(
				'label'   => esc_html__( 'Tab Content Image', 'elementor-edge' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'tabs',
			array(
				'label'       => esc_html__( 'Tab Items', 'elementor-edge' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'tab_number' => '01',
						'tab_title'  => 'Give your topic & blog input',
					),
					array(
						'tab_number' => '02',
						'tab_title'  => 'Choose your brand voice',
					),
					array(
						'tab_number' => '03',
						'tab_title'  => 'Generate the content',
					),
					array(
						'tab_number' => '04',
						'tab_title'  => 'Create Outline Based on SEO insights',
					),
					array(
						'tab_number' => '05',
						'tab_title'  => 'Get Complete Draft with images',
					),
				),
				'title_field' => '{{{ tab_number }}} - {{{ tab_title }}}',
			)
		);

		$this->end_controls_section();

		// Style Section - Tab Menu
		$this->start_controls_section(
			'tab_menu_style',
			array(
				'label' => esc_html__( 'Tab Menu', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tab_menu_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .edge-tab-menu' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_title_typography',
				'label'    => esc_html__( 'Title Typography', 'elementor-edge' ),
				'selector' => '{{WRAPPER}} .edge-tab-item-title',
			)
		);

		$this->end_controls_section();

		// Style Section - Tab Content
		$this->start_controls_section(
			'tab_content_style',
			array(
				'label' => esc_html__( 'Tab Content', 'elementor-edge' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'elementor-edge' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3f0ff',
				'selectors' => array(
					'{{WRAPPER}} .edge-tab-content' => 'background-color: {{VALUE}};',
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
		?>
		<div class="edge-tab-image-widget">
			<!-- Tab Menu -->
			<div class="edge-tab-menu">
				<?php foreach ( $settings['tabs'] as $index => $tab ) : ?>
					<div class="edge-tab-item <?php echo 0 === $index ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( $index ); ?>">
						<div class="edge-tab-number"><?php echo esc_html( $tab['tab_number'] ); ?></div>
						<div class="edge-tab-item-title"><?php echo wp_kses_post( $tab['tab_title'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Tab Content -->
			<div class="edge-tab-content-wrapper">
				<?php foreach ( $settings['tabs'] as $index => $tab ) : ?>
					<div class="edge-tab-content <?php echo 0 === $index ? 'active' : ''; ?>" data-content="<?php echo esc_attr( $index ); ?>">
						<?php if ( ! empty( $tab['tab_image']['url'] ) ) : ?>
							<img src="<?php echo esc_url( $tab['tab_image']['url'] ); ?>" alt="<?php echo esc_attr( $tab['tab_title'] ); ?>" class="edge-tab-image" />
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
