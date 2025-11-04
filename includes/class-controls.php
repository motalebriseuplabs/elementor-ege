<?php
/**
 * Custom Controls for Elementor edge
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge;

use Elementor\Base_Data_Control;
use Elementor\Control_Choose;
use Elementor\Control_Base_Multiple;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Controls class
 */
class Controls {

	/**
	 * Controls Manager
	 *
	 * @var \Elementor\Controls_Manager
	 */
	private $controls_manager;

	/**
	 * Constructor
	 *
	 * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
	 */
	public function __construct( $controls_manager ) {
		$this->controls_manager = $controls_manager;
		$this->register_controls();
	}

	/**
	 * Register custom controls
	 */
	public function register_controls() {
		// Register Query Control
		$this->controls_manager->register( new Query_Control() );

		// Register Image Choose Control
		$this->controls_manager->register( new Image_Choose_Control() );

		// Register Gradient Control
		$this->controls_manager->register( new Gradient_Control() );
	}
}

/**
 * Query Control Class
 */
class Query_Control extends Base_Data_Control {

	/**
	 * Get control type
	 *
	 * @return string
	 */
	public function get_type() {
		return 'elementor-edge-query';
	}

	/**
	 * Get default settings
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return array(
			'query_type' => 'posts',
			'multiple'   => false,
			'options'    => array(),
		);
	}

	/**
	 * Render control content template
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper elementor-edge-query-control">
				<select id="<?php echo esc_attr( $control_uid ); ?>-type" data-setting="type">
					<option value="posts"><?php esc_html_e( 'Posts', 'elementor-edge' ); ?></option>
					<option value="pages"><?php esc_html_e( 'Pages', 'elementor-edge' ); ?></option>
					<option value="custom"><?php esc_html_e( 'Custom Post Type', 'elementor-edge' ); ?></option>
				</select>
				<input id="<?php echo esc_attr( $control_uid ); ?>-count" type="number" data-setting="count" placeholder="<?php esc_attr_e( 'Number of items', 'elementor-edge' ); ?>" min="1" max="100" />
			</div>
		</div>
		<# if (data.description) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Get default value
	 *
	 * @return array
	 */
	public function get_default_value() {
		return array(
			'type'  => 'posts',
			'count' => 6,
		);
	}
}

/**
 * Image Choose Control Class
 */
class Image_Choose_Control extends Control_Choose {

	/**
	 * Get control type
	 *
	 * @return string
	 */
	public function get_type() {
		return 'elementor-edge-image-choose';
	}

	/**
	 * Render control content template
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-edge-image-choose-control elementor-choices">
					<# _.each( data.options, function( option_data, option_value ) { #>
						<div class="image-option">
							<input id="<?php echo esc_attr( $control_uid ); ?>-{{ option_value }}" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ option_value }}" data-setting="{{ data.name }}">
							<label for="<?php echo esc_attr( $control_uid ); ?>-{{ option_value }}">
								<# if (option_data.image) { #>
									<img src="{{ option_data.image }}" alt="{{ option_data.title }}">
								<# } else { #>
									<i class="{{ option_data.icon }}" aria-hidden="true"></i>
								<# } #>
								<span class="elementor-scredgen-only">{{{ option_data.title }}}</span>
							</label>
						</div>
					<# }); #>
				</div>
			</div>
		</div>
		<# if (data.description) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}

/**
 * Gradient Control Class
 */
class Gradient_Control extends Control_Base_Multiple {

	/**
	 * Get control type
	 *
	 * @return string
	 */
	public function get_type() {
		return 'elementor-edge-gradient';
	}

	/**
	 * Get default value
	 *
	 * @return array
	 */
	public function get_default_value() {
		return array(
			'type'   => 'linear',
			'angle'  => 90,
			'colors' => array(
				array(
					'color'    => '#ff0000',
					'position' => 0,
				),
				array(
					'color'    => '#0000ff',
					'position' => 100,
				),
			),
		);
	}

	/**
	 * Get default settings
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return array(
			'label_block' => true,
			'show_label'  => true,
		);
	}

	/**
	 * Render control content template
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="edge-gradient-picker">
					<div class="edge-gradient-preview"></div>
					<div class="edge-gradient-type">
						<select data-setting="type">
							<option value="linear"><?php esc_html_e( 'Linear', 'elementor-edge' ); ?></option>
							<option value="radial"><?php esc_html_e( 'Radial', 'elementor-edge' ); ?></option>
						</select>
					</div>
					<div class="edge-gradient-angle">
						<label><?php esc_html_e( 'Angle', 'elementor-edge' ); ?></label>
						<input type="range" min="0" max="360" data-setting="angle" />
						<span class="angle-value">90°</span>
					</div>
					<div class="edge-gradient-colors">
						<label><?php esc_html_e( 'Colors', 'elementor-edge' ); ?></label>
						<div class="color-stops">
							<!-- Color stops will be dynamically added here -->
						</div>
						<button type="button" class="add-color-stop"><?php esc_html_e( 'Add Color', 'elementor-edge' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<# if (data.description) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Render control content
	 */
	public function render() {
		$control_uid = $this->get_control_uid();
		$settings    = $this->get_settings();
		$value       = $this->get_value();

		if ( empty( $value ) ) {
			$value = $this->get_default_value();
		}
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">
				<?php echo esc_html( $settings['label'] ); ?>
			</label>
			<div class="elementor-control-input-wrapper">
				<div class="edge-gradient-picker" data-value="<?php echo esc_attr( wp_json_encode( $value ) ); ?>">
					<div class="edge-gradient-preview" style="background: <?php echo esc_attr( $this->generate_gradient_css( $value ) ); ?>"></div>
					<div class="edge-gradient-controls">
						<select name="type" data-setting="type">
							<option value="linear" <?php selected( $value['type'], 'linear' ); ?>><?php esc_html_e( 'Linear', 'elementor-edge' ); ?></option>
							<option value="radial" <?php selected( $value['type'], 'radial' ); ?>><?php esc_html_e( 'Radial', 'elementor-edge' ); ?></option>
						</select>
						<input type="range" name="angle" min="0" max="360" value="<?php echo esc_attr( $value['angle'] ); ?>" data-setting="angle" />
						<span class="angle-value"><?php echo esc_html( $value['angle'] ); ?>°</span>
					</div>
				</div>
			</div>
		</div>
		<?php if ( ! empty( $settings['description'] ) ) : ?>
			<div class="elementor-control-field-description">
				<?php echo wp_kses_post( $settings['description'] ); ?>
			</div>
			<?php
		endif;
	}

	/**
	 * Generate gradient CSS
	 *
	 * @param array $value
	 * @return string
	 */
	private function generate_gradient_css( $value ) {
		if ( empty( $value['colors'] ) || ! is_array( $value['colors'] ) ) {
			return 'transparent';
		}

		$type  = $value['type'] === 'radial' ? 'radial-gradient' : 'linear-gradient';
		$angle = $value['type'] === 'linear' ? $value['angle'] . 'deg, ' : 'circle, ';

		$colors = array();
		foreach ( $value['colors'] as $color_stop ) {
			$colors[] = $color_stop['color'] . ' ' . $color_stop['position'] . '%';
		}

		return $type . '(' . $angle . implode( ', ', $colors ) . ')';
	}
}
