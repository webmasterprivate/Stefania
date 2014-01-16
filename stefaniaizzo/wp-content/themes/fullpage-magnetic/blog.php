<?php
/*
Template Name: Blog
*/
get_header(); ?>
<div id="main"><div id="content"><h1><?php the_title(); ?></h1><?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $args= array('category_name' => 'blog','paged' => $paged ); query_posts($args); if( have_posts() ) : get_template_part( 'loop' ); else : ?><p><h1><?php _e('Nothing Found','boiler'); ?></h1></p><?php endif; ?><ul id="blogSidebar"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar") ) : endif; ?></ul></div></div><?php get_footer(); ?>