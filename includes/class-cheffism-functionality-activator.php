<?php
/**
 * Fired during plugin activation
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Cheffism_Functionality_Activator {

	/**
	 * Flush rewrite rules to activate new taxonomies and the like.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
	}
}
