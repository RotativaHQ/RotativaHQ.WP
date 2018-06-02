<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rotativahq.com/
 * @since             1.0.0
 * @package           Rotativa
 *
 * @wordpress-plugin
 * Plugin Name:       Rotativa
 * Plugin URI:        https://wordpress.org/plugins/search/rotativa/
 * Description:       Convert HTML to PDF in the cloud in a extremely easy and fast way.
 * Version:           1.1.0
 * Author:            RotativaHQ
 * Author URI:        https://rotativahq.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rotativa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ROTATIVA_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rotativa-activator.php
 */
function activate_rotativa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rotativa-activator.php';
	Rotativa_Activator::rotativa_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rotativa-deactivator.php
 */
function deactivate_rotativa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rotativa-deactivator.php';
	Rotativa_Deactivator::rotativa_deactivate();
}

register_activation_hook( __FILE__, 'activate_rotativa' );
register_deactivation_hook( __FILE__, 'deactivate_rotativa' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rotativa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rotativa() {

	$plugin = new Rotativa();
	$plugin->rotativa_run();

}
run_rotativa();
