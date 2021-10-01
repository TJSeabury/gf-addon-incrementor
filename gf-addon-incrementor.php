<?php

/**
 *
 * @since             1.0.0
 * @package           gf_addon_incrementor
 * @author     		  Tyler Seabury <tyler@marketmentors.com>
 *
 * @wordpress-plugin
 * Plugin Name:       GF Addon Incrementor
 * Plugin URI:        http://example.com/gf-addon-incrementor-uri/
 * Description:       This is a Gravity Forms addon that adds a meta field with a definable auto-incrementing value.
 * Version:           1.0.0
 * Author:            Market Mentors
 * Author URI:        http://marketmentors.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gf-addon-incrementor
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
define( 'GF_ADDON_INCREMENTOR_VERSION', '1.0.0' );
define( 'GF_ADDON_INCREMENTOR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gf-addon-incrementor-activator.php
 */
function activate_gf_addon_incrementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gf-addon-incrementor-activator.php';
	gf_addon_incrementor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gf-addon-incrementor-deactivator.php
 */
function deactivate_gf_addon_incrementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gf-addon-incrementor-deactivator.php';
	gf_addon_incrementor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gf_addon_incrementor' );
register_deactivation_hook( __FILE__, 'deactivate_gf_addon_incrementor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gf-addon-incrementor.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gf_addon_incrementor() {

	$plugin = new gf_addon_incrementor();
	$plugin->run();

}
run_gf_addon_incrementor();
