<?php

/**
 * The public-facing functionality of the plugin. 
 	This holds the functions to create Adventure Generator, Search, etc. 
	All functions that are ADVENTURE specific go here.
 *
 * @link       http://www.imageinnovationsllc.com/
 * @since      1.0.0
 *
 * @package    Fyxt_Gm_Tools
 * @subpackage Fyxt_Gm_Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fyxt_Gm_Tools
 * @subpackage Fyxt_Gm_Tools/public
 * @author     Troy Whitney <troy@imageinnovationsllc.com>
 */
class Fyxt_Gm_Tools_Adventures {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fyxt_Gm_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fyxt_Gm_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fyxt-gm-tools-public.css', array(), $this->version, 'all' );
		//wp_enqueue_style( 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fyxt_Gm_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fyxt_Gm_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fyxt-gm-tools-public.js', array( 'jquery' ), $this->version, false );
		//wp_enqueue_script( 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}
	
	
	/** add custom funcitons below. 
	* These functions are the main ones to display and organize the other
	* parts of this plugin. 
	*/

	//gets the users list of custom adventures that are NOT contributed
	public function fyxt_get_users_adventures ($fyxt_account_id){
		global $wpdb;
		$sql="
		SELECT
		  fyxt_adventures.idfyxt_adventure,
		  fyxt_adventures.created,
		  fyxt_adventures.updated,
		  fyxt_adventures.adv_name,
		  fyxt_adventures.adv_summary,
		  fyxt_adventures.gm_notes,
		  fyxt_adventures.adv_story,
		  fyxt_adventures.owner_id,
		  fyxt_adventures.public,
		  fyxt_adventures.web_include,
		  fyxt_adventures.verified,
		  fyxt_adventures.creater_user_id
		FROM
		  fyxt_adventures
		WHERE
		  fyxt_adventures.owner_id = 1 AND
		  fyxt_adventures.web_include = 0 AND
		  fyxt_adventures.verified = $fyxt_account_id
		ORDER BY
		  fyxt_adventures.updated DESC";
		$result= $wpdb->get_results("$sql");
		return $result;
	}
	
}