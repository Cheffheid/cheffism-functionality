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

	private $single;
	private $plural;
	private $type;

	public function __construct( $single, $plural, $type ) {
		$this->single = $single;
		$this->plural = $plural;
		$this->type   = $type;
	}

	/**
	 * Register the project post type.
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() {

		$labels  = array(
			'name'               => _( $this->plural ),
			'singular_name'      => _( $this->single ),
			'add_new'            => _x( 'Add ' . $this->single, $this->single ),
			'add_new_item'       => _( 'Add New ' . $this->single ),
			'edit_item'          => _( 'Edit ' . $this->single ),
			'new_item'           => _( 'New ' . $this->single ),
			'view_item'          => _( 'View ' . $this->single ),
			'search_items'       => _( 'Search ' . $this->plural ),
			'not_found'          => _( 'No ' . $this->plural . ' Found' ),
			'not_found_in_trash' => _( 'No ' . $this->plural . ' found in Trash' ),
			'parent_item_colon'  => '',
		);
		$options = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => strtolower( $this->plural ) ),
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'has_archive'        => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-desktop',
			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
				'comments',
			),
		);
		register_post_type( $this->type, $options );
	}
}
