<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Plugin_Name_Deactivator {

	/**
	 * Flush rewrite rules to clear out taxonomies and the like.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
