<?php
/**
 * Register custom post types
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 */

/**
 * Register custom post types.
 *
 * This class defines all code necessary to register custom post types.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Cheffism_Functionality_CPT {

	/**
	 * Single CPT label.
	 *
	 * @var string
	 */
	private $single;

	/**
	 * Plural CPT label.
	 *
	 * @var string
	 */
	private $plural;

	/**
	 * CPT post type identifier string.
	 *
	 * @var string
	 */
	private $type;

	/**
	 * CPT Labels array.
	 *
	 * @var array
	 */
	private $labels;

	/**
	 * Class constructor.
	 *
	 * @param string $single CPT Singular label.
	 * @param string $plural CPT Plural label.
	 * @param string $type   CPT post type identifier string.
	 * @param array  $labels CPT labels array.
	 */
	public function __construct( $single, $plural, $type, $labels ) {
		$this->single = $single;
		$this->plural = $plural;
		$this->type   = $type;
		$this->labels = $labels;
	}

	/**
	 * Register the project post type.
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() {
		$options = array(
			'labels'                => $this->labels,
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_in_graphql'       => true,
			'rest_base'             => '',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_namespace'        => 'wp/v2',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => strtolower( $this->plural ) ),
			'capability_type'       => 'post',
			'hierarchical'          => false,
			'has_archive'           => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-desktop',
			'supports'              => array(
				'title',
				'editor',
				'thumbnail',
				'comments',
			),
			'graphql_single_name'   => $this->single,
			'graphql_plural_name'   => $this->plural,
		);

		register_post_type( $this->type, $options );
	}
}
