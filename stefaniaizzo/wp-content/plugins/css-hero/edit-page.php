<?php $dirname="production";  
 
	  
     setcookie('csshero_is_on', 1, time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);

?>
<html id="cssherohtml">
    <head>
            <script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/jquery.js?ver=1.10.2'></script>
            
												<script type='text/javascript' src='<?php echo plugins_url('/assets/js/prefixfree.min.js', __FILE__); ?>'></script>
												<link rel='stylesheet' id='editorstyle-css'  href='http://www.csshero.org/<?php echo $dirname ?>/style.css' type='text/css' media='all' />
								 
											 <title>CssHero Editor</title>
            
    </head>
    <body id="csshero-workarea">
								
												<div id="csshero-bg-branding"></div>
												<div id="csshero-loading-wheel"></div>
												<?php // enter editing mode
												
												update_option("csshero-is-on", get_current_user_id());
												?>
												<div id="csshero-iframe-main-page-wrap" >
																<iframe id="csshero-iframe-main-page" name="csshero-iframe-main-page" src="<?php echo  remove_query_arg( 'csshero_action' ); ?>" frameborder="0" scrolling="auto" width="100%" height="100%" marginwidth="0" marginheight="0" ></iframe>
												</div>
												
												<textarea id="wp-css-config-quick-editor-textarea-1" style="display: none" name="wp-css-config-quick-editor-textarea-1"><?php echo get_option('wpcss_quick_config_settings_'.wpcss_current_theme_slug()); ?></textarea>
												
												<div id="csshero-save-nonce"> <?php wp_nonce_field('csshero_saving_nonce','csshero_saving_nonce_field'); ?></div>
												
												<script>
												function wpcss_initialize_editor_data()
																	{          
																															jQuery( "body" ).data( "wpcss_current_settings_array", '<?php echo addslashes(json_encode(unserialize(get_option('wpcss_current_settings_array_'.wpcss_current_theme_slug()))));  ?>' );
																															jQuery( "body" ).data( "wpcss_admin_url", ' <?php echo get_admin_url(); ?>' );
																		} 
															
												</script>
											 
												<!--  <script type='text/javascript' src='http://csshero.org/<?php echo $dirname ?>/initialize.php?key=<?php echo wpcss_check_license() ?>&theme=<?php echo wpcss_current_theme_slug() ?>'></script>  -->
												
												<!-- <script type='text/javascript' src='http://csshero.org/<?php echo $dirname ?>/init.php?key=<?php echo wpcss_check_license() ?>&theme=<?php echo wpcss_current_theme_slug() ?>'></script> -->
											 <script type='text/javascript' src='http://csshero.org/production/heroes-loader.php?key=<?php echo wpcss_check_license() ?>&theme=<?php echo wpcss_current_theme_slug().wpcss_gp(); ?>'></script> 
												
												
												
												<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/csshero.js'></script>
							 
									
									
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery.form.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.core.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.widget.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.mouse.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.draggable.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.resizable.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.slider.min.js'></script>
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/jquery.ui.touch-punch.js'></script>
												
													
													
													<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.button.min.js'></script>
														<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/jquery/ui/jquery.ui.dialog.min.js'></script>
														
													
												<script type='text/javascript' src='http://www.csshero.org/<?php echo $dirname ?>/js/iris.min.js'></script>
												
									  
	 
    </body>
</html>
