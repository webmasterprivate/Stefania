<?php
/*
Template Name: Homepage
*/

$class="frontpage";
 
get_header(); ?>

<!-- <div  id="main-content" class="global-loading"> -->
 <?php
 ////QUERY BLOCK ///////////////
query_posts(array( 
		'post_type' => 'homepage_block',
		'showposts' => 40,
		'post_status' =>'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_parent' => 0,
	) );  
 
$buffer_lista_pagine_home=FALSE; $counter_images=0;

if ( have_posts()) while ( have_posts() ) :

	the_post();

	if ($buffer_lista_pagine_home==FALSE)   $buffer_lista_pagine_home=""; else $buffer_lista_pagine_home.=", ";
	$buffer_lista_pagine_home.="'section-". the_slug()."'";
		  
	  
	//SLIDES ??
	$main_post_backup=$post;
	$parent_slug=the_slug();
	$parent_title=$post->title;
	$parent_id=get_the_ID();//ora cerco le slides figlie di questo section id se ci sono
	$args_query_figli = array( 'post_parent' => $parent_id ,
				   'post_type' => 'homepage_block',
				   'post_status' =>'publish',
				   'orderby' => 'menu_order',
				   'order' => 'ASC',
					);
	$slide_posts = get_posts( $args_query_figli );
	//print_r($slide_posts);
	
	if (!$slide_posts) {
			  //CASO TIPICO - NO SLIDE POSTS: fa solo la singola
			   ?>
			   <div class="section editable main-page-container" editableclass="#<?php echo the_slug() ?>"  data-anchor="section-<?php echo the_slug() ?>" id="<?php echo the_slug() ?>"
																															 
																							    <?php $url_immagine=wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
																							   if ($url_immagine): 
																								 
																									if (1 or $counter_images==0) { ?>style=" background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>'); "<?php }  $counter_images++;  ?> 
																							  
																									data-bgurl="url(<?php echo $url_immagine; ?>)"
																							   <?php endif; ?> >
			  	<div class="page-inner-wrap">
				 
			   <!-- <h2><?php the_title(); ?></h1> -->
			  
			   <?php
			   $src=get_post_meta(get_the_ID(),'fullscreen_url',TRUE);
			   if ($src): ?>
				<!-- 	<div class="vimCode"><iframe src="<?php echo $src; ?>" width="100%" height="700px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div> -->
		 
					
			   <?php endif; ?>
			   <div class="the-content">
					<img style="display: block; margin: 40px auto 50px;" src="http://localhost:8888/stefaniaizzo/wp-content/uploads/2013/11/logo.png">
					<?php the_content(); ?>
			   </div>
			   <?php edit_post_link('Edit Section/block', '<p class="edit-link">', '</p>'); ?>
			   
		   <?php
			 //END CASO TIPICO
			 
			 
		   } else
		{
				//CASO SLIDES PRESENTI
				?>
				
				  
				<div class="section editable  main-page-container " editableclass="#<?php echo the_slug() ?>" data-anchor="section-<?php echo the_slug() ?>" id="<?php echo the_slug() ?>"  >
				<div class="page-inner-wrap">
				<!--  <div class="slides-submenu-container">
					  <h2 class="title-submenu" ><?php echo get_the_title($parent_id); ?></h2> 
					 <ul class="slides-submenu"> </ul>  
				</div> -->
				 <?php
				$voci_submenu_counter=0;	 
				foreach ( $slide_posts as $post ) : 
					setup_postdata( $post ); ?>
					   
					   <div class="slide  " data-anchor="section-<?php echo the_slug() ?>" id="<?php echo the_slug() ?>"
																							   <?php $url_immagine=wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
																								   if ($url_immagine):  
																											
																										 if (1 and $voci_submenu_counter==0) { ?>style=" background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>'); "<?php }  $voci_submenu_counter++; ?> 
																										 
																										  data-bgurl="url(<?php echo $url_immagine; ?>)"
																								   <?php endif; ?> >
					  	<div class="page-inner-wrap">
							 <div class="intro">
								 
								<!-- <h1> <?php the_title(); ?></h1> -->
								<div class="the-content"><?php the_content(); ?></div>
								<?php edit_post_link('Edit Section/block', '<p class="edit-link">', '</p>'); ?>
							</div>
					 </div> <!-- close wrap -->
			</div><!-- close section -->
			<div >procalo</div>
					   <script>
						//POPULATE SLIDES-SUBMENU in botttom area
					   //jQuery("#<?php echo the_slug() ?>").parent().find(".slides-submenu").append('<li id="submenu-li-<?php echo the_slug() ?>"  data-menuanchor="section-<?php echo the_slug() ?>"><a href="#section-<?php echo $parent_slug.'/'; if ($voci_submenu_counter>0 ) echo "section-".the_slug(); else $voci_submenu_counter++; ?>"><?php the_title(); ?></a></li>');
						 	 
						  </script> 
				<?php endforeach; 
			  	
				 ?><script>
					//jQuery("#<?php echo the_slug() ?>").parent().find(".slides-submenu li:first").addClass("selected");
				</script>
				<?php
				
				wp_reset_postdata();
				 $post=$main_post_backup;
				 
		 //END CASO SLIDES
				 
		  }
		   //ora temrino gli script e chiudo il DIV
		  ?>
				<script>
					jQuery("#menu").append('	<li   data-menuanchor="section-<?php echo the_slug() ?>"><a href="#section-<?php echo the_slug() ?>"><?php the_title(); ?></a></li>');
				
				</script>
				</div> <!-- close wrap -->
			</div><!-- close section -->
									 
				
