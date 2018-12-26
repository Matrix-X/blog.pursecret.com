<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ninjateam.org
 * @since      1.0.0
 *
 * @package    FileBird
 * @subpackage FileBird/includes
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
 * @package    FileBird
 * @subpackage FileBird/includes
 * @author     Ninja Team <support@ninjateam.org>
 */
class FileBird {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      FileBird_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'filebird';
		$this->version = NJT_FILEBIRD_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - FileBird_Loader. Orchestrates the hooks of the plugin.
	 * - FileBird_i18n. Defines internationalization functionality.
	 * - FileBird_Admin. Defines all hooks for the admin area.
	 * - FileBird_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'translation/filebird-js-translation.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-filebird-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/filebird-walkers.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-filebird-topbar.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-filebird-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-filebird-admin.php';

	
		$this->loader = new FileBird_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the FileBird_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new FileBird_i18n();

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

		$plugin_admin = new FileBird_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'load-upload.php', $plugin_admin, 'nt_upload' );
		$this->loader->add_action( 'init', $plugin_admin, 'filebird_add_folder_to_attachments' );
		$this->loader->add_action('admin_footer-upload.php', $plugin_admin, 'filebird_add_init_media_manager');
		$this->loader->add_action( 'wp_ajax_filebird_ajax_get_folder_list', $plugin_admin, 'filebird_ajax_get_folder_list_callback' );
		$this->loader->add_action( 'wp_ajax_filebird_ajax_update_folder_list', $plugin_admin, 'filebird_ajax_update_folder_list_callback' );
		$this->loader->add_action( 'wp_ajax_filebird_ajax_delete_folder_list', $plugin_admin, 'filebird_ajax_delete_folder_list_callback' );
		$this->loader->add_action( 'wp_ajax_filebird_ajax_update_folder_position', $plugin_admin, 'filebird_ajax_update_folder_position_callback' );
		$this->loader->add_action( 'wp_ajax_filebird_ajax_get_child_folders', $plugin_admin, 'filebird_ajax_get_child_folders_callback' );
		
		$this->loader->add_filter('pre-upload-ui', $plugin_admin, 'filebird_pre_upload_ui');
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
	 * @return    FileBird_Loader    Orchestrates the hooks of the plugin.
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

}
