<?php
/**
 * Plugin entry point file.
 *
 * @link              http://jeffreydewit.com
 * @since             1.0.0
 * @package           Cheffism_Functions
 *
 * @wordpress-plugin
 * Plugin Name:       Cheffism Functionality
 * Description:       Collection of theme-agnostic functionality that I use on my website
 * Version:           3.0
 * Author:            Jeffrey de Wit
 * Author URI:        http://jeffreydewit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cheffism-functions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_cheffism_functionality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cheffism-functionality-activator.php';
	Cheffism_Functionality_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_cheffism_functionality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cheffism-functionality-deactivator.php';
	Cheffism_Functionality_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cheffism_functionality' );
register_deactivation_hook( __FILE__, 'deactivate_cheffism_functionality' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cheffism-functionality.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cheffism_functionality() {

	$plugin = new Cheffism_Functionality();
	$plugin->run();
}
run_cheffism_functionality();
