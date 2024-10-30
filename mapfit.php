<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mapfit.com
 * @since             1.0.0
 * @package           Mapfit
 *
 * @wordpress-plugin
 * Plugin Name:       Mapfit Maps 
 * Plugin URI:        https://mapfit.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.3
 * Author:            Mapfit Inc
 * Author URI:        https://mapfit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mapfit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MAPFIT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mapfit-activator.php
 */
function activate_mapfit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mapfit-activator.php';
	Mapfit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mapfit-deactivator.php
 */
function deactivate_mapfit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mapfit-deactivator.php';
	Mapfit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mapfit' );
register_deactivation_hook( __FILE__, 'deactivate_mapfit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mapfit.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mapfit() {

	$plugin = new mapfit();
	$plugin->run();

}
run_mapfit();
