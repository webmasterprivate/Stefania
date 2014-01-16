<?php
/* Plugin Name: CSSHero
Plugin URI: csshero.org
Description: Bringing the future of interactive Web design to a WordPress near you. Requires Wp 3.5+
Version: MATTEO DEV BETA OFFICIAL 29 Nov
Author: CssHero.org
Author URI: csshero.org
License: Commercial
 */ 
 
 
	
 
function wpcss_current_theme_slug()
{ 	$theme_name = wp_get_theme();
	return sanitize_title($theme_name);
	//return sanitize_title($theme_name."_mobile");
}

 

function wpcss_handle_actions()
{
		
		
		//trigger possible actions for NORMAL users, not logged in
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='show_css')  {require_once ("dynamic_css.php");die;}
		
		
		//Following actions for site admin only
		if(!current_user_can('edit_theme_options') ) return; //quit function if user cannot edit site
		
		if (isset($_GET['get_palette_from_image_url'])) {wpcss_SavePaletteFromImage($_GET['get_palette_from_image_url']); include('assets/mini-redirect.php');}
		if (isset($_GET['delete_palette_from_image']) && $_GET['delete_palette_from_image']==1 ) {delete_option("wpcss-image-palette"); include('assets/mini-redirect.php');}
		
		
		//check if product activated
		if ( is_admin()  && !wpcss_check_license()) {add_action( 'admin_notices', 'wpcss_hero_admin_notice' ); return;}
		
		
		//LICENSING   ACTIVATION																				
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='activation' && is_user_logged_in()&& current_user_can('install_plugins'))
							
							{ //license request
								update_option('wpcss_accept_license','yes');
							$data=array( 'url' => get_bloginfo('url'), 'email' => get_bloginfo('admin_email'),product=>'LTE');
							wp_redirect('http://csshero.org/request-license/?data='.base64_encode(serialize($data)));
								die;  
								}
		
							
		//GET REMOTE LICENSE
		
		if (!isset($_POST['wpcss_submit_form'])  && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='get_license'&& get_option('wpcss_accept_license')=='yes' && is_user_logged_in()&& current_user_can('install_plugins'))
					{ 
									update_option('csshero-license',$_GET['license_key']);
			
										delete_option('wpcss_accept_license');
															
									$license=wpcss_check_license();
									if ($license!=FALSE) {
																	$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 	$redirect_url_array=explode('?',$redirect_url); 	$redirect_url=$redirect_url_array[0];
											 
							?>									 <body style="padding: 0; margin: 0; background: #f0f4f3;">
															<div style="margin: 0; padding:100px; ">	 
																					<div style="margin: 0px auto; position: relative; background: transparent url(http://csshero.org/wp-content/themes/heroin/images/remote_welcome.png) no-repeat center; width: 220px; height: 475px">					
																					<a style="display: block; position: absolute; width:176px; height:37px; background:transparent url(http://csshero.org/wp-content/themes/heroin/images/remote_ok.png) no-repeat center; top: 329px; left: 22px;" href="<?php echo $redirect_url ?>"></a>
																					</div>			
																			</div>
							</body>	
																	<?php die;
							}
									
									else {
												$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
												$redirect_url_array=explode('?',$redirect_url);
												$redirect_url=$redirect_url_array[0];
												wp_redirect($redirect_url.'/?wpcss_message=activation_invalid');
												}
									
										die;
										
					}
									
		 
									
		//DELETE LICENSE
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_license' && is_user_logged_in()&& current_user_can('install_plugins')) {delete_option('csshero-license');die('done'); }
		
		//CHECK LICENSE DEBUG
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='check_license' && is_user_logged_in()&& current_user_can('install_plugins') && is_user_logged_in()&& current_user_can('install_plugins'))
		{
		echo wpcss_check_license(); die;
		}
		
		///END LICENSING ACTIONS
		
		
		
		
		
			
		
		//THEME RESET
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='reset')  {
																			update_option('wpcss_current_settings_array_'.wpcss_current_theme_slug(),'');
		
																			//Save which is the active current history step 
																			//	update_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug(),$id_of_new_step);
																				 include('assets/mini-redirect.php');
																			  }
		//RESET QUICK CONFIG
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='reset_quick_config')  {delete_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug()); include('assets/mini-redirect.php');}
						 
		
		
		
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_theme_config')  {delete_option('wpcss_current_theme_options_array_'.wpcss_current_theme_slug());echo "Done!"; exit;}
														
		if (isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='share_preset')  { wpcss_share_current_preset(); }
		
		
																		
		//SAVE CSSHERO DATA																		
		if (isset($_POST['wpcss_submit_form'])  && $_POST['wpcss_submit_form']==1  &&  isset($_POST['csshero-livearray-saving-field'])) { 
											
												
													if ( empty($_POST)  or  !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )
															{
																		print '<h1>Sorry, your nonce did not verify.</h1>'; //('','csshero_save_nonce'
																		exit;
															}		
														
									  $field= stripslashes( ($_POST['csshero-livearray-saving-field'])); 	//	echo $field;
														$wpcss_current_settings_array= json_decode($field); // print_r($wpcss_current_settings_array);
		
													//UPDATE CURRENT MAIN THEME SETTINGS !!!
													update_option('wpcss_current_settings_array_'.wpcss_current_theme_slug(),serialize($wpcss_current_settings_array));
												//	print_r($wpcss_current_settings_array);
												
													//save history NEW
												$wpcss_history_steps_array=get_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug()); //print_r($wpcss_history_steps_array);
													if (!$wpcss_history_steps_array) $wpcss_history_steps_array=array();
											
													//find maximum step value
															
													$id_of_new_step=0;
													foreach($wpcss_history_steps_array as $history_element):
													if ($history_element['step_id']>$id_of_new_step) $id_of_new_step=$history_element['step_id'];
													endforeach;
											
												 $id_of_new_step++;
																			
													 //add element to history array
												 $wpcss_history_steps_array[]=array(
																				'step_id' => $id_of_new_step,
																				'snapshot_name' =>   date(' h:i:s a m/d/Y', time()),
																				'snapshot_type' => 'history',
																				'key' => mt_rand(),
																				);
													
													
													//save setting as history step
													 $wpcss_new_stored_configuration_value=serialize($wpcss_current_settings_array);
												update_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$id_of_new_step,$wpcss_new_stored_configuration_value);
													
													//Save history steps definition list
													 update_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug(),$wpcss_history_steps_array);
													
													
													//Save which is the active current history step 
													 update_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug(),$id_of_new_step);
													
														die("Saved");
										
									}
									
									
		//SAVE QUICK CONFIG  				
		if (isset($_POST['wpcss_submit_quick_config_form']) && $_POST['wpcss_submit_quick_config_form']==1) {
														if ( empty($_POST)  or !wp_verify_nonce($_POST['csshero_saving_nonce_field'],'csshero_saving_nonce') )
															{
																		print '<h1>Sorry, your nonce did not verify.</h1>'; //('','csshero_save_nonce'
																		exit;
															}	
													
													$wpcss_new_quick_config=addslashes($_POST['wp-css-config-quick-editor-textarea']);
										 
													//aggiungere sanitizzazione
													
													update_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug(),$wpcss_new_quick_config);
													
												echo "Config Saved";die;
													}
		
		
		//attiva preset locali
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['csshero_action']) && $_GET['csshero_action']=='activate_snapshot') {
		
		
		
															//global $wpcss_current_settings_array; //sara letto dopo dal ciclo dei font della header percio va settato bene
															$step_id=$_GET['step_id'];
															if (!is_numeric($step_id)) die ("<h1>Invalid step id, not numeric!");
															$wpcss_settings_history_step=get_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$step_id);
																
															update_option('wpcss_current_settings_array_'.wpcss_current_theme_slug(),$wpcss_settings_history_step);
																
													//Save which is the active current history step 
													 update_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug(),$step_id);
													
		
															include('assets/mini-redirect.php');
																
																}
		
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='delete_history_snapshots') {
		
		
													$current_step_id=	get_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug());
															$wpcss_history_steps_array=get_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug());
															$new_wpcss_history_steps_array=array();
														 
																						
																foreach($wpcss_history_steps_array as $history_element):
																	
																		
																							if ($history_element['snapshot_type']=='preset' or $current_step_id==$history_element['step_id'])
																							
																														{ $new_wpcss_history_steps_array[]=$history_element; //si tenne
																																}
																							
																																 else  delete_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$history_element['step_id']);
																																										 
		
																endforeach;
																
														 update_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug(),$new_wpcss_history_steps_array);   
													 
															
															  
																	
															die("History Snapshots deleted.");
																
														}
		
		if (!isset($_POST['wpcss_submit_form']) && isset($_GET['wpcss_action']) && $_GET['wpcss_action']=='rename_snapshot') {
		
															//save history NEW
																					$wpcss_history_steps_array=get_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug());
																					if (!$wpcss_history_steps_array) $wpcss_history_steps_array=array();
																							
																							
																							
																							
																					  $current_step_id=get_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug());
																							
																							
																							
																					 foreach($wpcss_history_steps_array as &$history_element):
																														  
																																		 if ($history_element['step_id']!=$current_step_id) continue;
																																						$history_element['snapshot_type']= "preset";
																																	 $history_element['snapshot_name']= $_GET['newname'];
																					
																			endforeach;
																			
																			
																			 
																						  
																					//Save history steps definition list
																					update_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug(),$wpcss_history_steps_array);
																						
																					//end save history new
																						die("Preset Saved.");
															//include('assets/mini-redirect.php');
															
															}
															
		
		//new nano   loading
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='edit_page')  {require_once('edit-page.php'); exit;}
						
		//CSSHERO SHUTDOWN			
		if (isset($_GET['csshero_action']) && $_GET['csshero_action'] =="shutdown" && current_user_can("edit_theme_options") )  {setcookie('csshero_is_on', 0, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		wp_redirect(add_query_arg( array('csshero_action' => false ) ));die;
			}
		
		//WHEN CSSHERO IS ON ELIMINATE WP ADMIN BAR WHEN PERFORMING EDITING ACTIONS
		if (isset($_COOKIE['csshero_is_on']) && $_COOKIE['csshero_is_on']==1 && current_user_can("edit_theme_options")
			&& (!isset($_GET['csshero_action']) OR  $_GET['csshero_action'] !="shutdown")
			)  {add_filter('show_admin_bar', '__return_false');add_filter( 'edit_post_link', '__return_false' );}
		
					
		
		
		//history or preset list ajax loading result
		if (isset($_GET['csshero_action']) && $_GET['csshero_action']=='list_saved_snapshots' && isset($_GET['snapshot_type']) ) 
		
		{						  					$printed_elements=0;
														$wpcss_history_steps_array=get_option('wpcss_snapshots_index_array_'.wpcss_current_theme_slug());
															//print_r($wpcss_history_steps_array); 
															if ($wpcss_history_steps_array):
																				?><ul><?php
																					   $wpcss_history_steps_array=array_reverse($wpcss_history_steps_array);
																											foreach($wpcss_history_steps_array as $history_element):
																																									   if ($history_element['snapshot_type']!=$_GET['snapshot_type'])  continue;
																																										
																																											//print_r(get_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$step_id));
																																										
																																											if (get_option('wpcss_snapshots_active_step_id_'.wpcss_current_theme_slug())==$history_element['step_id'] ) { $activeflag="csshero-active-history-element";     } else {$activeflag="csshero-non-active-history-element";}
																																											
																																											$printed_elements++;
																																											?>
																																											<li class="<?php echo $activeflag; ?>" id="csshero-step-id-<?php echo $history_element['step_id'] ?>">
																																											<?php echo $history_element['snapshot_name'] ?>
																																											<a class="preview-saved-step-trigger" href='?csshero_action=preview_step&step_id=<?php echo $history_element['step_id'] ?>'>Preview</a>
																																											<a class="activate-saved-step-trigger" href='?csshero_action=activate_snapshot&step_id=<?php echo $history_element['step_id'] ?>'>Activate</a></li>
																																											
																																											<?php
																																								 
																																										
																													
																											endforeach;
																						?></ul><?php 					
																	endif;
																	if ($printed_elements==0)   echo "<p style='padding:10px';>None yet.</p>";
																	die;
		}
		
		
		
		
		
		


     }
