<?php if ( ! isset( $content_width ) ) $content_width = 960;
add_editor_style('custom-editor-style.css');
add_theme_support( 'automatic-feed-links' );
remove_filter('the_content', 'wpautop');
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'status' ) );

function rename_post_formats($translation, $text, $context, $domain) {
    $names = array(
        'Aside'  => 'Big Left',
        'Status' => 'Small Left',
        'Gallery' => 'Big Right',
        'Image' => 'Small Right'
    );
    if ($context == 'Post format') {
        $translation = str_replace(array_keys($names), array_values($names), $text);
    }
    return $translation;
}
add_filter('gettext_with_context', 'rename_post_formats', 10, 4);

function base_pagination() {
	global $wp_query;
 
	$big = 999999999;
 
	$paginate_links = paginate_links( array(
	    'prev_text' => 'Previous',
	    'next_text' => 'Next',
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5
	) );

	if ( $paginate_links ) {
		echo '<div class="pagination">';
		echo $paginate_links;
		echo '</div>';
	}
}

function setup_theme_admin_menus() {
    add_menu_page(
	'Theme settings',
	'Hero One Page',
	'manage_options',
        'tut_theme_settings',
	'theme_settings_page',
	content_url('/themes/h-onepage/icon.gif')
	);
    add_submenu_page('tut_theme_settings', 
        'Front Page Elements', 'Front Page', 'manage_options', 
        'front-page-elements', 'theme_front_page_settings'); 
}

// We also need to add the handler function for the top level menu
function theme_settings_page() {
    echo "General Theme Setting";
}
// This tells WordPress to call the function named "setup_theme_admin_menus"  
// when it's time to create the menu pages.  
add_action("admin_menu", "setup_theme_admin_menus");

function theme_front_page_settings() {
    echo "Hello, world!";
?>   
 <div class="wrap">
        <?php screen_icon('themes'); ?> <h2>Front page elements</h2>

        <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="num_elements">
                            Number of elements on a row:
                        </label> 
                    </th>
                    <td>
                        <input type="text" name="num_elements" size="25" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php
if (!current_user_can('manage_options')) {
    wp_die('Sorry, you do not have sufficient permissions to access this page.');
}
}


function contact_form($atts) {
	ob_start();
	include_once("contact.php");
	$output_string=ob_get_contents();;
	ob_end_clean();
	return $output_string;
	}

add_shortcode('contact', 'contact_form');

function img_slides($postid=0, $size='full', $attributes='') {
        $gallerywrap = '<div class="flexslider2"><ul class="slides">';
        if ($postid<1) $postid = get_the_ID();
        if ($images = get_children(array(
                'post_parent' => $postid,
                'post_type' => 'attachment',
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'numberposts' => 0,
                'post_mime_type' => 'image',)))
                foreach($images as $image) {
                        $attachment=wp_get_attachment_image_src($image->ID, $size);
                        $gallerywrap .= '<li><img src="'.$attachment[0].'"></li>';
                }
        $gallerywrap .= '</ul></div>';
	$gallerywrap .= '<script type="text/javascript">$(window).load(function(){$(\'.flexslider2\').flexslider({slideshow: false,animation: "slide",keyboardNav: true});});</script>';
	return $gallerywrap;
}
add_shortcode('img_slides','img_slides');

function img_gallery($postid=0, $size='thumbnails', $attributes='') {
        $gallerywrap = '<div class="imgGallery">';
        if ($postid<1) $postid = get_the_ID();
        if ($images = get_children(array(
                'post_parent' => $postid,
                'post_type' => 'attachment',
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'numberposts' => 0,
                'post_mime_type' => 'image',)))
                foreach($images as $image) {
                        $attachment=wp_get_attachment_image_src($image->ID, $size);
                        $gallerywrap .= '<a href="'.$attachment[0].'"><img src="'.$attachment[0].'"></a>';
                }
        $gallerywrap .= '</div>';
	$gallerywrap .= '<script type="text/javascript">$(window).load(function(){$(\'.flexslider2\').flexslider({slideshow: false,animation: "slide",keyboardNav: true});});</script>';
	return $gallerywrap;
}
add_shortcode('img_gallery','img_gallery');

function wide_gallery($postid=0, $size='full', $attributes='') {
        $gallerywrap = '<div class="flexslider"><ul class="slides">';
        if ($postid<1) $postid = get_the_ID();
        if ($images = get_children(array(
                'post_parent' => $postid,
                'post_type' => 'attachment',
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'numberposts' => 0,
                'post_mime_type' => 'image',)))
                foreach($images as $image) {
                        $attachment=wp_get_attachment_image_src($image->ID, $size);
                        $gallerywrap .= '<li><img src="'.$attachment[0].'"></li>';
                }
        $gallerywrap .= '</ul></div>';
	$gallerywrap .= '<script type="text/javascript">$(window).load(function(){$(\'.flexslider\').flexslider({slideshow: true,animation: "slide",keyboardNav: true});});</script>';
	return $gallerywrap;
}
add_shortcode('wide_gallery','wide_gallery');

