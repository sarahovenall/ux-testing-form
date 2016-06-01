<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://inside.sas.com
 * @since      1.0.0
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sww_Ux
 * @subpackage Sww_Ux/includes
 * @author     Sarah Ovenall, the SWW Team <sarah.ovenall@sas.com>
 */
class Sww_Ux_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sww-ux',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