add_action ('wp_loaded','wpcss_handle_actions');
 
 
   

function wpcss_hero_admin_notice() {
    ?>
    <div class="updated">
	<h2> Welcome to CSSHero.</h2>
	<p> Let's activate your product. It's fast and easy! Click the button and let's go.</p>
	<a class="button button-primary button-hero " href="<?php BLOGINFO('url'); ?>?wpcss_action=activation">Get my key now!</a></p>
    </div>
    <?php
}


 
 
 
 
 
add_action('wp_head', 'wpcss_add_header_stuff');  //adds stuff to theme header for adding custom dynamic css and used fonts
 
function wpcss_add_header_stuff()

{
								//global $_GET; if (isset($_GET['wpcss_disable_all']) && $_GET['wpcss_disable_all']=1) return;
       
								?><!-- Start CSSHero.org Dynamic CSS & Fonts Loading -->
	      <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('url');?>/?wpcss_action=show_css<?php
							 	if ( current_user_can('edit_theme_options') && isset($_GET['csshero_action']) && $_GET['csshero_action']=='preview_step' && isset($_GET['step_id']) ) echo "&step_id=".$_GET['step_id'];
								if ( current_user_can('edit_theme_options')) echo "&rnd=".rand(0,1024); ?>" data-apply-prefixfree />
	      <?php 	$used_fonts_array=csshero_get_used_google_fonts_array();
								if ($used_fonts_array)
												{ ?><link href='http://fonts.googleapis.com/css?family=<?php foreach($used_fonts_array as $font):  echo str_replace(' ','+',$font)."|";  endforeach; ?>' rel='stylesheet' type='text/css'> 	<?php } // end if
							 ?> <!-- End CSSHero.org Dynamic CSS & Fonts Loading -->    
										<?php   
}
     
     
     
      

