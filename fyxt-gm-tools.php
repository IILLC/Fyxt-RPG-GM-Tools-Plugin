<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.imageinnovationsllc.com/
 * @since             1.0.0
 * @package           Fyxt_Gm_Tools
 *
 * @wordpress-plugin
 * Plugin Name:       Fyxt GM Tools
 * Plugin URI:        https://fyxtrpg.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Troy Whitney
 * Author URI:        http://www.imageinnovationsllc.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fyxt-gm-tools
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fyxt-gm-tools-activator.php
 */
function activate_fyxt_gm_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fyxt-gm-tools-activator.php';
	Fyxt_Gm_Tools_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fyxt-gm-tools-deactivator.php
 */
function deactivate_fyxt_gm_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fyxt-gm-tools-deactivator.php';
	Fyxt_Gm_Tools_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fyxt_gm_tools' );
register_deactivation_hook( __FILE__, 'deactivate_fyxt_gm_tools' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fyxt-gm-tools.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fyxt_gm_tools() {

	$plugin = new Fyxt_Gm_Tools();
	$plugin->run();

}
run_fyxt_gm_tools();
