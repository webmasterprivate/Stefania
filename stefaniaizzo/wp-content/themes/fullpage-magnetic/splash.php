<?php
/*
Template Name: Splash
*/
get_header(); ?><style>#header,.s1NavContainer,.s1,#footer,#blogSidebar{display:none}</style><?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?><div class="s1NavContainer"><div class="s1Nav"></div></div><div class="s1"><?php echo do_shortcode("[wide_gallery]"); ?></div><div id="main"><div id="content"><?php the_content(); ?><ul id="blogSidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar") ) : endif; ?></ul></div></div><?php endwhile; get_footer(); ?>