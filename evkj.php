<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://byggvir-de
 * @since             2019.2.1
 * @package           Evkj
 *
 * @wordpress-plugin
 * Plugin Name:       Kirchenjahr evangelisch
 * Plugin URI:        https://github.com/Byggvir/ev-kirchenjahr
 * Description:       Zeigt den Evangelischen Liturgischen Kalender in einem Widget in der Seitenleiste an. 
 * Version:           2019.2.4
 * Author:            Thomas Arend
 * Author URI:        https://byggvir.de/wordpress/ev-kirchenjahr/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       evkj
 * Domain Path:       /languages
 * Slug:              kirchenjahr_evangelisch
 */

// If this file is called directly, abort.

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define( 'EVKJ_VERSION'  , '2019.2.4' ) ;

define( 'EVKJ_CACHETAB' , 'evkj_cache' ) ;

define( 'EVKJ_URL'      , 'https://liturgischer-kalender.bayern-evangelisch.de/widget/widget.php' ) ;

define( 'EVKJ_PATH'     , plugin_dir_path( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-evkj-activator.php
 */
function activate_evkj() {
	require_once EVKJ_PATH . 'includes/class-evkj-activator.php';
	Evkj_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-evkj-deactivator.php
 */
function deactivate_evkj() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-evkj-deactivator.php';
	Evkj_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_evkj' );
register_deactivation_hook( __FILE__, 'deactivate_evkj' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-evkj.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2019.0.0
 */
function run_evkj() {

	$plugin = new Evkj();
	$plugin->run();

}

    /**
     * Embedd Widget
     *
     * @since    2019.0.0
     */
	require_once EVKJ_PATH . 'public/class-widget.php';

	/**
     * Embedd Shortcode.
     *
     * @since    2019.1.0
     */

	require_once EVKJ_PATH . 'public/class-shortcodes.php';

run_evkj();
