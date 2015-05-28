<div class="wrap">
    <h2>Cheffism Plugin Options</h2>
    
    <form action="options.php" method="post">
        <?php settings_fields('cheffism_functionality_options'); ?>
        <?php do_settings_sections($this->plugin_name); ?>
 
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
</div>