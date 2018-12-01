(function( $ ) {
	'use strict';

	jQuery( document ).ready( function( $ ) {
		//function to make help windows dissapear.
		$( function() {
		  $( "button[name=btnHToggle]" )  
			.click(function( event ) {
				event.preventDefault();
				  $( '.help_tip' ).toggle( "slow" );
			});
		});
		
		//function for encounter type suggestion message
		$( function() {
			$( "select[name=slct_enc_type]" )  
				.change( function( event ) {
				event.preventDefault();
				var type_value = $( "#slct_enc_type" ).val();
				type_value = parseInt( type_value );
				switch ( type_value ) {
					case 1:
						$( "#encounter_options_notes" ).html('<div class="alert alert-warning" role="alert">Select the NPCs for the Encounter below.</div>' );
						$( "[name='turn_time_container']" ).hide();
						break;
					case 2:
						$( "#encounter_options_notes" ).html('<div class="alert alert-warning" role="alert">Select the round objectives for the Encounter below.</div>' );
						$( "[name='turn_time_container']" ).show();
						break;
					case 3:
						$( "#encounter_options_notes" ).html('<div class="alert alert-info" role="alert">Be as detailed as possible regarding the specifcs of this Encounter.</div>' );
						$( "[name='turn_time_container']" ).hide();
						break;
					default:
						$( "#encounter_options_notes" ).html( '' );
						$( "[name='turn_time_container']" ).hide();
						break;
				}
			});
		});

		//function to do character count for encounter summary
		$( "#encounter_summary_content" ).keyup( function() {
			var left = 5000 - $( this ).val().length;
			$( '#encounter_setup_counter' ).text( 'Characters Left: ' + left );
		});
	
		//debugging function to get/check values
		$( function() {
		  	$( "button[name=btn_save_encounter]" )  
				.click( function( event ) {
					event.preventDefault();
					var encounter_name = $( "#encounter_name" ).val();
					console.log( 'encounter_name = '+ encounter_name );
				
					var encounter_advtenure = $( "#enc_adv" ).val();
					console.log( 'encounter_advtenure = '+ encounter_advtenure );
				
					var encounter_difficulty = $( "#enc_dif" ).val();
					console.log( 'encounter_difficulty = '+ encounter_difficulty );
				
					var encounter_type = $( "#slct_enc_type" ).val();
					console.log( 'encounter_type = '+ encounter_type );
				
					var encounter_level = $( "#enc_lvl" ).val();
					console.log( 'encounter_level = '+ encounter_level );
				
					var encounter_pcs = $( "#enc_pc" ).val();
					console.log( 'encounter_pcs = '+ encounter_pcs );
				
					var encounter_summary = $( "#enc_summary" ).val();
					console.log( 'encounter_summary = '+ encounter_summary );
				
					var encounter_setup = tinymce.get( 'encounter_summary_content' ).getContent();
					console.log( 'encounter_setup = '+ encounter_setup );
				
					var encounter_tactics = $( "#enc_tactics" ).val();
					console.log( 'encounter_tactics = '+ encounter_tactics );
				
					var encounter_rewards = $( "#enc_rewards" ).val();
					console.log( 'encounter_rewards = '+ encounter_rewards );
			});
		});
		
		//function to add dice check rolls after difficulty selected
		$( function() {
		  	$( "select[name*=slct_round_difficulty]" )  
				.click( function( event ) {
					event.preventDefault();
					var difficulty = $( this ).val();
					var dice_check = "";
					if ( difficulty >= 1 ) {
						var level = $( '#enc_lvl' ).val();
						var teir = Math.ceil( parseInt( level ) / 4 );
						dice_check = parseInt( difficulty ) + parseInt( level ) + teir;	
						$( this ).next("span").text( dice_check );
					} else {
						dice_check = "";
						$( this ).next( "span" ).text( dice_check );
					}
			});
		});
		
		//function for up arrow sorting - Sortable was NOT working on mobile
		$( function() {
			$( "button[name=btn-up-arrow]" )  
			.click( function( event ) {
				event.preventDefault();
				var this_div = $( this ).parent().parent();
				var above_div = $( this_div ).prev( '[name*=tt-action-container]' );
				var total_rounds = parseInt( $( '#hdn-total-enc-rounds' ).val(),10 );
				
				//fade out moving div
				$( this_div ).insertBefore( above_div ).slideUp( 300 ).delay( 400 ).fadeOut( 400 );
				$( above_div ).insertBefore( above_div ).slideUp( 300 ).delay( 400 ).fadeOut( 400 );
				
				//setting the div clicked to the new settings
				var current_round_order = $( this_div ).children( '[name=hdn-order]' ).val(); //selects div containter above arrow
				var current_new_order = parseInt( current_round_order,10 ) - 1;
				$( this_div ).children( '[name=hdn-order]' ).val( current_new_order ); //increase order by 1
				$( this_div ).children( "dl" ).children( "dt" ).children( '[id=spn-tta-title]' ).text( current_new_order ); //increase order by 1

				//setting the div above to the new settings
				var above_round_order = $( above_div ).children( '[name=hdn-order]' ).val();
				var new_above_round_order = parseInt( above_round_order,10 ) + 1;
				$( above_div ).children( '[name=hdn-order]' ).val( new_above_round_order ); //increase order by 1
				$( above_div ).children( "dl" ).children( "dt" ).children( '[id=spn-tta-title]' ).text( new_above_round_order ); //increase 

				//this section adds or removes order arrows depending on placement.
				//current div that is changing
				if ( current_new_order === 1 ){
					$( this ).hide( "slow" );
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				} else {
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				}
				
				//neighbor div = below_div
				if ( new_above_round_order === total_rounds ) {
					$( above_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( above_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).hide( "slow" );
				} else {
					$( above_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( above_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				}

				//fade divs for cools
				$( above_div ).insertBefore( above_div ).slideUp( 300 ).delay( 400 ).fadeIn( 400 );
				$( this_div ).insertBefore( above_div ).slideUp( 300 ).delay( 400 ).fadeIn( 400 );
			});
		});
		
		///down arrow code
		$( function() {
			$( "button[name=btn-down-arrow]" )  
			.click( function( event ) {
				event.preventDefault();
				var this_div = $( this ).parent().parent();
				var below_div = $( this_div ).next( '[name*=tt-action-container]' );
				var total_rounds = parseInt( $( '#hdn-total-enc-rounds' ).val(),10 );

				//setting the div clicked to the new settings
				var current_round_order = $( this_div ).children( '[name=hdn-order]' ).val(); //selects div containter above arrow
				var current_new_order = parseInt( current_round_order,10 ) + 1;
				$( this_div ).children( '[name=hdn-order]' ).val( current_new_order ); //increase order by 1
				$( this_div ).children( "dl" ).children( "dt" ).children( '[id=spn-tta-title]' ).text( current_new_order ); //increase order by 1

				//setting the div above to the new settings
				var below_round_order = $( below_div ).children( '[name=hdn-order]' ).val();
				var new_below_round_order = parseInt( below_round_order,10 ) - 1;
				$( below_div ).children( '[name=hdn-order]' ).val( new_below_round_order ); //increase order by 1
				$( below_div ).children( "dl" ).children( "dt" ).children( '[id=spn-tta-title]' ).text( new_below_round_order ); //increase 

				//this section adds or removes order arrows depending on placement.
				//current div that is changing
				if ( current_new_order === total_rounds ){
					$( this ).hide( "slow" );
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
				} else {
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( this_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				}
				
				//neighbor div = below_div
				if ( new_below_round_order === 1 ){
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).hide( "slow" );
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				} else if ( new_below_round_order === total_rounds ) {
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).hide( "slow" );
				} else {
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-up-arrow]' ).show( "slow" );
					$( below_div ).children( '[name=g-btn]' ).children( '[name=btn-down-arrow]' ).show( "slow" );
				}
				
				$( this_div ).insertAfter( below_div ).slideUp( 300 ).delay( 800 ).fadeIn( 400 );
			});
		});
		
		//makes text area appear to edit, or hides text edit and updates page with new text DOES NOT SAVE
		$( function() {
			$( "button[name=btn-edit-details]" )  
			.click( function( event ) {
				event.preventDefault();
				var action = parseInt( $( this ).val(),10 );

				if ( action === 0 ) {
					$( this ).next( '[name=ta-round-details]' ).show( "slow" );
					$( this ).val( 1 );
					$( this ).text( "Save Details" );
				} else {
					$( this ).next( '[name=ta-round-details]' ).hide( "slow" );
					$( this ).val( 0 );
					$( this ).text( "Edit Details" );
					var new_details = $( this ).next( '[name=ta-round-details]' ).val();
					var new_line = '<strong>Details</strong>: ';
					
					if ( new_details.length !== 0 ){
						new_line = new_line + new_details;
					} else {
						new_line = '<em>There are no details entered. Consider adding some detail to this round of to make it more interesting. Click the Edit Details button to get started.</em>';
					}
					//set details span
					$( this ).val( 0 );
					$( this ).parent().parent().children( "ul" ).children( "li" ).children( '[name=spn-details]' ).html( new_line ); //increase order by 1
				}
			});
		});
		
		//changes the dispay of the round difficulty DOES NOT SAVE
		$( function() {
			$( "select[name=slct-round-difficulty]" )  
			.change( function( event ) {
				event.preventDefault();
				var difficulty_name = $( 'option:selected',this ).text();
				var difficulty_value = $( this ).val();

				$( this ).parent().parent().children( "ul" ).children( "li" ).children( '[name=spn-difficulty]' ).html( "<strong>Roll Difficulty</strong>: " + difficulty_name + " ( " + difficulty_value + " ) " );

				});
			});

		
	}); //document ready end
	
	
})( jQuery );
