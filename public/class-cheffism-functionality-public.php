<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/public
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Cheffism_Functionality_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Shortcode registration function.
	 */
	public function cheffism_functions_shortcodes() {
		add_shortcode( 'age', array( $this, 'cheffism_age_function' ) );
	}

	/**
	 * Displays age based on date of birth.
	 *
	 * TODO: Fix different formats.
	 *
	 * @param array $atts Array of shortcode attributes.
	 *
	 * @since    1.0.0
	 */
	public function cheffism_age_function( $atts ) {

		$args = shortcode_atts(
			array(
				'date'   => '11/04/1985',
				'format' => 'dd/MM/YYYY',
			),
			$atts
		);

		$date   = $args['date'];
		$format = $args['format'];

		$date = explode( '/', $date );

		$age = ( gmdate( 'md', gmdate( 'U', mktime( 0, 0, 0, $date[1], $date[0], $date[2] ) ) ) > gmdate( 'md' )
		? ( ( gmdate( 'Y' ) - $date[2] ) - 1 )
		: ( gmdate( 'Y' ) - $date[2] ) );

		return $age;
	}

	/**
	 * Custom image size registration.
	 */
	public function cheffism_add_imagesizes() {
		add_image_size( 'project-thumb', 330, 200, true );
		add_image_size( 'project-featured', 800, 400, false );
		add_image_size( 'project-thumb-s', 220, 160, true );
		add_image_size( 'project-thumb-m', 300, 180, true );
		add_image_size( 'project-thumb-l', 811, 492, true );
	}
}
