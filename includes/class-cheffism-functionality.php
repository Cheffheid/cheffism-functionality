<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/includes
 * @author     Jeffrey de Wit <Jeffrey.deWit@gmail.com>
 */
class Cheffism_Functionality {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Cheffism_Functionality_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'cheffism-functionality';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->register_post_types();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Cheffism_Functionality_Loader. Orchestrates the hooks of the plugin.
     * - Cheffism_Functionality_i18n.   Defines internationalization functionality.
     * - Cheffism_Functionality_Admin.  Defines all hooks for the admin area.
     * - Cheffism_Functionality_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cheffism-functionality-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cheffism-functionality-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cheffism-functionality-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cheffism-functionality-public.php';

        /**
         * The class responsible for registering custom post types
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cheffism-functionality-cpt.php';

        $this->loader = new Cheffism_Functionality_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Cheffism_Functionality_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Cheffism_Functionality_i18n();
        $plugin_i18n->set_domain( $this->get_plugin_name() );

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Cheffism_Functionality_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'init', $plugin_admin, 'add_taxonomies' );

        $this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_metaboxes' );
        $this->loader->add_action( 'save_post', $plugin_admin, 'save_postdata' );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'cheffism_settings_page');
        $this->loader->add_action( 'admin_init', $plugin_admin, 'cheffism_functionality_register_settings' ); 
        
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Cheffism_Functionality_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_head', $plugin_public, 'cheffism_async_google_analytics' );
        $this->loader->add_action( 'init', $plugin_public, 'cheffism_functions_shortcodes' );

        $this->loader->add_action( 'init', $plugin_public, 'cheffism_add_imagesizes' );

        $this->loader->add_filter( 'single_template', $plugin_public, 'set_project_single_template' );
        $this->loader->add_filter( 'archive_template', $plugin_public, 'set_project_archive_template' );

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Cheffism_Functionality_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Register all custom post types
     *
     * This can probably be improved to work better. I can only imagine how this would look
     * with multiple CPTs.
     * 
     * @since    1.0.0
     * @access   private
     */
    private function register_post_types() {

        $project = new Cheffism_Functionality_CPT( 'Project', 'Projects', 'project' );
        $this->loader->add_action( 'init', $project, 'register_post_type' );

    }

}
