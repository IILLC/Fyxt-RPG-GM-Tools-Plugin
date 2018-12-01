<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.imageinnovationsllc.com/
 * @since      1.0.0
 *
 * @package    Fyxt_Gm_Tools
 * @subpackage Fyxt_Gm_Tools/public/partials
 */


//code to create and display account numbers of type of content
//see `fyxt_wp_db_fatcow`.`fyxt_user_account_limits_list` table for list of account limits for content_type_id
function fyxt_create_account_content_display ( $fyxt_account_id, $content_type_id ){
	$subscription_info = pmpro_getMembershipLevelForUser( $fyxtAccountID );
	
	//need to collect content information limits, how many
	$content_info = Fyxt_Gm_Tools_Public::fyxt_AccountOptLimit ( $fyxt_account_id, $content_type_id ); //account ID, Option ID // a function to return information about content.
	
	$debug = debug( $fyxt_account_id );
	if ( true == $debug ){
		print_r( '$content_info= ' );
		print_r( $content_info );
	}
	
	ob_start();
	
?>	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="stats_table" id="stats_table">
            <tr>
              <td class="fyxt-cs-label"><span title="The amount of <?php echo $content_info["optionName"] ?> currently on your account."><strong>Current <?php echo $content_info["optionName"] ?></strong></span></td>
              <td class="fyxt-data-info"><span name="spnCurPowers" id="spnCurPowers" title="Current number of <?php echo $content_info["optionName"] ?> on this account."><?php echo $content_info["customContentAmount"] ?></span></td>
              <td class="fyxt-cs-label"><span title="The base number of <?php echo $content_info["optionName"] ?> your account can have at the current subscription level."><?php echo $subscription_info->name ?> Granted</span></td>
              <td class="fyxt-data-info"><a href="../../fyxt-rpg-account/fyxt-rpg-member-levels/" title="Click to see Fyxt Subscription Levels"><?php echo $content_info["base"] ?></a></td>
              <td class="fyxt-cs-label" ><span title="The number of <?php echo $content_info["optionName"] ?> you have earned.">Earned</span></td>
              <td class="fyxt-data-info"><?php echo $content_info["earned"] ?></td>
            </tr>
            <tr>
              <td class="fyxt-cs-label" ><span title="This is the number of total <?php echo $content_info["optionName"] ?> that are allowed on this account."><strong>Account <?php echo $content_info["optionName"] ?> Maximum</strong></span></td>
              <td class="fyxt-data-info" ><span title="Increase this by subscribing at a higher level, contributing creations to the Fyxt RPG, or participating in contests."><?php echo $content_info["total"] ?></span></td>
              <td class="fyxt-cs-label " >&nbsp;</td>
              <td class="fyxt-cs-label " >&nbsp;</td>
              <td class="fyxt-cs-label"><span title="The number of <?php echo $content_info["optionName"] ?> that have been awarded to this account.">Awarded</span></td>
              <td class="fyxt-data-info"><?php echo $content_info["gifted"] ?></td>
            </tr>
        </table> 
<?php
	return ob_get_clean();
}

//////////////////// shortcode registering to be able to display "widgets" inside standard wordpress pages ///////////////////

add_shortcode( 'fyxt_display_encounter_creator', 'fyxt_encounter_builder_shortcode' );

function fyxt_encounter_builder_shortcode() { 
	$short_code_enc_builder = Fyxt_GM_Tools_Encounters::fyxt_encounter_creator();

	return $short_code_enc_builder;
}	
	
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