add_theme_support( 'custom-background', array(
	'default-color' => 'fff',
	'default-image' => ''
) );

add_theme_support( 'custom-header' );

$defaults = array(
	'default-image'          => '',
	'random-default'         => false,
	'width'                  => 0,
	'height'                 => 0,
	'flex-height'            => false,
	'flex-width'             => false,
	'default-text-color'     => '',
	'header-text'            => false,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );

add_filter('gallery_style', create_function('$a', 'return preg_replace("%<style type=\'text/css\'>(.*?)</style>%s", "", $a);'));

function my_admin_menu() {
    $page = add_theme_page( 'Text Colors', 'Text Colors', 'edit_theme_options', 'my-theme-options', 'my_theme_options' );
    add_action( 'admin_print_styles-' . $page, 'my_admin_scripts' );
}
add_action( 'admin_menu', 'my_admin_menu' );

function my_theme_options() {
    ?>
    <div class="wrap">
        <?php screen_icon( 'themes' ); ?>
        <h2>Theme Options</h2>

        <form method="post" action="options.php">
            <?php wp_nonce_field( 'update-options' ); ?>
            <?php settings_fields( 'my-theme-options' ); ?>
            <?php do_settings_sections( 'my-theme-options' ); ?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="Save Changes" />
            </p >
        </form>
    </div>
    <?php
}

function my_admin_init() {

    register_setting( 'my-theme-options', 'my-theme-options' );
    
    add_settings_section( 'section_text', 'Text and Links Colors: Hex Values (#ffffff)', 'my_section_text', 'my-theme-options' );
    
    add_settings_field( 'color', 'Body Text', 'my_setting_color', 'my-theme-options', 'section_text' );
    add_settings_field( 'color1', 'H1 Headlines', 'my_setting_color1', 'my-theme-options', 'section_text' );
    add_settings_field( 'color2', 'H2 Headlines', 'my_setting_color2', 'my-theme-options', 'section_text' );
    add_settings_field( 'color3', 'H3 Headlines', 'my_setting_color3', 'my-theme-options', 'section_text' );
    add_settings_field( 'color4', 'H4 Headlines', 'my_setting_color4', 'my-theme-options', 'section_text' );
    add_settings_field( 'color5', 'H5 Headlines', 'my_setting_color5', 'my-theme-options', 'section_text' );
    add_settings_field( 'color6', 'H6 Headlines', 'my_setting_color6', 'my-theme-options', 'section_text' );
    add_settings_field( 'color7', 'Links', 'my_setting_color7', 'my-theme-options', 'section_text' );
    add_settings_field( 'color8', 'Visited Links', 'my_setting_color8', 'my-theme-options', 'section_text' );
    add_settings_field( 'color9', 'Hover Links', 'my_setting_color9', 'my-theme-options', 'section_text' );
    add_settings_field( 'color10', 'Active Links', 'my_setting_color10', 'my-theme-options', 'section_text' );
}
add_action( 'admin_init', 'my_admin_init' );

function my_section_general() {
    _e( 'The general section description goes here.' );
}

/* Color Picker Fields */

