<?php

/**
 * The public-facing lists needed for the functionality of the plugin.
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
class Fyxt_Gm_Tools_Public_Lists {

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
	
	//////////////adding custom class code here
	

	
	//gets the users list of campaigns
	public function fyxt_get_users_campaigns ($fyxt_account_id){
		global $wpdb;
		$sql="SELECT
		  fyxt_campaigns.idfyxt_campaigns,
		  fyxt_campaigns.created,
		  fyxt_campaigns.updated,
		  fyxt_campaigns.camp_name,
		  fyxt_campaigns.camp_overview,
		  fyxt_campaigns.camp_story,
		  fyxt_campaigns.camp_gm_info,
		  fyxt_campaigns.creator_id,
		  fyxt_campaigns.public
		FROM
		  fyxt_campaigns
		WHERE
		  fyxt_campaigns.creator_id = $fyxt_account_id
		ORDER BY
		  fyxt_campaigns.updated DESC";
		$result= $wpdb->get_results("$sql");
		return $result;
	}
	
	
} 

function fyxt_get_account_awarded($fyxt_account_id, $content_type) {
	global $wpdb;
	$sql = "
	SELECT
	  fyxt_user_account_data.fyxt_user_account_notes,
	  fyxt_user_account_data.fyxt_user_account_option_value,
	  fyxt_user_account_limits_list.fyxt_account_options_name
	FROM
	  fyxt_user_account_data
	  INNER JOIN fyxt_user_account_limits_list ON fyxt_user_account_limits_list.idfyxt_account_options_list =
		fyxt_user_account_data.fyxt_user_account_option
	WHERE
	  fyxt_user_account_data.fyxt_user_account_id = $fyxt_account_id AND
	  fyxt_user_account_data.fyxt_user_account_option = $content_type";
	$results = $wpdb->get_results($sql);
	
	return $results;
	
}
	
?>



