<?php
/**
 * Plugin Name: WP Widgets Shortcode
 * Author: Brajesh Singh
 * Plugin URI: http://buddydev.com/plugins/wp-widgets-shortcode/
 * Author URI: http://buddydev.com/members/sbrajesh/
 * Version: 1.0.2
 * License: GPL
 * Description: Embed any widget area(dynamic sidebar) to your WordPress pages/posts using the shortcode [widget-area id='The Name of Widget Area']
 */

/**
 * Class BD_Widgets_Shortcode_Helper
 */
class BD_Widgets_Shortcode_Helper {

	/**
	 * Class instance.
	 *
	 * @var BD_Widgets_Shortcode_Helper
	 */
	private static $instance;

	/**
	 * The constructor.
	 */
	private function __construct() {
		$this->register_shortcodes();
	}

	/**
	 * Register ShortCodes
	 */
	private function register_shortcodes() {

		// Use [widget-area id='something'] or [dynamic-sidebar id=something].
		add_shortcode( 'widget-area', array( $this, 'generate_widget_area' ) );

		// Use [widget-area id='somewidgetarea' ][/widget-area].
		add_shortcode( 'dynamic-sidebar', array( $this, 'generate_widget_area' ) );
	}

	/**
	 * Get class instance
	 *
	 * @return BD_Widgets_Shortcode_Helper
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Render widget content
	 *
	 * @param array  $atts      Attributes.
	 * @param string $content   Content widget start and ending tag.
	 *
	 * @return string
	 */
	public function generate_widget_area( $atts, $content = '' ) {

		$atts = shortcode_atts( array(
			'id'        => '',
			'before'    => '',
			'after'     => '',
		), $atts );

		$id = trim( $atts['id'] );

		ob_start();

		echo $atts['before'];

		dynamic_sidebar( $id );

		echo $atts['after'];

		$content = ob_get_clean();

		return $content;
	}
}

BD_Widgets_Shortcode_Helper::get_instance();

