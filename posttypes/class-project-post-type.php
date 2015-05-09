<?php

    // If this file is called directly, abort.
    if ( ! defined( 'WPINC' ) ) {
        die;
    }

    new CheffismProjectCPT;

    class CheffismProjectCPT {

        var $single = 'Project';
        var $plural = 'Projects';
        var $type   = 'project';

        function __construct() {
            add_action( 'init', array( $this, 'init' ) );
            add_action( 'init', array( $this, 'add_post_type' ) );
            add_action( 'init', array( $this, 'add_taxonomies' ) );
        
            add_theme_support( 'post-thumbnails', array( $this->type ) );
            add_image_size( strtolower( $this->plural).'-thumb-s', 220, 160, true );
            add_image_size( strtolower( $this->plural).'-thumb-m', 300, 180, true );
            add_image_size( strtolower( $this->plural).'-thumb-l', 811, 492, true );

            add_action( 'add_meta_boxes', array( $this, 'add_custom_metaboxes' ) );

            add_filter( 'single_template', array( $this, 'get_custom_post_type_template' ) );
            add_filter( 'archive_template', array( $this, 'get_custom_post_type_archive_template' ) );

            add_action('save_post', array( $this, 'save_postdata') );
        }

        function init($options = null) {
            if($options) {
                foreach($options as $key => $value) {
                    $this->$key = $value;
                }
            }
        }

        function add_post_type(){
            $labels = array(
                'name' => _x($this->plural, 'post type general name'),
                'singular_name' => _x($this->single, 'post type singular name'),
                'add_new' => _x('Add ' . $this->single, $this->single),
                'add_new_item' => __('Add New ' . $this->single),
                'edit_item' => __('Edit ' . $this->single),
                'new_item' => __('New ' . $this->single),
                'view_item' => __('View ' . $this->single),
                'search_items' => __('Search ' . $this->plural),
                'not_found' =>  __('No ' . $this->plural . ' Found'),
                'not_found_in_trash' => __('No ' . $this->plural . ' found in Trash'),
                'parent_item_colon' => ''
            );
            $options = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => array('slug' => strtolower($this->plural)),
                'capability_type' => 'post',
                'hierarchical' => false,
                'has_archive' => true,
                'menu_position' => null,
                'menu_icon' => 'dashicons-desktop',
                'supports' => array(
                    'title',
                    'editor',
                    #       'author',
                    'thumbnail',
                    #       'excerpt',
                    'comments'
                ),
            );
            register_post_type($this->type, $options);
        }

        function add_taxonomies() {
            register_taxonomy(
                'platform',
                array($this->type),
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
                array($this->type),
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

        function add_custom_metaboxes() {
            add_meta_box( 'metabox1', 'Project Details', array( $this, 'metabox1'), $this->type, 'normal', 'high' );
        }

        function metabox1() {

            global $post;
            extract(get_post_custom($post->ID));
              // Use nonce for verification
            wp_nonce_field( plugin_basename(__FILE__), 'noncename' );

            ?>

            <p>
                <label for="cheffism_in_progress">
                    <input type="checkbox" name="cheffism_in_progress" id="cheffism_in_progress" <?php checked('on', $cheffism_in_progress[0]); ?> /> In Progress?
                </label>
            </p>
            <p>
                <label for="cheffism_project_link">Link</label>
                <input name="cheffism_project_link" id="cheffism_project_link" type="text" value="<?php echo $cheffism_project_link[0]; ?>" /><br />
            </p>
    
            <?php

        }

        function save_postdata( $post_id ) {
            if ( empty($_POST) || 
                 $_POST['post_type'] !== $this->type ||
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

            if($_POST['post_type'] == $this->type) {
                global $post;

                if ( !in_array('cheffism_in_progress', $_POST) ) {
                    update_post_meta($post->ID, 'cheffism_in_progress', '');
                }

                foreach($_POST as $key => $val) {
                    update_post_meta($post->ID, $key, $val);
                }
            }
        }

        function get_custom_post_type_template($single_template) {
            global $post;

            if ( $post->post_type === $this->type ) {
                if ( locate_template('single-' . $this->type . '.php') === '' ) {
                    $single_template = dirname( __FILE__ ) . '/single-project.php';
                }
            }
            return $single_template;
        }

        function get_custom_post_type_archive_template($archive_template) {

            if ( is_post_type_archive($this->type) ) {
                if ( locate_template('archive-' . $this->type . '.php') === '' ) {
                    $archive_template = dirname( __FILE__ ) . '/archive-project.php';
                }
            }
            if ( is_tax('platform') || is_tax('technologies') ) {
                if ( locate_template('taxonomy.php') === '' ) {
                    $archive_template = dirname( __FILE__ ) . '/taxonomy.php';
                }
            }
            return $archive_template;
        } 
   }

    function cheffism_project_footer() {
        do_action('cheffism_project_footer');
    }