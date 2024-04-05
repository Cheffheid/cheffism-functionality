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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register taxonomies.
	 *
	 * @since  1.0.0
	 */
	public function add_taxonomies() {

		register_taxonomy(
			'platform',
			array( 'project' ),
			array(
				'hierarchical' => true,
				'labels'       => array(
					'name'          => __( 'Platforms' ),
					'singular_name' => __( 'Platform' ),
					'all_items'     => __( 'All Platforms' ),
					'add_new_item'  => __( 'Add Platform' ),
				),
				'public'       => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => 'platform',
				),
			)
		);

		register_taxonomy(
			'technologies',
			array( 'project' ),
			array(
				'hierarchical' => false,
				'labels'       => array(
					'name'          => __( 'Technologies' ),
					'singular_name' => __( 'Technology' ),
					'all_items'     => __( 'All Technologies' ),
					'add_new_item'  => __( 'Add Technology' ),
				),
				'public'       => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => 'technology',
				),
			)
		);
	}

	/**
	 * Add custom metaboxes.
	 *
	 * @since  1.0.0
	 */
	public function add_metaboxes() {
		add_meta_box( 'project_metabox', esc_html__( 'Project Details', 'cheffism' ), array( $this, 'project_metabox' ), 'project', 'normal', 'high' );
	}


	/**
	 * Metabox callback for project post type.
	 *
	 * @since  1.0.0
	 */
	public function project_metabox() {

		global $post;

		$cheffism_in_progress  = get_post_meta( $post->ID, 'cheffism_in_progress', true );
		$cheffism_project_link = get_post_meta( $post->ID, 'cheffism_project_link', true );

		// Use nonce for verification.
		wp_nonce_field( plugin_basename( __FILE__ ), 'project_nonce' );

		if ( ! $cheffism_in_progress ) {
			$cheffism_in_progress = '';
		}

		if ( ! $cheffism_project_link ) {
			$cheffism_project_link = '';
		}

		require plugin_dir_path( __DIR__ ) . '/admin/partials/project-metabox.php';
	}

	/**
	 * Save post data function to handle the saving of custom metaboxes.
	 *
	 * @since  1.0.0
	 * @param  int $post_id The post's ID.
	 */
	public function save_postdata( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) ) {
			if ( empty( $_POST ) ||
				'project' !== $_POST['post_type'] ||
				! wp_verify_nonce( $_POST['project_nonce'], plugin_basename( __FILE__ ) ) ) {

					return $post_id;
			}

			if ( 'project' === $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id; }

			if ( 'project' === $_POST['post_type'] ) {
				global $post;

				if ( ! in_array( 'cheffism_in_progress', $_POST, true ) ) {
					update_post_meta( $post->ID, 'cheffism_in_progress', '' );
				}

				foreach ( $_POST as $key => $val ) {
					update_post_meta( $post->ID, $key, $val );
				}
			}
		}
	}

	/**
	 * Update the allowed mimetypes for media library uploads.
	 *
	 * @since  3.0.0
	 * @param array $mimetypes Array of allowed mimetypes.
	 * @return array
	 */
	public function update_allowed_mimetypes( $mimetypes ) {
		$mimetypes['webp'] = 'image/webp';

		return $mimetypes;
	}
}
