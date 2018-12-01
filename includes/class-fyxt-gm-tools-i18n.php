<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.imageinnovationsllc.com/
 * @since      1.0.0
 *
 * @package    Fyxt_Gm_Tools
 * @subpackage Fyxt_Gm_Tools/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fyxt_Gm_Tools
 * @subpackage Fyxt_Gm_Tools/includes
 * @author     Troy Whitney <troy@imageinnovationsllc.com>
 */
class Fyxt_Gm_Tools_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fyxt-gm-tools',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