<?php endwhile;

////END QUERY BLOCK ///////////////	   
	  ?>
</div>


	<script type="text/javascript">
		
		
		 
			
			
		jQuery(document).ready(function() {
			
			//TRIGGER MAIN RENDERING ENGINE: FULLPAGE JS.
			
			var pepe = jQuery.fn.fullpage({
				 anchors: [<?php echo $buffer_lista_pagine_home ?>],
				 menu: '#menu',
				 verticalCentered: true,
				 easing: 'easeInQuart',
				 fixedElements: '#element1, .element2',
				 paddingTop: 70, //pixel
				scrollingSpeed: 1300,
				autoScrolling: false,
				    onLeave: function(index, direction){ ///max
					 return;
						var element=this.location.hash;
						var div_id=element.replace("section-","");
						//alert(div_id);
						var data_bgurl=jQuery(div_id).attr("data-bgurl");
						//UNLAZY THE IMAGE BACKGROUND LOADING OF SECTIONS
						//jQuery(div_id).css('background-image',data_bgurl);
						
					},
				
				afterLoad: function(anchorLink, index){
						 
						//	var div_id=anchorLink.replace("section-","#");
							 
						//	var data_bgurl=jQuery(div_id).attr("data-bgurl");
						 
						//	jQuery(div_id).css('background-image',data_bgurl);
					
							 
				},
			
			afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex){
			 
							//alert("sLIDE");
							 var div_id=slideAnchor.replace("section-","#");
							//alert(div_id);
							var data_bgurl=jQuery(div_id).attr("data-bgurl");
							//alert(data_bgurl);
							//UNLAZY THE IMAGE BACKGROUND LOADING OF SLIDES
							jQuery(div_id).css('background-image',data_bgurl);
						
						 
						 //HIGHLIGHT SUBMENU
					//	 jQuery(div_id).parent().parent().parent().find(".slides-submenu .selected").removeClass('selected');
						  
					//		jQuery("#submenu-li-"+(div_id.replace('#',''))).addClass('selected');
						 
					},
					
			 afterRender: function(){
					//jQuery(".global-loading").removeClass("global-loading");
				}				 
				 
				 
			});
			
			
			
			
			 
		});
	</script>

<!-- 
<div id="scroll-down-1" style="position: fixed;bottom: 30px;right:30px;z-index:999">
	<a href="#" style="background: lime;" onclick="jQuery.fn.fullpage.moveSlideUp();">SCROLL Up </a> <br />
	<a href="#" style="background: red;" onclick="jQuery.fn.fullpage.moveSlideDown();">SCROLL Down </a>
	
</div>
-->
 

     
  <!-- <ul id="blogSidebar"><?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar") ) : endif; ?></ul> -->

  <?php 

get_footer(); ?>