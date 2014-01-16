<!DOCTYPE html><html <?php language_attributes(); ?>><head><meta charset="utf-8">
 
<title><?php wp_title() ?></title>
 
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
 <!-- 
<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/modernizr.custom.79639.js"></script>
-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/style.css" />
<?php wp_head(); ?>
 
<style id="additional-live-styles"></style>
</head>
<body <?php global $class; body_class( $class ); ?>>
<div id="global-wrapper" >
<!--				
<div id="header">
    
				<div class="social" style="display: none">
								<a href="http://twitter.com"><i class="icon-twitter icon-2x"></i></a>
								<a href="http://facebook.com"><i class="icon-facebook-sign icon-2x"></i></a>
								<a href="http://facebook.com"><i class="icon-facebook icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-pinterest icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-tumblr-sign icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-linkedin icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-skype icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-google-plus-sign icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-youtube icon-2x"></i></a>
								<a href="http://pinterest.com"><i class="icon-github icon-2x"></i></a>
								</div>
				
								
				<div id="logo"><?php if (get_header_image() != '') { ?><a href="<?php bloginfo('url'); ?>"><img class="headerLogo" src="<?php echo get_header_image() ?>" alt="<?php bloginfo('name') ?>" /></a><?php } else { ?><h1><a class="siteName" href="<?php bloginfo('url'); ?>"><?php bloginfo('name') ?></a></h1><?php } ?></div>
				<div class="tagline"><?php bloginfo('description'); ?></div>
				<div id="nav"><?php wp_nav_menu (array ( 'theme_location' => 'nav-menu') ); ?></div>
</div>
-->


<ul id="menu"> </ul>