function my_setting_color() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color]" id="color"  value="<?php echo esc_attr( $options['color'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker1"></div>
    </div>
    <?php
}

function my_setting_color1() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color1]" id="color1"  value="<?php echo esc_attr( $options['color1'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker2"></div>
    </div>
    <?php
}
function my_setting_color2() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color2]" id="color2"  value="<?php echo esc_attr( $options['color2'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker3"></div>
    </div>
    <?php
}
function my_setting_color3() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color3]" id="color3"  value="<?php echo esc_attr( $options['color3'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker4"></div>
    </div>
    <?php
}
function my_setting_color4() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color4]" id="color4"  value="<?php echo esc_attr( $options['color4'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker5"></div>
    </div>
    <?php
}
function my_setting_color5() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color5]" id="color5"  value="<?php echo esc_attr( $options['color5'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker6"></div>
    </div>
    <?php
}
function my_setting_color6() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color6]" id="color6"  value="<?php echo esc_attr( $options['color6'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker7"></div>
    </div>
    <?php
}
function my_setting_color7() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color7]" id="color7"  value="<?php echo esc_attr( $options['color7'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker8"></div>
    </div>
    <?php
}
function my_setting_color8() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color8]" id="color8"  value="<?php echo esc_attr( $options['color8'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker9"></div>
    </div>
    <?php
}
function my_setting_color9() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color9]" id="color9"  value="<?php echo esc_attr( $options['color9'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker10"></div>
    </div>
    <?php
}
function my_setting_color10() {
    $options = get_option( 'my-theme-options' );
    ?>
    <div class="color-picker" style="position: relative;">
        <input type="text" name="my-theme-options[color10]" id="color10"  value="<?php echo esc_attr( $options['color10'] ); ?>" />
        <div style="position: absolute;margin:-110px 0 0 220px" id="colorpicker11"></div>
    </div>
    <?php
}

function my_wp_head() {
    $options = get_option( 'my-theme-options' );
    if($options['color']!='') {$style .= "body{color:".$options['color']."}";}
    if($options['color1']!='') {$style .= "h1{color:".$options['color1']."}";}
    if($options['color2']!='') {$style .= "h2{color:".$options['color2']."}";}
    if($options['color3']!='') {$style .= "h3{color:".$options['color3']."}";}
    if($options['color4']!='') {$style .= "h4{color:".$options['color4']."}";}
    if($options['color5']!='') {$style .= "h5{color:".$options['color5']."}";}
    if($options['color6']!='') {$style .= "h6{color:".$options['color6']."}";}
    if($options['color7']!='') {$style .= "a:link{color:".$options['color7']."}";}
    if($options['color8']!='') {$style .= "a:visited{color:".$options['color8']."}";}
    if($options['color9']!='') {$style .= "a:hover{color:".$options['color9']."}";}
    if($options['color10']!='') {$style .= "a:active{color:".$options['color10']."}";}
   // if($style != '') {echo "<style>".$style."</style>";}
}
add_action( 'wp_head', 'my_wp_head' );
add_action( 'init', 'register_my_menus' );
add_theme_support( 'post-thumbnails' );
function register_my_menus() {register_nav_menus(array('nav-menu' => __( 'Nav' ),'footer-menu' => __( 'Footer' )));}
if ( function_exists('register_sidebar') ) {register_sidebar(array('name' => 'sidebar',));}
function one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'one_third_last');

function two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'two_third');

function two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'two_third_last');

function one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'one_half');

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'one_half_last');

function one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'one_fourth_last');

function three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'three_fourth');

function three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'three_fourth_last');

function one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'one_fifth');

function one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'one_fifth_last');

function two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'two_fifth');

function two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'two_fifth_last');

function three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'three_fifth');

function three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'three_fifth_last');

function four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'four_fifth');

function four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'four_fifth_last');

function one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'one_sixth');

function one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'one_sixth_last');

function five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'five_sixth');

function five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'five_sixth_last');

function red_button($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Submit',
			'link' => '',
			'size' => 'normal'
		), $atts);
	return '<a href="' . $atts['link'] . '" class="' . $atts['size'] . ' red_button">' . $atts['label'] . '</a>';
};
add_shortcode('red_button','red_button');

function green_button($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Submit',
			'link' => '',
			'size' => 'normal'
		), $atts);
	return '<a href="' . $atts['link'] . '" class="' . $atts['size'] . ' green_button">' . $atts['label'] . '</a>';
};
add_shortcode('green_button','green_button');

function blue_button($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Submit',
			'link' => '',
			'size' => 'normal'
		), $atts);
	return '<a href="' . $atts['link'] . '"  class="' . $atts['size'] . ' blue_button">' . $atts['label'] . '</a>';
};
add_shortcode('blue_button','blue_button');

function grey_button($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Submit',
			'link' => '',
			'size' => 'normal'
		), $atts);
	return '<a href="' . $atts['link'] . '"  class="' . $atts['size'] . ' grey_button">' . $atts['label'] . '</a>';
};
add_shortcode('grey_button','grey_button');

function custom_button($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Submit',
			'link' =>  '',
			'size' => 'normal',
			'background' => '',
			'text' => '',
			'rounded' => '',
			'image' => '',
			'repeat' => 'repeat',
			'position' => 'top left'
		), $atts);
	return '<a style="color:' . $atts['text'] . ';border-radius:' . $atts['rounded'] . 'px;-moz-border-radius:' . $atts['rounded'] . 'px;-webkit-border-radius:' . $atts['rounded'] . 'px;background:' . $atts['background'] . ' url(\'' . $atts['image'] . '\') ' . $atts['repeat'] . ' ' . $atts['position'] . '" href="' . $atts['link'] . '"  class="' . $atts['size'] . ' custom_button">' . $atts['label'] . '</a>';
};
add_shortcode('custom_button','custom_button');

function alert_window($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Alert'
		), $atts);
	return '<div class="alertWin">' . $atts['label'] . '</div>';
};
add_shortcode('alert_window','alert_window');

function note_window($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Note'
		), $atts);
	return '<div class="noteWin">' . $atts['label'] . '</div>';
};
add_shortcode('note_window','note_window');

