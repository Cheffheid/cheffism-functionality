<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Display Google Analytics code when WP_DEBUG is set to false.
     *
     * @since    1.0.0
     */
    public function cheffism_async_google_analytics() {

        if ( !WP_DEBUG ) {
            $UA = get_option( 'cheffism_functionality_options', '' );

            require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/cheffism-functionality-analytics.php';
        }
    }

    
    public function cheffism_functions_shortcodes() {
        add_shortcode('age', array( $this, 'cheffism_age_function') );
    }

    /**
     * Displays age based on date of birth
     *
     * TODO: Fix different formats
     *
     * @since    1.0.0
     */
    public function cheffism_age_function($atts) {
        extract(shortcode_atts(array(
          'date' => '11/04/1985',
          'format' => 'dd/MM/YYYY'
        ), $atts));

        //explode the date to get month, day and year
        $date = explode("/", $date);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $date[1], $date[0], $date[2]))) > date("md")
        ? ((date("Y") - $date[2]) - 1)
        : (date("Y") - $date[2]));

        return $age;
    }

}
