<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://inside.sas.com
 * @since             1.0.0
 * @package           Sww_Ux
 *
 * @wordpress-plugin
 * Plugin Name:       UX Testing Form
 * Plugin URI:        http://inside.sas.com
 * Description:       Generates a form on the front end, for self-reporting an informal usability test. Note: CMB2 must be installed and active.
 * Version:           1.1
 * Author:            Sarah Ovenall, SAS Intranet Team
 * Author URI:        http://inside.sas.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sww-ux
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sww-ux-activator.php
 */
function activate_sww_ux() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sww-ux-activator.php';
	Sww_Ux_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sww-ux-deactivator.php
 */
function deactivate_sww_ux() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sww-ux-deactivator.php';
	Sww_Ux_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sww_ux' );
register_deactivation_hook( __FILE__, 'deactivate_sww_ux' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sww-ux.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sww_ux() {

	$plugin = new Sww_Ux();
	$plugin->run();

}
run_sww_ux();
