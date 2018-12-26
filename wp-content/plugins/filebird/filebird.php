<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ninjateam.org


 * @since             1.7
 * @package           File_Bird
 *
 * @wordpress-plugin
 * Plugin Name:       FileBird Lite
 * Plugin URI:        https://media-folder.ninjateam.org
 * Description:       Media Library Categories/Folders File Manager for WordPress. <strong><a href="https://goo.gl/8e19F6">GET PRO VERSION</a></strong>
 * Version:           1.7
 * Author:            Ninja Team
 * Author URI:        https://ninjateam.org
 * Text Domain:       filebird
 * Domain Path:       /languages
 */
// ini_set('display_errors','Off');
// ini_set('error_reporting', E_ALL );
// define('WP_DEBUG', false);
// define('WP_DEBUG_DISPLAY', false);
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'NJT_FILEBIRD_FOLDER' ) ) {
	define( 'NJT_FILEBIRD_FOLDER', 'nt_wmc_folder' );
}

if ( ! defined( 'NJT_FILEBIRD_VERSION' ) ) {
	define( 'NJT_FILEBIRD_VERSION', '2.1.5' );
}
$filebird_plugin_dir = plugin_dir_path( __FILE__ );
if ( ! defined( 'NJT_FILEBIRD_PLUGIN_PATH' ) ) {
	define( 'NJT_FILEBIRD_PLUGIN_PATH', $filebird_plugin_dir );
}

define( 'NJT_FILEBIRD_PLUGIN_URL', plugins_url() . '/' . basename( plugin_dir_path( __FILE__ ) ) );
	
if ( ! defined( 'NJT_FILEBIRD_TEXT_DOMAIN' ) ) {
	define( 'NJT_FILEBIRD_TEXT_DOMAIN', 'filebird' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-filebird-activator.php
 */
function filebird_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-filebird-activator.php';
	FileBird_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-filebird-deactivator.php
 */
function filebird_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-filebird-deactivator.php';
	FileBird_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'filebird_activate' );
register_deactivation_hook( __FILE__, 'filebird_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-filebird.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function filebird_run() {

	$plugin = new FileBird();
	$plugin->run();

}
filebird_run();