function wpcss_addscripts() {//INCLUDE JS LIBRARIES AND STUFF 
 
 
		 wp_enqueue_script('prefixfree', plugins_url('/assets/js/prefixfree.min.js', __FILE__)); //prefix free. Thanks Lea, you're a star!
 
 
}    
 
add_action('wp_enqueue_scripts', 'wpcss_addscripts');  



 

function wpcss_share_current_preset()
{
	$the_data=(base64_encode( (get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()))));
	
	$args = array(
	'body' => array( 'site_url' => get_bloginfo('url'), 'preset_data' => $the_data, 'preset_name' => $_GET['preset_name'], 'theme_slug'=>wpcss_current_theme_slug()),
	'user-agent' => 'Css Hero'
	);
	
	$resp = wp_remote_post( 'http://csshero.org/share-preset', $args );
	
	die("Fatto!");
}




 





//PLUGIN ACTIVATION
register_activation_hook( __FILE__, 'wpcss_pluginInstall' );

    function wpcss_pluginInstall() {
  
// da fare volendo
    }
    
    
  
	



 


function wpcss_check_license()
{
  $license= get_option('csshero-license');
   if ($license !=FALSE && strlen($license)>10)
			{ return $license; 	}
		else return FALSE;
 
}

 
function wpcss_IsHexValidColor($hex_color)
{

								if(preg_match('/^#[a-f0-9]{6}$/i', $hex_color)) return TRUE; else return FALSE;
 }

 
