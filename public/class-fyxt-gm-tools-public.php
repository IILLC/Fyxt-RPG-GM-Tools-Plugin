<?php

/**
 * The public-facing functionality of the plugin.
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
class Fyxt_Gm_Tools_Public {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fyxt-gm-tools-public.css', array(), $this->version, 'all' );
	
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
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fyxt-gm-tools-public.js', array( 'jquery' ), $this->version, false );
		
	}
	
	
	/** add custom funcitons below. 
	* These functions are the main ones to display and organize the other
	* parts of this plugin. 
	*/


	//function to see if debugging is enabled on the website
	function debug( $fyxt_account_id ) {
		global $wpdb;
		$debugSQL = "
		SELECT
		  fyxt_website_options.option_value
		FROM
		  fyxt_website_options
		WHERE
		  fyxt_website_options.option_name = 'debug'";
		$debugResults = $wpdb->get_var( $debugSQL );

		if ( $debugResults == 1 ) {
			//check to see if user is DEBUGGER so that can see debugging info.
			$debuggerSQL = "
			SELECT
			  fyxt_user_account_data.fyxt_user_account_option_value
			FROM
			  fyxt_user_account_data
			WHERE
			  fyxt_user_account_data.fyxt_user_account_id = $fyxt_account_id And
			  fyxt_user_account_data.fyxt_user_account_option = 18";
			$debuggerResult = $wpdb->get_var( $debuggerSQL );
			if ( $debuggerResult == 1 ) {
				$debug = true;
			}
			else {
				$debug = false;
			}
		}
		return $debug;
	}
	
	/////// function to check if user is a supermoderator
	public function fyxt_check_if_super_moderator( $fyxt_account_id = 0 ) {
		global $wpdb;
		$superModSQL = "
		SELECT
		  Count( fyxt_user_account_data.idfyxt_user_account_data )
		FROM
		  fyxt_user_account_data
		WHERE
		  fyxt_user_account_data.fyxt_user_account_id = $fyxt_account_id And
		  fyxt_user_account_data.fyxt_user_account_option = 17 And
		  fyxt_user_account_data.fyxt_user_account_option_value = 1
		GROUP BY
		  fyxt_user_account_data.fyxt_user_account_id,
		  fyxt_user_account_data.fyxt_user_account_option,
		  fyxt_user_account_data.fyxt_user_account_option_value";
		$superModResults = $wpdb->get_var( $superModSQL );
		return $superModResults;
	}

	
	///// function to reurn if premium subscriber for extra actions and funcitons
	public function fyxt_check_premium_subscription() {
		global $current_user;
		get_currentuserinfo(); 

		$subscription = false;
		if(pmpro_hasMembershipLevel(array(2,3,4,5,6))) {
			$subscription = true;	
		}
		return $subscription;
	}


	//echos a login or signup section if someone is trying to use something they have to be signed in for. 
	public function fyxt_login_form(){
		ob_start();
	?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="../../../../css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">

		<div class="alert alert-warning" role="alert">
			<h3>Oops! You must be logged in to FyxtRPG.com to use this page.</h3>
		</div>

		<?php wp_login_form(); ?>

		<div class="alert alert-warning" role="alert">
			<h3>If you don't have an account, no problem! Click the button below to sign up for a new Free Fyxt RPG account.</h3>
		</div>
		
		<button type="button" class="btn-dark btn-lg btn-block">
			<a href="/fyxt-rpg-account/fyxt-rpg-membership-checkout/?level=1" title="Sign up for Fyxt RPG for Free!"><strong>Sign up for Free!</strong></a>
		</button>

	<?php
		return ob_get_clean();
	}

	
	//Function to retrieve how many of any custom content an account can have
	function fyxt_AccountOptLimit ( $fyxtAccountID, $opID ) {
		if ( ( !empty( $fyxtAccountID ) ) && ( !empty( $opID ) ) ){
			global $wpdb;
			$subInfo = pmpro_getMembershipLevelForUser( $fyxtAccountID );
			$subLevel = $subInfo->id;

			if ( $subLevel < 1 ){
				$subLevel = 0;
			}

			$option_name_sql="SELECT
			  fyxt_user_account_limits_list.fyxt_account_options_name
			FROM
			  fyxt_user_account_limits_list
			WHERE
			  fyxt_user_account_limits_list.idfyxt_account_options_list = $opID";
			$option_name = $wpdb->get_var( $option_name_sql );

			//this gets the default limit for the account
			$getLimitSQL = "
			Select
			  Sum( fyxt_user_account_defaults.fyxt_user_account_value )
			From
			  fyxt_user_account_limits_list Inner Join
			  fyxt_user_account_defaults
				On fyxt_user_account_limits_list.idfyxt_account_options_list
				= fyxt_user_account_defaults.idfyxt_account_options_list
			Where
			  fyxt_user_account_defaults.fyxt_user_account_sub_level = $subLevel
			  And
			  fyxt_user_account_defaults.idfyxt_account_options_list = $opID" ; 
			$getDefaultCount = $wpdb->get_var( $getLimitSQL );

			//this gets the amount that has been bought
			$accountPurchasesSQL = "
			Select
			  Sum( fyxt_user_account_data.fyxt_user_account_option_value )
			From
			  fyxt_user_account_data
			Where
			  fyxt_user_account_data.fyxt_user_account_id = $fyxtAccountID And
			  fyxt_user_account_data.fyxt_user_account_option = $opID And
			fyxt_user_account_data.fyxt_user_account_data_additionID = 1";
			$accountPurchasesResults = $wpdb->get_var( $accountPurchasesSQL );
			
			if ( empty( $accountPurchasesResults ) ){ $accountPurchasesResults = 0; }

			//This gets the amount that has been gifted.
			//This is for Fyxt contests and prizes, things that we can give away for participation etc.
			$accountGiftsSQL = "
			Select
			  Sum( fyxt_user_account_data.fyxt_user_account_option_value )
			From
			  fyxt_user_account_data
			Where
			  fyxt_user_account_data.fyxt_user_account_id = $fyxtAccountID And
			  fyxt_user_account_data.fyxt_user_account_option = $opID And
			fyxt_user_account_data.fyxt_user_account_data_additionID > 1";
			$accountGiftResults = $wpdb->get_var( $accountGiftsSQL );
			
			if ( empty( $accountGiftResults ) ){ $accountGiftResults = 0; } //sets to 0 for display

			//account earned bonus for accepted Fyxt Contributions
			$earnedOptionIDs = array( 1,9,12,16,30,45,46,47 ); //1 PC, 9 NPC, 12 ITEMS, 16 POWERS, 30 Friends, 45 Campaign,46 Adventure,47 Encounter
			if ( in_array( $opID,$earnedOptionIDs ) ) { //this sets so this query only runs if additional can be earned
				$contNumbToGetPerSQL = "
				Select
				  fyxt_user_account_earned_bonus.fyxt_user_account_earned_bonus_value
				From
				  fyxt_user_account_earned_bonus
				Where
				  fyxt_user_account_earned_bonus.fyxt_user_account_earned_bonus_optionID = $opID";
				$contNumbToGetPerResults = $wpdb->get_var( $contNumbToGetPerSQL );
				$optCanEarnMore = 'Yes';

				//need a switch to look in different tables depending on option PC/NPC is smame, powers, items
				if ( $opID == 1 ) { //PC
					//contributed characters
					$userPCContSQL = "
					Select
					  Count( fyxt_characters.idfyxt_character ) As pcs,
					  Sum( fyxt_character_cards.fyxt_cc_char_level ) As pc_lvls
					From
					  fyxt_characters Inner Join
					  fyxt_character_cards On fyxt_character_cards.fyxt_cc_charID =
						fyxt_characters.idfyxt_character
					Where
					  fyxt_characters.public_char = 1 And
					  fyxt_characters.web_include = 1 And
					  fyxt_characters.verified = 1 And
					  fyxt_characters.wp_userid = 0 And
					  fyxt_characters.fyxt_pc = 1 And
					  fyxt_characters.fyxt_creator_id = $fyxtAccountID";
					$userPCContResults = $wpdb->get_row( $userPCContSQL );
					$pcNum = $userPCContResults->pcs;
					$pcLevels = $userPCContResults->pc_lvls;
					$earned = floor( $userPCContResults->pc_lvls/$contNumbToGetPerResults );

					//current custom characters
					$user_custom_pc_sql = "
					SELECT
					  Count( fyxt_characters.idfyxt_character ) AS pcs
					FROM
					  fyxt_characters
					WHERE
					  fyxt_characters.web_include = 0 AND
					  fyxt_characters.verified = 0 AND
					  fyxt_characters.wp_userid = $fyxtAccountID AND
					  fyxt_characters.fyxt_pc = 1 ";
					$user_custom_pc_results = $wpdb->get_var( $user_custom_pc_sql );
					$custom_content_amount = $user_custom_pc_results;
				}
				elseif ( $opID == 9 ) { //NPC
					//checks for NPCs that have been contributed
					$userNPCContSQL = "
					Select
					  Count( fyxt_characters.idfyxt_character ) As npcs,
					  Sum( fyxt_character_cards.fyxt_cc_char_level ) As npc_lvls
					From
					  fyxt_characters Inner Join
					  fyxt_character_cards On fyxt_character_cards.fyxt_cc_charID =
						fyxt_characters.idfyxt_character
					Where
					  fyxt_characters.public_char = 1 And
					  fyxt_characters.web_include = 1 And
					  fyxt_characters.verified = 1 And
					  fyxt_characters.wp_userid = 0 And
					  fyxt_characters.fyxt_pc = 0 And
					  fyxt_characters.fyxt_creator_id = $fyxtAccountID";
					$userNPCContResults = $wpdb->get_row( $userNPCContSQL );
					$npcNum = $userNPCContResults->npcs;
					$npcLevels = $userNPCContResults->npc_lvls;
					$earned = floor( $userNPCContResults->npc_lvls/$contNumbToGetPerResults );

					//checks for current custom NPCs 
					$user_custom_npc_sql = "
					SELECT
					  Count( fyxt_characters.idfyxt_character ) AS npcs
					FROM
					  fyxt_characters
					WHERE
					  fyxt_characters.web_include = 0 AND
					  fyxt_characters.verified = 0 AND
					  fyxt_characters.wp_userid = $fyxtAccountID AND
					  fyxt_characters.fyxt_pc = 0";
					$user_custom_npc_results = $wpdb->get_var( $user_custom_npc_sql );
					$custom_content_amount = $user_custom_npc_results;
				}
				elseif ( $opID == 12 ) { //Items
					$userItemContSQL = "
					Select
					  Count( fyxt_items.idfyxt_items )
					From
					  fyxt_items
					Where
					  fyxt_items.web_include = 1 And
					  fyxt_items.verified = 1 And
					  fyxt_items.creator_id = 0 And
					  fyxt_items.fyxt_items_sur_id = $fyxtAccountID";
					$contItems = $wpdb->get_var( $userItemContSQL );

					$custom_content_amount = $contItems; 

					if ( ( $contItems > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $contItems/$contNumbToGetPerResults );
					}
				}
				elseif ( $opID == 16 ) { //POWER
					//checks for contributed Powers
					$userPowerContSQL = "
					Select
					  Count( fyxt_powers.idpowers )
					From
					  fyxt_powers
					Where
					  fyxt_powers.web_include = 1 And
					  fyxt_powers.verified = 1 And
					  fyxt_powers.wp_userid = 0 And
					  fyxt_powers.creator_user_id = $fyxtAccountID And
					  fyxt_powers.fyxt_power_public = 1
					Group By
					  fyxt_powers.web_include,
					  fyxt_powers.verified,
					  fyxt_powers.wp_userid,
					  fyxt_powers.creator_user_id,
					  fyxt_powers.fyxt_power_public";
					$contPowers = $wpdb->get_var( $userPowerContSQL );
					if ( ( $contPowers > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $contPowers/$contNumbToGetPerResults );
					}

					//checks for current custom Powers
					$user_custom_power_sql = "
					SELECT
					  Count( fyxt_powers.idpowers )
					FROM
					  fyxt_powers
					WHERE
					  fyxt_powers.web_include = 0 AND
					  fyxt_powers.verified = 0 AND
					  fyxt_powers.wp_userid = $fyxtAccountID";
					$user_custom_power_result = $wpdb->get_var( $user_custom_power_sql );

					$custom_content_amount = $user_custom_power_result;
				}
				elseif ( $opID == 30 ) { //friends
					$userFriendSQL = "
					Select
					  Count( fyxt_friend_activity.fyxt_friend_responded )
					From
					  fyxt_friend_activity
					Where
					  ( fyxt_friend_activity.fyxt_friend_recipient = $fyxtAccountID ) Or
					  ( fyxt_friend_activity.fyxt_friend_requesting = $fyxtAccountID )";
					$userFriendResults = $wpdb->get_var( $userFriendSQL );

					$custom_content_amount = $userFriendResults;

					if ( ( $userFriendResults > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $userFriendResults/$contNumbToGetPerResults );
					}
				}
				///////// adding GM tools here //////////// campaigns = 45, Adventures = 46, Encounters = 47
				//checks for contributed Campaigns
				elseif ( $opID == 45 ) { //campaign
					$user_contributed_campaign_sql = "
					SELECT
					  Count( fyxt_campaigns.idfyxt_campaigns ) AS Count_idfyxt_campaigns
					FROM
					  fyxt_campaigns
					WHERE
					  fyxt_campaigns.owner_id = 0 AND
					  fyxt_campaigns.public = 1 AND
					  fyxt_campaigns.web_include = 1 AND
					  fyxt_campaigns.verified = 1 AND
					  fyxt_campaigns.creator_user_id = $fyxtAccountID";
					$contributed_custom_campaigns = $wpdb->get_var( $user_contributed_campaign_sql );
					if ( ( $contributed_custom_campaigns > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $contributed_custom_campaigns/$contNumbToGetPerResults );
					}

					//checks for current custom Powers
					$user_custom_campaign_sql = "
					SELECT
					  Count( fyxt_campaigns.idfyxt_campaigns ) AS Count_idfyxt_campaigns
					FROM
					  fyxt_campaigns
					WHERE
					  fyxt_campaigns.owner_id = $fyxtAccountID AND
					  fyxt_campaigns.web_include = 0 AND
					  fyxt_campaigns.verified = 0";
					$user_custom_campaign_result = $wpdb->get_var( $user_custom_campaign_sql );

					$custom_content_amount = $user_custom_campaign_result;
			}
			//checks for contributed Adventures
			elseif ( $opID == 46 ) { //Adventure
					$user_contributed_adventures_sql = "
					SELECT
					  Count( fyxt_adventures.idfyxt_adventure ) AS Count_idfyxt_adventure
					FROM
					  fyxt_adventures
					WHERE
					  fyxt_adventures.owner_id = 0 AND
					  fyxt_adventures.public = 1 AND
					  fyxt_adventures.web_include = 1 AND
					  fyxt_adventures.verified = 1 AND
					  fyxt_adventures.creator_user_id = $fyxtAccountID";
					$contributed_custom_adventures = $wpdb->get_var( $user_contributed_adventures_sql );
					if ( ( $contributed_custom_adventures > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $contributed_custom_adventures/$contNumbToGetPerResults );
					}

					//checks for current custom adventures
					$user_custom_adventure_sql = "
					SELECT
					  Count( fyxt_adventures.idfyxt_adventure ) AS Count_idfyxt_adventure
					FROM
					  fyxt_adventures
					WHERE
					  fyxt_adventures.owner_id = $fyxtAccountID AND
					  fyxt_adventures.web_include = 0 AND
					  fyxt_adventures.verified = 0";
					$user_custom_adventures_result = $wpdb->get_var( $user_custom_adventure_sql );

					$custom_content_amount = $user_custom_adventures_result;
			}
			//checks for contributed Encounters
			elseif ( $opID == 47 ) { //Encoutners
					$user_contributed_encounters_sql = "
					SELECT
					  Count( fyxt_encounters.idfyxt_encounter ) AS Count_idfyxt_encounter
					FROM
					  fyxt_encounters
					WHERE
					  fyxt_encounters.enc_owner_id = 0 AND
					  fyxt_encounters.public = 1 AND
					  fyxt_encounters.web_include = 1 AND
					  fyxt_encounters.verified = 1 AND
					  fyxt_encounters.enc_creator_id = $fyxtAccountID";
					$contributed_custom_encounters = $wpdb->get_var( $user_contributed_encounters_sql );
					if ( ( $contributed_custom_encounters > 0 ) && ( $contNumbToGetPerResults > 0 ) ) {
						$earned = floor( $contributed_custom_encounters/$contNumbToGetPerResults );
					}

					//checks for current custom adventures
					$user_custom_encounters_sql = "
					SELECT
					  Count( fyxt_encounters.idfyxt_encounter ) AS Count_idfyxt_encounter
					FROM
					  fyxt_encounters
					WHERE
					  fyxt_encounters.enc_owner_id = $fyxtAccountID AND
					  fyxt_encounters.web_include = 0 AND
					  fyxt_encounters.verified = 0";
					$user_custom_adventures_result = $wpdb->get_var( $user_custom_encounters_sql );

					//debug test
					$i_fired = "Look I fired for 47";
				
					$custom_content_amount = $user_custom_adventures_result;
				}
				else {
					$earned = 0;
				}
			}
			
			if ( empty( $custom_content_amount ) ){ $custom_content_amount = 0; } //sets to 0 for display
			if ( empty( $earned ) ){ $earned = 0; } //sets to 0 for display
			
			$actTotal = $getDefaultCount + $accountPurchasesResults + $accountGiftResults + $earned;

			//stick it all in array to use later
			$accountOptionNumbers = array (
											base => $getDefaultCount,
											purchased => $accountPurchasesResults,
											gifted => $accountGiftResults,
											earned => $earned,
											total => $actTotal, ///adding some extra returns to bug WTF is going on
											account => $fyxtAccountID,
											optID => $opID,
											baseEarnNumb => $contNumbToGetPerResults,
											contNumb => $contNumb,
											optCanEarn => $optCanEarnMore,
											powerSQL => $userPowerContSQL,
											totalCont => $totalCont,
											pcNum => $pcNum,
											pcLevels => $pcLevels,
											npcNum => $npcNum,
											npcLevels => $npcLevels,
											contItems => $contItems,
											optionName => $option_name,
											customContentAmount => $custom_content_amount
										);
			return $accountOptionNumbers;
		} else {
			return;
		}
	} //end funciton for custom content cound and data
	
	//function to display alert message with Bootstrap alerts
	public function fyxt_bootstrap_alert ( $type, $heading, $message, $class = "" ){
		ob_start();
?>
			<div class="alert alert-<?php echo $type ?> <?php echo $class; ?>"><button class="close" type="button" data-dismiss="alert">×</button>
				<h4><?php echo $heading ?></h4>
					<?php echo $message ?> 
			</div>
<?php
		return ob_get_clean();
	}
	
	//function to display text area entry field and validation
	public function fyxt_form_text_area( $settings_array ){
		extract( $settings_array );

		ob_start();
?>		
			<div class="fyxt-gm-tools-form-label" ><span title="<?php echo $title_description ?>"><?php echo $title ?></span>  <br />
				<textarea name="<?php echo $name ?>" id="<?php echo $id ?>" style="width=100%;" rows="4" maxlength="<?php echo $max ?>" placeholder="<?php echo $placeholder ?>" max="500"><?php echo $existing_data ?></textarea><br />
	<!-- quick little counter script for usability -->
			  	<div class="fyxt-gm-tools-help-text">
					<span id="counter_<?php echo $id ?>">Characters left: <?php echo $max ?></span>
					<script type="text/javascript">
						jQuery( '#<?php echo $id ?>' ).keyup( function() {
							var left = <?php echo $max ?> - jQuery( this ).val().length;
							jQuery( '#counter_<?php echo $id ?>' ).text('Characters left: ' + left);
						});
					</script>
				</div>
		  	</div>
<?php		
		return ob_get_clean();
	}
	
	//function to get skill list
	public function fyxt_skill_list(){
		global $wpdb;
		$sql = "SELECT
		  fyxt_skill_list.idfyxt_skill_list,
		  fyxt_skill_list.fyxt_skill_name,
		  fyxt_skill_list.fyxt_skill_desc,
		  fyxt_skill_list.fyxt_skill_url,
		  fyxt_skill_list.fyxt_skill_trait
		FROM
		  fyxt_skill_list
		ORDER BY
		  fyxt_skill_list.idfyxt_skill_list";
		$results = $wpdb->get_results( $sql );
		return $results;
	}
	
	
} //end of class
