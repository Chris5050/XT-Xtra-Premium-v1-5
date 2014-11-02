<?php

/***** Fetch Options *****/	

$options = get_option('xt_options');

/***** Custom Hooks *****/ 

function xt_html_class() {
    do_action('xt_html_class');
}
function xt_html_tag() {
    do_action('xt_html_tag');
}
function xt_body_id() {
    do_action('xt_body_id');
}
function xt_container_class() {
    do_action('xt_container_class');
}
function xt_before_header() {
    do_action('xt_before_header');
}
function xt_after_header() {
    do_action('xt_after_header');
}
function xt_content_class() {
    do_action('xt_content_class');
}
function xt_before_page_content() {
    do_action('xt_before_page_content');
}
function xt_before_post_content() {
    do_action('xt_before_post_content');
}
function xt_post_header() {
    do_action('xt_post_header');
}
function xt_post_content() {
    do_action('xt_post_content');
}
function xt_loop_content() {
    do_action('xt_loop_content');
}
function xt_after_post_content() {
    do_action('xt_after_post_content');
}
function xt_sb_class() {
    do_action('xt_sb_class');
}

/***** Enable Shortcodes inside Widgets	*****/

add_filter('widget_text', 'do_shortcode');
	
/***** Theme Setup *****/	

add_action('after_setup_theme', 'xt_themes_setup');
add_action('wp_enqueue_scripts', 'xt_scripts');
add_action('admin_enqueue_scripts', 'xt_admin_scripts');
add_action('widgets_init', 'xt_widgets_init');

function xt_themes_setup() {

	global $content_width;
	
	if (!isset($content_width)) {
		$content_width = 620;
	}
	
	$header = array(
		'default-image'	=> get_template_directory_uri() . '/images/logo.png', 
		'width' => 300,  
		'height' => 100,
		'flex-width' => true,
		'flex-height' => true, 
		'header-text' => false
	);
	add_theme_support('custom-header', $header);
	
	load_theme_textdomain('xt', get_template_directory() . '/languages');
		
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-background');		
	add_theme_support('post-thumbnails');
	
	add_image_size('slider', 940, 400, true);
	add_image_size('content', 620, 264, true);
	add_image_size('spotlight', 580, 326, true);
	add_image_size('loop', 174, 131, true);
	add_image_size('carousel', 174, 98, true);
	add_image_size('cp_large', 300, 225, true);
	add_image_size('cp_small', 70, 53, true);
	
	add_editor_style();
	
	register_nav_menus(array(
		'header_nav' => __('Header Navigation', 'xt'), 
		'main_nav' => __('Main Navigation', 'xt'), 
		'footer_nav' => __('Footer Navigation', 'xt')
	));
}

/***** Load JavaScript *****/

if (!function_exists('xt_scripts')) {
	function xt_scripts() {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
		wp_enqueue_script('jquery');		
		wp_enqueue_script('jquery migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.js');		
		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'));
		if (!is_admin()) {
			if (is_singular() && comments_open() && (get_option('thread_comments') == 1))
				wp_enqueue_script('comment-reply');
		}
	}
}

if (!function_exists('xt_admin_scripts')) {
	function xt_admin_scripts($hook) {
		wp_enqueue_style('xt-admin', get_template_directory_uri() . '/admin/admin.css');
		if ($hook != 'post.php' && $hook != 'post-new.php') {
			return;
		}
		wp_enqueue_script('simplyCountable', get_template_directory_uri() . '/js/jquery.simplyCountable.js');
		wp_enqueue_script('custom-admin-js', get_template_directory_uri() . '/js/custom_admin.js');	
	}
}

/***** Register Widget Areas / Sidebars	*****/