function wpcss_SavePaletteFromImage($imgurl){
	
	$ch = curl_init();
	$url = 'http://pictaculous.com/api/1.0/';
	 
	$fields = array('image'=>file_get_contents($imgurl));
	 
	# Set some default CURL options
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_URL, $url);
	 
	$json = curl_exec($ch);
	$colourlist= substr($json,19,44);
	
	$color_array=array();
		
		
	if ($debug) echo $colourlist;
	
	$hex_color_1="#".substr($colourlist,1,6);
	
	if (wpcss_IsHexValidColor($hex_color_1)) $color_array[]=$hex_color_1;
	
	$hex_color_2="#".substr($colourlist,10,6);
	
	if (wpcss_IsHexValidColor($hex_color_2)) $color_array[]=$hex_color_2;
	
	 
	$hex_color_3="#".substr($colourlist,19,6);
	if (wpcss_IsHexValidColor($hex_color_3)) $color_array[]=$hex_color_2;
	
	 
	$hex_color_4="#".substr($colourlist,28,6);
	if (wpcss_IsHexValidColor($hex_color_4)) $color_array[]=$hex_color_4;
 
 
	$hex_color_5="#".substr($colourlist,37,6);
	 if (wpcss_IsHexValidColor($hex_color_5)) $color_array[]=$hex_color_5;

	 
	
	//print_r($color_array);die;//for debug
	
	update_option("wpcss-image-palette",$color_array);
	// 
	 
	  
}