function success_window($atts){
	$atts = shortcode_atts(
		array(
			'label' => 'Success'
		), $atts);
	return '<div class="successWin">' . $atts['label'] . '</div>';
};
add_shortcode('success_window','success_window');

function rule(){
	return '<div class="rule"></div>';
};
add_shortcode('rule','rule'); 

add_action('after_setup_theme', 'boiler_setup');
function boiler_setup(){
    load_theme_textdomain('boiler', get_template_directory() . '/languages');
}

function youtube_embed($atts) {
extract(shortcode_atts(array(
"video_code" => '',
"width" => '560',
"height" => '349',
), $atts));
return '<div class="youCode"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_code.'" frameborder="0" allowfullscreen></iframe></div>';
}
add_shortcode("youtube", "youtube_embed");

function vimeo_embed($atts) {
extract(shortcode_atts(array(
"video_code" => '',
"width" => '560',
"height" => '349',
), $atts));
return '<div class="vimCode"><iframe src="http://player.vimeo.com/video/'.$video_code.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
}
add_shortcode("vimeo", "vimeo_embed");





//ADD SCRIPTS


function wponepage_add_scripts() {



																//if (0) wp_enqueue_script(
																//	'flexslider',
																//get_template_directory_uri().'/js/jquery.flexslider.js',
																//	array( 'jquery' )
																//);
																//
																// 
																//if (0) wp_enqueue_script(
																// 	'tubular',
																//				 get_template_directory_uri().'/js/jquery.tubular.1.0.js',
																//				 	array( 'jquery' )
																// );
																// 	
																//	
																//if (0) wp_enqueue_script(
																// 	'okvideo',
																//				 get_template_directory_uri().'/js/okvideo.js',
																//				 	array( 'jquery' )
																// );
																// 	
																 		
																 	
															 wp_enqueue_script( 'jquery-ui-core', array('jquery') );
															 wp_enqueue_script("jquery-effects-core",  array( 'jquery','jquery-ui-core' ));
															  wp_enqueue_script( 'fullpage', get_template_directory_uri().'/js/jquery.fullPage.min.js', array( 'jquery','jquery-ui-core' ) );
																 	
														//			
														//wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js' ); //add waypoints
														//
														//wp_enqueue_script( 'waypoints-sticky', get_template_directory_uri() . '/js/waypoints-sticky.js' ); //add waypoints
														//
														//wp_enqueue_script( 'waypoints-infinite', get_template_directory_uri() . '/js/waypoints-infinite.min.js' ); //add waypoints
														//																
																													//	
																//	wp_enqueue_script( 'jquery-ui-widget', array('jquery-ui-core', 'jquery') );
																//	wp_enqueue_script( 'jquery-ui-mouse', array('jquery-ui-core', 'jquery') );
																//	wp_enqueue_script( 'jquery-ui-tabs', array('jquery-ui-core', 'jquery')  );
																//	
																//	wp_enqueue_script( 'jquery-ui-draggable', array('jquery-ui-core', 'jquery') ); //DRAGGABLE & RESIZABLE
																//	wp_enqueue_script( 'jquery-ui-resizable', array('jquery-ui-core', 'jquery') );
																//	
																//	wp_enqueue_script( 'jquery-ui-slider', array('jquery') );
																//	
																//	
																//	wp_enqueue_style( 'wp-jquery-ui-dialog' );
																	
																	
																
}

add_action( 'wp_enqueue_scripts', 'wponepage_add_scripts' );








/// CUSTOM POST TYPE FOR HANDLING HOMEPAGE BLOCKS

add_action( 'init', 'register_cpt_homepage_block' );

function register_cpt_homepage_block() {

    $labels = array( 
        'name' => _x( 'Homepage Blocks', 'homepage_block' ),
        'singular_name' => _x( 'Homepage Block', 'homepage_block' ),
        'add_new' => _x( 'Add New', 'homepage_block' ),
        'add_new_item' => _x( 'Add New Homepage Block', 'homepage_block' ),
        'edit_item' => _x( 'Edit Homepage Block', 'homepage_block' ),
        'new_item' => _x( 'New Homepage Block', 'homepage_block' ),
        'view_item' => _x( 'View Homepage Block', 'homepage_block' ),
        'search_items' => _x( 'Search Homepage Blocks', 'homepage_block' ),
        'not_found' => _x( 'No homepage blocks found', 'homepage_block' ),
        'not_found_in_trash' => _x( 'No homepage blocks found in Trash', 'homepage_block' ),
        'parent_item_colon' => _x( 'Parent Homepage Block:', 'homepage_block' ),
        'menu_name' => _x( 'Homepage Blocks', 'homepage_block' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'These content blocks go in the site homepage. ',
        'supports' => array( 'title','slug', 'editor', 'author', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes' ),
        
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 15,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'page'
    );

    register_post_type( 'homepage_block', $args );
}



function the_slug() {
	global $post;
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
}


?>