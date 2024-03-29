<?php
/**
 * This file defines the fields for the metabox used on the Project CPT.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/partials
 */

?>
<p>
	<label for="cheffism_in_progress">
		<input type="checkbox" name="cheffism_in_progress" id="cheffism_in_progress" <?php checked( 'on', $cheffism_in_progress ); ?> />
		<?php esc_html_e( 'In Progress?', 'cheffism' ); ?>
	</label>
</p>
<p>
	<label for="cheffism_project_link">
		<?php esc_html_e( 'Link', 'cheffism' ); ?>
	</label>
	<input name="cheffism_project_link" id="cheffism_project_link" type="text" value="<?php echo esc_attr( $cheffism_project_link ); ?>" /><br />
</p>