//print_r(get_option("wpcss-image-palette"));die;


function wpcss_get_property_value_from_slug($slug)
{
    $wpcss_current_settings_array=csshero_get_configuration_array();
    return $wpcss_current_settings_array[$slug]['property_value'];
}




//get property example
// echo  wpcss_get_property_value_from_slug("site-header-h1-a-color");die;


function csshero_get_configuration_array($step_id="default")
{
     if ($step_id=="default")
     {
          $wpcss_current_settings_array=unserialize(get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()));
     }
     
     else {
             	if (!is_numeric($_GET['step_id'])) die ("<h1>Invalid step id, not numeric!");
                $wpcss_current_settings_array=unserialize(get_option('wpcss_theme_settings_snapshot_array_'.wpcss_current_theme_slug().'-'.$_GET['step_id']));
           
          }
          
      return $wpcss_current_settings_array;  
}

 

function wpcss_gp(){ return "&custom_version_flag=".get_option("hero_custom_version_flag"); }



function csshero_get_used_google_fonts_array()
{
            if ( current_user_can('edit_theme_options') && isset($_GET['csshero_action']) && $_GET['csshero_action']=='preview_step' && isset($_GET['step_id']) )
												
												$wpcss_current_settings_array=csshero_get_configuration_array($_GET['step_id']);
												else
												$wpcss_current_settings_array=csshero_get_configuration_array();
            
            
            //print_r($wpcss_current_settings_array);die;
            
            
            $used_fonts_array=array(); 
            
      
     
            if ($wpcss_current_settings_array) foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
                      
                      if (  $new_css_row->property_name =='font-family' && $new_css_row->font_source =='google'   &&  strlen( $new_css_row->property_value)>2 ) $used_fonts_array[]=$new_css_row->property_value; //take all properties with slug containing font-family like header-font-family
                        
                 
            endforeach;
  
            
            return array_unique($used_fonts_array);
}







 
function csshero_add_footer_trigger() {
						if (
							( !current_user_can('edit_theme_options') or    !wpcss_check_license() 	 ) &&
							(!isset($_GET['csshero_action']) OR  $_GET['csshero_action'] !="shutdown")
							) return;
	 
				?><div id="csshero-very-first-trigger"   ><a href="<?php echo add_query_arg( 'csshero_action', 'edit_page' )  ?>"></a></div>
				<style>
					/* NEW STARTUP BUTTON */
						#csshero-very-first-trigger{position:fixed;top:40px;right:30px;z-index: 999999999;background: transparent url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png?v737473) no-repeat 0px -535px; width: 48px; height: 48px; -webkit-transition: width .5s ease-in-out;-moz-transition: width .5s ease-in-out;-o-transition: width .5s ease-in-out;transition: width .5s ease-in-out;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;overflow: hidden;}
						#csshero-very-first-trigger:hover{width: 98px; animation: cssherobganim 2s linear infinite;}
						#csshero-very-first-trigger a{width: 198px; height: 48px; display: block; background: transparent url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png?v73747) no-repeat 0px -583px; cursor: pointer;-webkit-transition: margin-left .3s ease-in-out;-moz-transition: margin-left .3s ease-in-out;-o-transition: margin-left .3s ease-in-out;transition: margin-left .3s ease-in-out;}
						#csshero-very-first-trigger a:hover{margin-left: -50px;}
						@keyframes cssherobganim{from { background-position: 0 -535px; } to { background-position: 100% -535px; }}
				</style>
				
				<?php
}
add_action('wp_footer', 'csshero_add_footer_trigger');





