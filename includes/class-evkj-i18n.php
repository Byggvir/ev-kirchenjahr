<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://byggvir-de
 * @since      1.0.0
 * @version		2023.1
 * @package    Evkj
 * @subpackage Evkj/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Evkj
 * @subpackage Evkj/includes
 * @author     Thomas Arend <thomas@arend-rhb.de>
 */
class Evkj_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 2019.3.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'evkj',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
