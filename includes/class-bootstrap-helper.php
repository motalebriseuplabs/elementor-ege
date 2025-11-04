<?php
/**
 * Bootstrap Helper Class
 *
 * @package Elementoredge
 * @since 1.0.0
 */

namespace Elementoredge;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Bootstrap_Helper
 *
 * Provides Bootstrap utility methods and components
 *
 * @since 1.0.0
 */
class Bootstrap_Helper {

	/**
	 * Bootstrap Version
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const BOOTSTRAP_VERSION = '5.3.2';

	/**
	 * Get Bootstrap Button Classes
	 *
	 * @since 1.0.0
	 * @param string $variant Button variant (primary, secondary, success, etc.).
	 * @param string $size Button size (sm, lg).
	 * @param bool   $outline Whether to use outline style.
	 * @return string
	 */
	public static function get_button_classes( $variant = 'primary', $size = '', $outline = false ) {
		$classes = array( 'btn' );

		if ( $outline ) {
			$classes[] = 'btn-outline-' . $variant;
		} else {
			$classes[] = 'btn-' . $variant;
		}

		if ( ! empty( $size ) ) {
			$classes[] = 'btn-' . $size;
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Card Classes
	 *
	 * @since 1.0.0
	 * @param string $border_variant Border variant (primary, secondary, etc.).
	 * @param string $text_variant Text variant (primary, secondary, etc.).
	 * @param string $bg_variant Background variant (primary, secondary, etc.).
	 * @return string
	 */
	public static function get_card_classes( $border_variant = '', $text_variant = '', $bg_variant = '' ) {
		$classes = array( 'card' );

		if ( ! empty( $border_variant ) ) {
			$classes[] = 'border-' . $border_variant;
		}

		if ( ! empty( $text_variant ) ) {
			$classes[] = 'text-' . $text_variant;
		}

		if ( ! empty( $bg_variant ) ) {
			$classes[] = 'bg-' . $bg_variant;
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Alert Classes
	 *
	 * @since 1.0.0
	 * @param string $variant Alert variant (success, danger, warning, info).
	 * @param bool   $dismissible Whether alert is dismissible.
	 * @return string
	 */
	public static function get_alert_classes( $variant = 'info', $dismissible = false ) {
		$classes = array( 'alert', 'alert-' . $variant );

		if ( $dismissible ) {
			$classes[] = 'alert-dismissible';
			$classes[] = 'fade';
			$classes[] = 'show';
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Badge Classes
	 *
	 * @since 1.0.0
	 * @param string $variant Badge variant (primary, secondary, etc.).
	 * @param bool   $pill Whether to use pill style.
	 * @return string
	 */
	public static function get_badge_classes( $variant = 'primary', $pill = false ) {
		$classes = array( 'badge', 'bg-' . $variant );

		if ( $pill ) {
			$classes[] = 'rounded-pill';
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Grid Column Classes
	 *
	 * @since 1.0.0
	 * @param array $breakpoints Associative array of breakpoint => column count.
	 * @return string
	 */
	public static function get_column_classes( $breakpoints = array() ) {
		$classes = array();

		foreach ( $breakpoints as $breakpoint => $columns ) {
			if ( $breakpoint === 'xs' ) {
				$classes[] = 'col-' . $columns;
			} else {
				$classes[] = 'col-' . $breakpoint . '-' . $columns;
			}
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Text Classes
	 *
	 * @since 1.0.0
	 * @param string $color Text color (primary, secondary, success, etc.).
	 * @param string $alignment Text alignment (start, center, end).
	 * @param string $size Text size (fs-1, fs-2, etc.).
	 * @return string
	 */
	public static function get_text_classes( $color = '', $alignment = '', $size = '' ) {
		$classes = array();

		if ( ! empty( $color ) ) {
			$classes[] = 'text-' . $color;
		}

		if ( ! empty( $alignment ) ) {
			$classes[] = 'text-' . $alignment;
		}

		if ( ! empty( $size ) ) {
			$classes[] = $size;
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get Bootstrap Spacing Classes
	 *
	 * @since 1.0.0
	 * @param array $spacing Spacing configuration.
	 * @return string
	 */
	public static function get_spacing_classes( $spacing = array() ) {
		$classes = array();

		foreach ( $spacing as $property => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $breakpoint => $size ) {
					if ( $breakpoint === 'xs' ) {
						$classes[] = $property . '-' . $size;
					} else {
						$classes[] = $property . '-' . $breakpoint . '-' . $size;
					}
				}
			} else {
				$classes[] = $property . '-' . $value;
			}
		}

		return implode( ' ', $classes );
	}

	/**
	 * Generate Bootstrap Modal HTML
	 *
	 * @since 1.0.0
	 * @param string $id Modal ID.
	 * @param string $title Modal title.
	 * @param string $content Modal content.
	 * @param array  $options Modal options.
	 * @return string
	 */
	public static function generate_modal( $id, $title, $content, $options = array() ) {
		$size       = isset( $options['size'] ) ? 'modal-' . $options['size'] : '';
		$centered   = isset( $options['centered'] ) && $options['centered'] ? 'modal-dialog-centered' : '';
		$scrollable = isset( $options['scrollable'] ) && $options['scrollable'] ? 'modal-dialog-scrollable' : '';

		$dialog_classes = array_filter( array( 'modal-dialog', $size, $centered, $scrollable ) );

		ob_start();
		?>
		<div class="modal fade" id="<?php echo esc_attr( $id ); ?>" tabindex="-1" aria-labelledby="<?php echo esc_attr( $id ); ?>Label" aria-hidden="true">
			<div class="<?php echo esc_attr( implode( ' ', $dialog_classes ) ); ?>">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="<?php echo esc_attr( $id ); ?>Label"><?php echo esc_html( $title ); ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<?php echo wp_kses_post( $content ); ?>
					</div>
					<?php if ( isset( $options['footer'] ) ) : ?>
					<div class="modal-footer">
						<?php echo wp_kses_post( $options['footer'] ); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Generate Bootstrap Tooltip Attributes
	 *
	 * @since 1.0.0
	 * @param string $text Tooltip text.
	 * @param string $placement Tooltip placement (top, bottom, left, right).
	 * @return string
	 */
	public static function get_tooltip_attributes( $text, $placement = 'top' ) {
		return sprintf(
			'data-bs-toggle="tooltip" data-bs-placement="%s" title="%s"',
			esc_attr( $placement ),
			esc_attr( $text )
		);
	}

	/**
	 * Generate Bootstrap Popover Attributes
	 *
	 * @since 1.0.0
	 * @param string $title Popover title.
	 * @param string $content Popover content.
	 * @param string $placement Popover placement (top, bottom, left, right).
	 * @return string
	 */
	public static function get_popover_attributes( $title, $content, $placement = 'top' ) {
		return sprintf(
			'data-bs-toggle="popover" data-bs-placement="%s" data-bs-title="%s" data-bs-content="%s"',
			esc_attr( $placement ),
			esc_attr( $title ),
			esc_attr( $content )
		);
	}

	/**
	 * Check if Bootstrap is loaded
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function is_bootstrap_loaded() {
		global $wp_styles, $wp_scripts;

		$css_loaded = isset( $wp_styles->registered['elementor-edge-bootstrap'] ) ||
						isset( $wp_styles->registered['elementor-edge-admin-bootstrap'] );

		$js_loaded = isset( $wp_scripts->registered['elementor-edge-bootstrap'] ) ||
					isset( $wp_scripts->registered['elementor-edge-admin-bootstrap'] );

		return $css_loaded && $js_loaded;
	}

	/**
	 * Get Bootstrap Icon Classes
	 *
	 * @since 1.0.0
	 * @param string $icon Icon name (without bi- prefix).
	 * @param string $size Icon size (small, medium, large).
	 * @return string
	 */
	public static function get_icon_classes( $icon, $size = '' ) {
		$classes = array( 'bi', 'bi-' . $icon );

		if ( ! empty( $size ) ) {
			switch ( $size ) {
				case 'small':
					$classes[] = 'fs-6';
					break;
				case 'medium':
					$classes[] = 'fs-4';
					break;
				case 'large':
					$classes[] = 'fs-2';
					break;
			}
		}

		return implode( ' ', $classes );
	}
}
