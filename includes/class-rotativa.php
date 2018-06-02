<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://rotativahq.com/
 * @since      1.0.0
 *
 * @package    Rotativa
 * @subpackage Rotativa/includes
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
 * @package    Rotativa
 * @subpackage Rotativa/includes
 * @author     RotativaHQ <info@rotativahq.com>
 */
class Rotativa {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rotativa_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'ROTATIVA_VERSION' ) ) {
			$this->version = ROTATIVA_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'rotativa';

		$this->rotativa_load_dependencies();
		$this->rotativa_set_locale();
		$this->rotativa_define_admin_hooks();
		$this->rotativa_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Rotativa_Loader. Orchestrates the hooks of the plugin.
	 * - Rotativa_i18n. Defines internationalization functionality.
	 * - Rotativa_Admin. Defines all hooks for the admin area.
	 * - Rotativa_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rotativa_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rotativa-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rotativa-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rotativa-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rotativa-public.php';

		$this->loader = new Rotativa_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rotativa_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rotativa_set_locale() {

		$plugin_i18n = new Rotativa_i18n();

		$this->loader->rotativa_add_action( 'plugins_loaded', $plugin_i18n, 'rotativa_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rotativa_define_admin_hooks() {

		$plugin_admin = new Rotativa_Admin( $this->rotativa_get_plugin_name(), $this->rotativa_get_version() );

		// Hook our settings page
		$this->loader->rotativa_add_action( 'admin_menu', $plugin_admin, 'rotativa_register_settings_page' );

		// Hook our settings
		$this->loader->rotativa_add_action( 'admin_init', $plugin_admin, 'rotativa_register_settings' );

		$this->loader->rotativa_add_action( 'admin_enqueue_scripts', $plugin_admin, 'rotativa_enqueue_styles' );
		$this->loader->rotativa_add_action( 'admin_enqueue_scripts', $plugin_admin, 'rotativa_enqueue_scripts' );

		// Hook our plugin links
		$this->loader->rotativa_add_action( 'plugin_action_links_rotativa/rotativa.php', $plugin_admin, 'rotativa_action_links' );

		$this->loader->rotativa_add_action( 'add_meta_boxes', $plugin_admin, 'rotativa_register_metabox' );

		$this->loader->rotativa_add_action( 'wp_ajax_rotativa_ajax_generate_pdf', $plugin_admin, 'rotativa_ajax_generate_pdf' );
		$this->loader->rotativa_add_action( 'wp_ajax_nopriv_rotativa_ajax_generate_pdf', $plugin_admin, 'rotativa_ajax_generate_pdf' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rotativa_define_public_hooks() {

		$plugin_public = new Rotativa_Public( $this->rotativa_get_plugin_name(), $this->rotativa_get_version() );

		$this->loader->rotativa_add_action( 'wp_enqueue_scripts', $plugin_public, 'rotativa_enqueue_styles' );
		$this->loader->rotativa_add_action( 'wp_enqueue_scripts', $plugin_public, 'rotativa_enqueue_scripts' );

		$this->loader->rotativa_add_shortcode( 'rotativa-generate-pdf', $plugin_public, 'rotativa_generate_pdf_shortcode' );

        $this->loader->rotativa_add_action( 'wp_ajax_rotativa_ajax_generate_pdf_fe', $plugin_public, 'rotativa_ajax_generate_pdf_fe' );
        $this->loader->rotativa_add_action( 'wp_ajax_nopriv_rotativa_ajax_generate_pdf_fe', $plugin_public, 'rotativa_ajax_generate_pdf_fe' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function rotativa_run() {
		$this->loader->rotativa_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function rotativa_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Rotativa_Loader    Orchestrates the hooks of the plugin.
	 */
	public function rotativa_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function rotativa_get_version() {
		return $this->version;
	}

}