// THIS GIVES US SOME OPTIONS FOR STYLING THE upload ADMIN AREA
function csshero_custom_upload_style() {
	
	
      echo '<style type="text/css">
       							tr.post_title , tr.align , tr.image_alt, tr.post_excerpt, tr.post_content ,tr.url{display:none}
						  		
						  		
						  		td.savesend{text-align: right;}
						  		tr.submit .savesend input:hover,
						  		tr.submit .savesend input {background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png?v6) no-repeat 0px -862px; height: 70px; z-index:999;border: 0px;padding:0px;width: 208px;border-radius: 0px;-moz-border-radius: 0px;-webkit-border-radius: 0px; text-indent: -9999px;}
						  		#media-upload a.del-link:active,
						  		tr.submit .savesend input:active{position: relative; top: 1px;}
								
								#media-upload a.del-link:hover,
								#media-upload a.del-link{height: 70px; width: 101px; background: url(http://www.csshero.org/csshero-nano-service/assets/img/esprit.png?v6) no-repeat -208px -862px; display: inline-block; float: right; margin: 0px 2px 0px 10px; text-indent: 999px;}
								
								
								tr.submit{border-top: 1px solid #dfdfdf;}
								tr.submit .savesend{padding-top: 15px;}
								
								div#media-upload-header{padding: 0px; border: 0px; background: #222; position: fixed; top: 0px; left: 0px; width: 100%; height: 48px; z-index: 9999;}
								#sidemenu a.current {padding-left: 20px; padding-right: 20px; font-weight: normal; text-decoration: none; background: #3e7cff; color: white;-webkit-border-top-left-radius: 0px;-webkit-border-top-right-radius: 0px;border-top-left-radius: 0px;border-top-right-radius: 0px;border-width: 0px;}
								#sidemenu a{padding: 10px 20px; border: 0px; background: transparent; color: white; font-size: 10px; text-transform: uppercase;}
								body#media-upload{padding-top: 50px; background: #f5f5f5; height: 100%;}
								body#media-upload ul#sidemenu{bottom: 0; margin: 0px; padding: 0px;}
								#sidemenu a:hover{background:#222;}
								h3.media-title{font-family: sans-serif; font-size: 10px; font-weight: bold; text-transform: uppercase;}
								h3.media-title,.upload-flash-bypass,.max-upload-size{display: block;text-align: center;}
								.upload-flash-bypass{margin-top: 20px;}
								.max-upload-size{margin-bottom: 20px;}
								#sidemenu li#tab-type_url,
								#sidemenu li#tab-grabber{display: none;}
								
								
								
         </style>';
}

if (isset($_GET['csshero_upload']) && $_GET['csshero_upload']==1) add_action('admin_head', 'csshero_custom_upload_style');



?>