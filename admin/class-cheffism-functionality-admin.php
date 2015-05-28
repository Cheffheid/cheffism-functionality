<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/admin
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Cheffism_Functionality_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register taxonomies.
     *
     * @since  1.0.0
     */
    public function add_taxonomies() {

        register_taxonomy(
            'platform',
            array('project'),
            array(
                'hierarchical' => true,
                'labels' => array(
                    'name' => __( 'Platforms' ),
                    'singular_name' => __( 'Platform' ),
                    'all_items' => __( 'All Platforms' ),
                    'add_new_item' => __( 'Add Platform' )
                ),
                'public' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'platform'
                )
            )
        );

        register_taxonomy(
            'technologies',
            array('project'),
            array(
                'hierarchical' => false,
                'labels' => array(
                    'name' => __( 'Technologies' ),
                    'singular_name' => __( 'Technology' ),
                    'all_items' => __( 'All Technologies' ),
                    'add_new_item' => __( 'Add Technology' )
                ),
                'public' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'technology'
                )
            )
        );
    }

    /**
     * Add custom metaboxes.
     *
     * @since  1.0.0
     */
    public function add_metaboxes() {
        add_meta_box( 'project_metabox', _('Project Details'), array( $this, 'project_metabox' ), 'project', 'normal', 'high' );
    }


    /**
     * Metabox callback for project post type.
     *
     * @since  1.0.0
     */
    public function project_metabox() {

        global $post;
        extract(get_post_custom($post->ID));
          // Use nonce for verification
        wp_nonce_field( plugin_basename(__FILE__), 'noncename' );

        require plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/project-metabox.php';

    }

    /**
     * Save post data function to handle the saving of custom metaboxes.
     *
     * @since  1.0.0
     * @param  int $post_id The post's ID.
     */
    public function save_postdata( $post_id ) {
        if ( empty($_POST) || 
             $_POST['post_type'] !== 'project' ||
             !wp_verify_nonce( $_POST['noncename'], plugin_basename(__FILE__) ) ) {
                
                return $post_id;
        }

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;


        // Check permissions
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        if($_POST['post_type'] == 'project' ) {
            global $post;

            if ( !in_array('cheffism_in_progress', $_POST) ) {
                update_post_meta($post->ID, 'cheffism_in_progress', '');
            }

            foreach($_POST as $key => $val) {
                update_post_meta($post->ID, $key, $val);
            }
        }
    }

    public function cheffism_settings_page() {
        add_options_page('Cheffism Settings', 'Cheffism Settings', 'manage_options', 'cheffism_settings', array( $this, 'cheffism_functionality_options_page' ) );
    }

    public function cheffism_functionality_options_page() {
        require plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/settings-page.php';
    }

    public function cheffism_functionality_register_settings() {
        register_setting( 'cheffism_functionality_options', 'cheffism_functionality_options', array( $this, 'cheffism_functionality_options_validate' ) );
        add_settings_section('cheffism_functionality_analytics', 'Analytics Settings', array( $this, 'cheffism_analytics_section_text' ), $this->plugin_name);
        add_settings_field('cheffism_analytics_ua', 'Google Analytics UA', array( $this, 'cheffism_analytics_field' ), $this->plugin_name, 'cheffism_functionality_analytics');
    }

    public function cheffism_analytics_section_text() {
        echo '<p>Add your Google Analytics UA code here.</p>';
    } 

    public function cheffism_analytics_field() {
        $options = get_option('cheffism_functionality_options');
        echo "<input id='cheffism_analytics_ua' name='cheffism_functionality_options[cheffism_analytics_ua]' size='40' type='text' value='{$options['cheffism_analytics_ua']}' />";
    }

    function cheffism_functionality_options_validate($input) {
        $newinput['cheffism_analytics_ua'] = trim( $input['cheffism_analytics_ua'] );
        $newinput['cheffism_analytics_ua'] = wp_strip_all_tags( $newinput['cheffism_analytics_ua'] );

        return $newinput;
    }
}
