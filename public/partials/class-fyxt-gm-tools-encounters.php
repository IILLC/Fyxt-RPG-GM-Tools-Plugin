<?php

/**
 * The public-facing functionality of the plugin. 
 * This holds the functions to create Encounter Generator, Search, etc. 
 * All functions that are ENCOUNTER specific go here.
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
class Fyxt_Gm_Tools_Encounters {

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

		wp_enqueue_style( 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );

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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '/js/fyxt-gm-tools-encounters.js', array( 'jquery' ), $this->version, false );
		
	}
	
	
	/** add custom funcitons below. 
	* These functions are the main ones to display and organize the other
	* parts of this plugin. 
	*/
	
	///// gets the encounter difficulty list sorted from low to high
	public function fyxt_get_encounter_difficulty_list(){
		global $wpdb;
		$sql="SELECT
		  fyxt_enc_diff_list.idfyxt_enc_diff_list,
		  fyxt_enc_diff_list.diff_name,
		  fyxt_enc_diff_list.diff_abr,
		  fyxt_enc_diff_list.diff_desc
		FROM
		  fyxt_enc_diff_list
		ORDER BY
		  fyxt_enc_diff_list.idfyxt_enc_diff_list";
		$result= $wpdb->get_results( "$sql" );
		return $result;
	}

	///// gets the encounter type list sorted from low to high
	public function fyxt_get_encounter_type_list(){
		global $wpdb;
		$sql="SELECT
		  fyxt_enc_type_list.idfyxt_enc_type_list,
		  fyxt_enc_type_list.enc_name,
		  fyxt_enc_type_list.enc_abr,
		  fyxt_enc_type_list.enc_desc
		FROM
		  fyxt_enc_type_list
		ORDER BY
		  fyxt_enc_type_list.idfyxt_enc_type_list";
		$result= $wpdb->get_results( "$sql" );
		return $result;
	}
	
	//gets turn time difficulty list from easy to hard
	private function fyxt_tt_round_difficulty(){
		global $wpdb;
		$sql="
			SELECT
			  fyxt_enc_tt_round_difficulty_list.difficulty_name,
			  fyxt_enc_tt_round_difficulty_list.dice_modifier
			FROM
			  fyxt_enc_tt_round_difficulty_list
			ORDER BY
			  fyxt_enc_tt_round_difficulty_list.idfyxt_enc_tt_round_difficulty_list";
		$results = $wpdb->get_results( $sql );
		return $results;
	}
	
	//gets the encounter information
	private function fyxt_get_encounter_data( $encounter_id = 0 ){
		global $wpdb;
		$sql="SELECT
		  fyxt_encounters.idfyxt_encounter,
		  fyxt_encounters.enc_name,
		  fyxt_encounters.enc_summary,
		  fyxt_encounters.enc_setup,
		  fyxt_encounters.enc_tactics,
		  fyxt_encounters.enc_type,
		  fyxt_encounters.enc_level,
		  fyxt_encounters.enc_players,
		  fyxt_encounters.enc_difficulty,
		  fyxt_encounters.enc_rewards
		FROM
		  fyxt_encounters
		WHERE
		  fyxt_encounters.idfyxt_encounter = $encounter_id";
		$result= $wpdb->get_results( "$sql" );
		return $result;
	}
	
	private function fyxt_get_encounter_round_data( $encounter_id ){
		global $wpdb;
		$sql="
		SELECT
		  fyxt_enc_tt_round_list.fyxt_enc_tt_name,
		  fyxt_enc_tt_round_list.fyxt_enc_tt_description,
		  fyxt_enc_tt_round_list.fyxt_enc_tt_skill_1,
		  fyxt_enc_tt_round_list.fyxt_enc_tt_skill_2,
		  fyxt_enc_tt_round_id_association.round_order,
		  fyxt_enc_tt_round_id_association.round_difficulty
		FROM
		  fyxt_enc_tt_round_id_association
		  INNER JOIN fyxt_enc_tt_round_list ON fyxt_enc_tt_round_list.idfyxt_enc_tt_rounds =
			fyxt_enc_tt_round_id_association.round_id
		WHERE
		  fyxt_enc_tt_round_id_association.enc_id = $encounter_id
		ORDER BY
		  fyxt_enc_tt_round_id_association.round_order";
		$result= $wpdb->get_results( "$sql" );
		return $result;
	}
	
	/////////////////// encounter generator ////////////////////	
	public function fyxt_encounter_creator( $encounter_id = null ){
		global $current_user;
		global $wpdb;
		wp_get_current_user(); 
		$fyxt_account_id = intval( $current_user->ID );
		if ( $fyxt_account_id > 0 ) {
			$debug = debug( $fyxt_account_id );
			get_userdata( $fyxt_account_id );
			$fyxt_display_name = $current_user->display_name;
			$supermoderator= fyxt_isSuperMod( $fyxt_account_id );
			$encounter_id = $_GET['encID'];
		} else {
			$debug = 0;
			$fyxt_display_name = 'Fyxt RPG Guest';
			$subscriber = 0;
		}
		
		if ( $encounter_id > 0 ){
			//load encounter
			$edit_name = "Edit";
			$button_text = "Save Changes";
			$is_new_encounter = 0;
			
			//load encounter data
			$encounter_data = Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_data( $encounter_id );
			
			//if encounter is TT - load TT Round data
			if ( $encounter_data[0]->enc_type == 2 ){
				$turn_time_round_data = Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_round_data( $encounter_id );
			}
			
		} else {
		//new encounter
		$edit_name = "Enter New";
		$button_text = "Save New Encounter";
		$is_new_encounter = 1;
		}
		
		$tt_round_difficulty = Fyxt_Gm_Tools_Encounters::fyxt_tt_round_difficulty();
		
		if ( $fyxt_account_id > 0 ){
		
			ob_start();
						
?>

<button name="btnHToggle" id="btnHToggle" class="btn btn-info">Toggle Help Tips</button> 

<?php if ( !empty( $encounter_id ) ) { ?>
		<form action="">
			<input type="submit" value="Create New Encounter" />
		</form>
<?php } ?>

			<form action="<?php echo $editFormAction; ?>" method="post" name="encounter_form" id="encounter_form">

			<div class="char_stat_block_title" id="first_title">
				<?php echo $edit_name ?> Encounter Details</div>

			<div id="first_block" class="container-fluid char_stat_block whtTxt">
				
				<?php echo fyxt_create_account_content_display( $fyxt_account_id, 47 ) //47 for Encounters ?>
				
				<?php echo Fyxt_Gm_Tools_Public::fyxt_bootstrap_alert(
						"info", 
						"Step 1: Encounter Vital Details", "Enter the vital details of this encounter. What level characters does it target? How many? What is the difficulty and type of Encounter? <em><strong>Optional:</strong> Attach the Encounter to a custom Adventure you have already created.</em> ", 
						$class = "help_tip"
						) ?>
				
				<div class="fyxt-gm-tools-wrapper">
				  <div class="fyxt-gm-tools-form-label">
					  <span title="What would you like to name this encounter?">Encounter Name</span><br />
					  <input type="text" id="encounter_name" name="encounter_name" value="<?php echo $encounter_data[0]->enc_name ?>" maxlength="45" required/>
					</div>
				  
<?php //if user has any adventures they populate ?>				
					<div class="fyxt-gm-tools-form-label">
						<span title="Do you want to attach this encounter to an Adventure?" >Attach to Adventure</span> <br />
						<select name="enc_adv" id="enc_adv" autocomplete="off" style="max-width: 270px;" >
					  <option value="">No</option>
					  <?php
						$user_adventure_list = Fyxt_Gm_Tools_Adventures::fyxt_get_users_adventures( $fyxt_account_id );
						  foreach( $user_adventure_list as $list ){
							echo '<option value="'.$list->idfyxt_adventure.'"'.( ( $npcArch == $list->idfyxt_adventure ) ? ' selected="selected">' : '>' ).$list->adv_name.'</option>'; 
						  }
					  ?>
					  </select>
					</div>
				</div>
<?php //}  Ends user has any campaigns ?>

			<!-- Encounter Summary -->    

				<div class="fyxt-gm-tools-wrapper">
					<div class="fyxt-gm-tools-form-label"><span title="How difficult is this Encounter?"> Difficulty</span> <br />
					  <select name="enc_dif" id="enc_dif" autocomplete="off" required>
					  <option value="">Select...</option>
					  <?php
						$encounter_difficulty_list = Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_difficulty_list();
						  foreach( $encounter_difficulty_list as $list ){
							echo '<option value="'.$list->idfyxt_enc_diff_list.'"'.( ( $encounter_data[0]->enc_difficulty == $list->idfyxt_enc_diff_list ) ? ' selected="selected">' : '>' ).$list->diff_name.'</option>'; 
						  }
					  ?>
						  
					  </select>
				  </div>
					
					<div class="fyxt-gm-tools-form-label">
						<span title="What type of Encounter?">Type</span> <br />
						<select name="slct_enc_type" id="slct_enc_type" autocomplete="off" required>
							<option value="">Select...</option>
					  <?php
						$encounter_type_list = Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_type_list();
						  foreach( $encounter_type_list as $list ){
							echo '<option value="'.$list->idfyxt_enc_type_list.'"'.( ( $encounter_data[0]->enc_type == $list->idfyxt_enc_type_list ) ? ' selected="selected">' : '>' ).$list->enc_name.'</option>'; 
						  }

					  ?>
						</select>
					</div>
					<div class="fyxt-gm-tools-form-label">
						<span title="What level is this Encounter?">Level</span> <br />
						<select name="enc_lvl" id="enc_lvl" autocomplete="off" required>
					  <option value="">Select...</option>
			<?php
					for( $i = 1; $i <= 20; $i++ ){
						echo '<option value="'.$i.'"'.( ( $encounter_data[0]->enc_level == $i ) ? ' selected="selected">' : '>' ).$i.'</option>'; 
					}
			?>
					  </select>
				  </div>
				  <div class="fyxt-gm-tools-form-label"><span title="How many PCs in this Encounter?">PCs</span> <br />
					  <select name="encpc" id="enc_pc" autocomplete="off" required>
					  <option value="">Select...</option>
					  <option value="1">1 Player</option>
			<?php
					for( $i = 2; $i <= 10; $i++ ){
						echo '<option value="'.$i.'"'.( ( $encounter_data[0]->enc_players == $i ) ? ' selected="selected">' : '>' ).$i.' Players</option>'; 
					}
			?>
					  </select>
				  </div>
				</div>	
				
				<div id="encounter_options_notes" name="encounter_options_notes" ></div>
				
<?php 			//summary form section
				echo Fyxt_Gm_Tools_Public::fyxt_bootstrap_alert(
						"info", 
						"Step 2: Encounter Summary", 
						"Enter an overall summary of this encounter. This is dispayed in the Encount Search. Give basic information on setup, tactics, difficulties, or tidbits that make this encounter interesting.", 
						$class = "help_tip"
						);
				
				$settings_array = array(
					'name' => "enc_summary",
					'id' => "enc_summary",
					'class' => "",
					'title' => "Encounter Summary",
					'title_description' => "Enter the Encounter Summary here.",
					'placeholder' => "Enter the Encounter Summary here. This should be a basic overview of the Encounter.",
					'max' => 500,
					'existing_data' => $encounter_data[0]->enc_summary
				);
				echo Fyxt_Gm_Tools_Public::fyxt_form_text_area( $settings_array );

				//setup form section
				echo Fyxt_Gm_Tools_Public::fyxt_bootstrap_alert (
						"info", 
						"Step 3: Encounter Setup", 
						"Enter the specifics of why and how this encounter will happen. It can be as simple as a monster ambush in the wild to a series of strange events the players follow through city streets. Make sure to mention important information for the GM so this encounter can be setup properly.", 
						$class = "help_tip"
						);
			
				echo '<div class="fyxt-gm-tools-form-label"><span title="Enter the Encounter Setup and Details here. What the GM should do to lead into this encounter.">Encounter Setup and Details</span> <br /></div>';
			
				$editorSettings = array (	
							'media_buttons' => false,
							'resize' => false,
							'wp_autoresize_on' => true,
						 	'textarea_rows' => 10
							);	
				wp_editor( stripslashes( $encounter_data[0]->enc_setup ), 'encounter_summary_content', $editorSettings  );
?>
				<div class="fyxt-gm-tools-help-text"><span id="encounter_setup_counter" name="encounter_setup_counter" title="Check character count by making a change on the Text tab.">Character Limit: 5000</span></div>
<?php
				//tactics form section
				echo Fyxt_Gm_Tools_Public::fyxt_bootstrap_alert (
						"info", 
						"Step 4: Encounter Tactics", 
						"<p>Enter the specific tactics for this encounter. Are they smart? Dumb? Do they charge? Stay at range or use combat maneuvers and tactics? Are there any Combat Surprises in store? Perhaps some traps they might utilize? Do the NPCs have bonuses to Skills?</p> 

					These are all things to include in tactics. The more tactics are used the more interesting an encounter can become.", 
						$class = "help_tip"
						);
				$settings_array = array(
					'name' => "enc_tactics",
					'id' => "enc_tactics",
					'class' => "",
					'title' => "Encounter Tactics",
					'title_description' => "Enter the Encounter Tactics here. Descibe in detail what tactics the NPCs will use.",
					'placeholder' => "Enter what the NPCs will do in this Encounter. What are their strategies and tricks.",
					'max' => 500,
					'existing_data' => $encounter_data[0]->enc_tactics
				);
				echo Fyxt_Gm_Tools_Public::fyxt_form_text_area($settings_array);

				///// this is the optional sections for Turn Time and Battle Time Encounters
				?>
				
					<div class="fyxt-gm-tools-form-label">Turn Time Round Actions</h2></div>At least one Turn Time Round action must be added to the Encounter. 
<?php
			$ttRoundActionSQL = "
				SELECT
				  fyxt_enc_tt_round_list.fyxt_enc_tt_name,
				  fyxt_enc_tt_round_list.fyxt_enc_tt_description,
				  fyxt_skill_list.fyxt_skill_name AS sk1,
				  fyxt_skill_list1.fyxt_skill_name AS sk2,
				  fyxt_enc_tt_round_id_association.difficulty,
				  fyxt_enc_tt_round_id_association.details,
				  fyxt_enc_tt_round_id_association.`order`,
  				  fyxt_enc_tt_round_id_association.idfyxt_enc_tt_round_id_association
				FROM
				  fyxt_enc_tt_round_id_association
				  INNER JOIN fyxt_enc_tt_round_list ON
					fyxt_enc_tt_round_id_association.r_id = fyxt_enc_tt_round_list.idfyxt_enc_tt_rounds
				  INNER JOIN fyxt_skill_list ON fyxt_enc_tt_round_list.fyxt_enc_tt_skill_1 = fyxt_skill_list.idfyxt_skill_list
				  INNER JOIN fyxt_skill_list fyxt_skill_list1 ON fyxt_enc_tt_round_list.fyxt_enc_tt_skill_2 =
					fyxt_skill_list1.idfyxt_skill_list
				WHERE
				  fyxt_enc_tt_round_id_association.enc_id = $encounter_id
				ORDER BY
				  fyxt_enc_tt_round_id_association.`order`"; 
			$ttRoundResults = $wpdb->get_results( "$ttRoundActionSQL" );
?>
				<input type="hidden" name="hdn-enc-id" value="<?php echo $encounter_id ?>">
				<input type="hidden" id="hdn-total-enc-rounds" value="<?php echo count( $ttRoundResults ) ?>">
				
<?php				
			if ( !empty( $ttRoundResults ) ) {
				$i = 1;
				
				foreach ( $ttRoundResults as $ra ){
?>				
					<div name="tt-action-container" id="action-container-<?php echo $i ?>" class="npower">
						<input type="hidden" name="hdn-round-id" value="<?php echo $ra->idfyxt_enc_tt_round_id_association ?>">
						<input type="hidden" name="hdn-order" value="<?php echo $i ?>">
						<input type="hidden" name="hdn-diffictulty" value="<?php echo $ra->difficulty ?>">
						
						<dl>
							<dt>Round <span id="spn-tta-title"><?php echo $i ?></span>: <?php echo $ra->fyxt_enc_tt_name ?></dt>
							<dd><?php echo $ra->fyxt_enc_tt_description ?></dd>
						</dl>
  						<ul>
<?php 
					if ( !empty( $ra->difficulty ) ){
						
						if ( $ra->difficulty == 5 ) {
							$challenge = "Easy";
						} elseif ( $ra->difficulty == 15 ) {
							$challenge = "Moderate";
						} elseif ( $ra->difficulty == 25 ) {
							$challenge = "Hard";
						}
						$dice_check = $ra->difficulty + $encounter_data[0]->enc_level;
						echo '<li><span name="spn-difficulty"><strong>Roll Difficulty</strong>: '.$challenge.' ('.$dice_check.')</span></li>';
					}
?>
							<li><span title="<?php echo $ra->fyxt_enc_tt_description ?>"><strong>Basic Skill Use</strong>: <?php echo $ra->fyxt_enc_tt_name ?></span> using <?php echo $ra->sk1." or ".$ra->sk2 ?></li>
<?php 
					if ( !empty( $ra->details ) ) { 
?>
							<li><span name="spn-details"><strong>Details</strong>: <?php echo $ra->details ?></span></li>
<?php
					} else {
?>
							<li><span name="spn-details"><strong>Details</strong>: <em>No specific details given. Consider expanding the details for this round using the Edit Details button below.</em></span></li>
<?php					
					}//closing if for details of the round
?>
						</ul>
						<div id="g-btn" name="g-btn">
<?php				
					if ( $i == 1 ) {
?>
						<button name="btn-up-arrow" style="display: none;"><i class="fas fa-arrow-up"></i></button>
						<button name="btn-down-arrow"><i class="fas fa-arrow-down"></i></button>
<?php 
					} elseif ( $i == count( $ttRoundResults ) ) {
?>
						<button name="btn-up-arrow"><i class="fas fa-arrow-up"></i></button>
						<button name="btn-down-arrow" style="display: none;"><i class="fas fa-arrow-down"></i></button>
<?php 
					} else {
?>
						<button name="btn-up-arrow" title="Click this arrow to raise the order of this round." ><i class="fas fa-arrow-up"></i></button>
						<button name="btn-down-arrow" title="Click this arrow to reduce the order of this round." ><i class="fas fa-arrow-down"></i></button>
<?php							
					} // closes last row down button. Can't go down man!
?>					
						<select name="slct-round-difficulty" id="slct-round-difficulty" title="Change the roll Difficulty for this round.">
<?php 
						foreach ( $tt_round_difficulty as $td ){
							echo '<option value="'.$td->dice_modifier.'"'.( ( $ra->difficulty == $td->dice_modifier ) ? ' selected="selected">' : '>' ) .$td->difficulty_name.'</option>'; 
						}
?>
					  	</select>
						<button name="btn-edit-details" title="Click this button to edit the specific details of this round of actions." value="0" >Edit Details</button>
						<textarea name="ta-round-details" placeholder="Fill in with the details of this specific round for the Encounter." style="display: none;">
<?php 
							if ( !empty( $ra->details ) ){ echo $ra->details; } ?></textarea>
						</div>
						
						<div id="b-btn" name="b-btn">
							<button name="btn-remove-round" title="Click this button to remove this round from the Encounter."><i class="fas fa-trash-alt"></i></button>
						</div>
						
					</div>
<?php 
					$i++;
				} // closes foreach loop
			
			} //closes if existing actions initial display of round actions 
?>
					
					<div class="fyxt-gm-tools-form-label">
								Select Existing Action <br />
								<select name="slctExistingActions" id="slctExistingActions" >
								  
						<?php	$actionsSQL = "
									SELECT
									  fyxt_enc_tt_round_list.idfyxt_enc_tt_rounds,
									  fyxt_enc_tt_round_list.fyxt_enc_tt_name,
									  fyxt_enc_tt_round_list.fyxt_enc_tt_description
									FROM
									  fyxt_enc_tt_round_list
									WHERE
									  fyxt_enc_tt_round_list.creator_id = 1 OR
									  fyxt_enc_tt_round_list.web_include = 1";
								$actionResults = $wpdb->get_results( "$actionsSQL" );
								
								foreach ( $actionResults as $ar ){
									echo '<option value="'.$ar->idfyxt_enc_tt_rounds.'" >'.$ar->fyxt_enc_tt_name.'</option>'; 
								}
						?>
								  </select>
						
						<select name="slct-round-difficulty" id="slct-round-difficulty" title="Change the Difficulty of this Round">
<?php 
						foreach ( $tt_round_difficulty as $td ){
							echo '<option value="'.$td->dice_modifier.'" >'.$td->difficulty_name.'</option>'; 
						}
?>
					  	</select>
								<button name="btnAddExistingAction" id="btnAddExistingAction"><i class="fas fa-plus"></i></button>
							</div>
					
					<div class="fyxt-gm-tools-form-label">Or <br /> Create a New Action to use!</div>
					
					<div class="fyxt-gm-tools-wrapper"> <!-- New Action Form -->
						<div class="fyxt-gm-tools-form-label">
								<span title="What would you name this round of activity?">Name</span> <br />
								<input type="text" id="tt_round_name_<?php echo $i ?>" name="tt_round_name_<?php echo $i ?>" value="" maxlength="45" autocomplete="off" required/>
							</div>
							<div class="fyxt-gm-tools-form-label">
								<span title="Describe what the PCs are doing this round.">Round Goal</span> <br />
								<textarea id="tt_round_goal_<?php echo $i ?>" name="tt_round_goal_<?php echo $i ?>" rows="3" cols="25" maxlength="500" autocomplete="off" required></textarea>
								
				  			</div>
				  			<div class="fyxt-gm-tools-form-label"><span title="What is the first Skill PCs can use this round?">Skill 1</span> <br />
								<select name="slct_skill_1_<?php echo $i ?>" id="slct_skill_1_<?php echo $i ?>" autocomplete="off" required>
					  <option value="">Select...</option>
<?php
			$skill_list = Fyxt_Gm_Tools_Public::fyxt_skill_list();
			foreach ( $skill_list as $sl ){
				echo '<option value="'.$sl->idfyxt_skill_list.'"'.( ( $skill_list[0]->enc_difficulty == $sl->idfyxt_skill_list ) ? ' selected="selected">' : '>' ).$sl->fyxt_skill_name.'</option>'; 
			}
?>
					  </select>
				  </div>
							<div class="fyxt-gm-tools-form-label"><span title="What is the second Skill PCs can us this round?">Skill 2</span> <br />
					  <select name="slct_skill_2_<?php echo $i ?>" id="slct_skill_2_<?php echo $i ?>" autocomplete="off" required>
					  <option value="">Select...</option>
<?php
			$skill_list = Fyxt_Gm_Tools_Public::fyxt_skill_list();
			foreach ( $skill_list as $sl ){
				echo '<option value="'.$sl->idfyxt_skill_list.'"'.( ( $skill_list[0]->enc_difficulty == $sl->idfyxt_skill_list ) ? ' selected="selected">' : '>' ).$sl->fyxt_skill_name.'</option>'; 
			}
?>			
					  </select>
						</div>
						<div class="fyxt-gm-tools-form-label"><span title="What is the second Skill PCs can us this round?">Difficulty</span> <br />
						<select name="slct-round-difficulty" id="slct-round-difficulty" title="Change the Difficulty of this Round" required>
<?php 
						foreach ( $tt_round_difficulty as $td ){
							echo '<option value="'.$td->dice_modifier.'" >'.$td->difficulty_name.'</option>'; 
						}
?>
					  	</select>
				  </div>
						<div class="fyxt-gm-tools-form-label">
							<br />
							<button name="btn-create-new-action"><i class="fas fa-plus"></i></button> 	
						</div>
					</div>

				<div id="battle_time_container" ?>
					<div id="npc_list">
						NPCS GO HERE
					</div>
				</div>
			
<?php			
				//Rewards section of the form
				echo Fyxt_Gm_Tools_Public::fyxt_bootstrap_alert (
						"info", 
						"Step 5: Encounter Rewards", 
						"Encounter rewards can vary widely depending on the type, difficulty, and outcome of an adventure. 
					<ul>
						<li>For Real Time Encounters the rewards are usualy the roleplay and information gathered within.</li>
						<li>For Turn Time Encounters the rewards are usualy bonuses to to the next Encounter.</li>
						<li>For Battle Time Encounters the rewards are usualy the value of the items or the items themselves from defeated foes.</li>
					</ul>
					Rewards for the Encounter should be campaign and adventure specific. But this is a good place to add suggested awards.", 
						$class = "help_tip"
						);
				$settings_array = array(
					'name' => "enc_rewards",
					'id' => "enc_rewards",
					'class' => "",
					'title' => "Encounter Rewards",
					'title_description' => "Enter the Encounter Rewards here. Descibe in detail what rewards the PCs might get.",
					'placeholder' => "Enter the details surrounding what rewards the PCs may get at the end of this encounter.",
					'max' => 500,
					'existing_data' => $encounter_data[0]->enc_rewards
				);
				echo Fyxt_Gm_Tools_Public::fyxt_form_text_area( $settings_array );
?>				
			
				<input type="hidden" name="hdn_encounter_id" value="<?php echo $encounter_id ?>">	
			
				<input type="hidden" name="hdn_is_new_encounter" id="hdn_is_new_encounter" value="<?php echo $is_new_encounter ?>">
				
				<button type="button" name="btn_save_encounter" id="btn_save_encounter" class="btn btn-primary btn-lg btn-block">
				<?php echo $button_text ?></button>	

			</div>
			</form>


				<h2>Encounter Calculator</h2>
Commented out ATM.
			<?php // echo do_shortcode('[enccalc]'); ?>	

			<?php
				if ( true == $debug ){ //show printed debug information //remove after testing
			?>
					<h2>Debug Info</h2>
					<p>$current_user->ID = <?php print_r( $current_user->ID ); ?>		
					<p>$fyxt_account_id = <?php print_r( $fyxt_account_id ); ?>
					<p>$debug = <?php print_r( $debug ); ?>
					<p>$subscriber = <?php print_r( $isSub ); ?>
					<p>$fyxt_display_name = <?php print_r( $fyxt_display_name ); ?>
					<p>$fyxt_display_name = <?php print_r( $fyxt_display_name ); ?>
					<p>Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_type_list() = <?php print_r( Fyxt_Gm_Tools_Encounters::fyxt_get_encounter_type_list() ); ?>	
					<p>$encounter_id = <?php print_r( $encounter_id ); ?>
					<p>$encounter_data = <?php print_r( $encounter_data ); ?>
					<p>$encounter_data->enc_name = <?php print_r( $encounter_data->enc_name ); ?>
					<p>$encounter_data['enc_name'][0] = <?php print_r( $encounter_data['enc_name'][0] ); ?>
					<p>$encounter_data[0]->enc_name = <?php print_r( $encounter_data[0]->enc_name ); ?>
			<?php
				} //end debugging
			?>
	
<?php
	} else { //ends else statement for logged in or not
		echo Fyxt_Gm_Tools_Public::fyxt_login_form();	
	}
	
	$display_encounter_builder = ob_get_clean();
	
	return $display_encounter_builder;
		
	}
	
}

?>