if (!function_exists('xt_widgets_init')) {
	function xt_widgets_init() {
		global $options;
		isset($options['2nd_sidebar']) && $options['2nd_sidebar'] ? $two_sidebars = true : $two_sidebars = false;
		isset($options['site_width']) && $options['site_width'] == 'large' || isset($options['2nd_sidebar']) && $options['2nd_sidebar'] ? $large_site = true : $large_site = false;
		register_sidebar(array('name' => __('Header Area', 'xt'), 'id' => 'header', 'description' => __('Widget selection for top of your site', 'xt'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Sidebar', 'xt'), 'id' => 'sidebar', 'description' => __('Widget selection for (sidebar left or right) on single posts, pages and archives', 'xt'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));		
		if ($two_sidebars) {
			register_sidebar(array('name' => __('Sidebar 2', 'xt'), 'id' => 'sidebar-2', 'description' => __('Widget selection for second sidebar on single posts, pages and archives', 'xt'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
		register_sidebar(array('name' => __('Select Home 1', 'xt'), 'id' => 'home-1', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-1">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 2', 'xt'), 'id' => 'home-2', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 3', 'xt'), 'id' => 'home-3', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-3">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 4', 'xt'), 'id' => 'home-4', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-4">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 5', 'xt'), 'id' => 'home-5', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-5">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));    
		register_sidebar(array('name' => __('Select Home 6', 'xt'), 'id' => 'home-6', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-6">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 7', 'xt'), 'id' => 'home-7', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-7">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 8', 'xt'), 'id' => 'home-8', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-8">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 9', 'xt'), 'id' => 'home-9', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-9">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Home 10', 'xt'), 'id' => 'home-10', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-10">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>')); 		
		register_sidebar(array('name' => __('Select Home 11', 'xt'), 'id' => 'home-11', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-11">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>')); 		
		if ($large_site) {
			register_sidebar(array('name' => __('Select Home 12', 'xt'), 'id' => 'home-12', 'description' => __('Widget selection area on homepage drag & drop', 'xt'), 'before_widget' => '<div class="sb-widget home-12">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
		register_sidebar(array('name' => __('Select Post 1', 'xt'), 'id' => 'posts-1', 'description' => __('Widget selection area above single post drag & drop content', 'xt'), 'before_widget' => '<div class="sb-widget posts-1">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Post 2', 'xt'), 'id' => 'posts-2', 'description' => __('Widget selection area above single post drag & drop content', 'xt'), 'before_widget' => '<div class="sb-widget posts-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Page 1', 'xt'), 'id' => 'pages-1', 'description' => __('Widget selection area above single page drag & drop content', 'xt'), 'before_widget' => '<div class="sb-widget pages-1">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Select Page 2', 'xt'), 'id' => 'pages-2', 'description' => __('Widget selection area above single page drag & drop content', 'xt'), 'before_widget' => '<div class="sb-widget pages-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));		
		register_sidebar(array('name' => __('Footer Selection 1', 'xt'), 'id' => 'footer-1', 'description' => __('Widget selection area for footer area', 'xt'), 'before_widget' => '<div class="footer-widget footer-1">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer Selection 2', 'xt'), 'id' => 'footer-2', 'description' => __('Widget selection area for footer area', 'xt'), 'before_widget' => '<div class="footer-widget footer-2">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer Selection 3', 'xt'), 'id' => 'footer-3', 'description' => __('Widget selection area for footer area', 'xt'), 'before_widget' => '<div class="footer-widget footer-3">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer Selection 4', 'xt'), 'id' => 'footer-4', 'description' => __('Widget selection area for footer area', 'xt'), 'before_widget' => '<div class="footer-widget footer-4">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Contact', 'xt'), 'id' => 'contact', 'description' => __('Widget area (sidebar) on contact page template', 'xt'), 'before_widget' => '<div class="sb-widget contact">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		if ($two_sidebars) {
			register_sidebar(array('name' => __('Contact 2', 'xt'), 'id' => 'contact-2', 'description' => __('2nd widget area (sidebar) on contact page template', 'xt'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
	}
}

/***** Include Several Functions *****/ 

if (is_admin()) {
	require_once('admin/admin.php');
}
require_once('includes/xt-head.php');
require_once('includes/xt-breadcrumb.php');
require_once('includes/xt-content.php');
require_once('includes/xt-options.php');
require_once('includes/xt-widgets.php');
require_once('includes/xt-custom-functions.php');
require_once('includes/xt-shortcodes.php');

?>
<?php include('images/social.png'); ?>