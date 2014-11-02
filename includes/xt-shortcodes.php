<?php

/***** Raw Shortcode - http://www.wprecipes.com/disable-wordpress-automatic-formatting-on-posts-using-a-shortcode *****/

function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);

/***** Ad area *****/

function ad($atts, $content = null) {
	$ad_area  = '';
	$ad_area .= '<div class="ad-label">' . __('Advertisement', 'xt') . '</div>';
	$ad_area .= '<div class="ad-area">' . $content . '</div>';
	return $ad_area;
}
add_shortcode('ad', 'ad');

/***** Heading *****/

function heading($atts, $content = null) {
	return '<h3 class="heading">' . do_shortcode($content) . '</h3>';
}
add_shortcode('heading', 'heading');

/***** Columns *****/

function row($atts, $content = null) {
	return '<div class="row clearfix">' . do_shortcode($content) . '</div>';
}
add_shortcode('row', 'row');

function half($atts, $content = null) {
	return '<div class="col-1-2">' . do_shortcode($content) . '</div>';
}
add_shortcode('half', 'half');

function two_third($atts, $content = null) {
	return '<div class="col-2-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'two_third');

function third($atts, $content = null) {
	return '<div class="col-1-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('third', 'third');

function fourth($atts, $content = null) {
	return '<div class="col-1-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('fourth', 'fourth');

function three_fourth($atts, $content = null) {
   	return '<div class="col-3-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'three_fourth');

function fifth($atts, $content = null) {
	return '<div class="col-1-5">' . do_shortcode($content) . '</div>';
}
add_shortcode('fifth', 'fifth');

/***** Dropcap *****/

function dropcap($atts, $content = null) {
	return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'dropcap');

/***** Highlight *****/

function highlight($atts, $content = null) {
	return '<span class="highlight" style="background: ' . $atts['color'] . ';">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'highlight');

/***** Quotes *****/

function quote($atts, $content = null) {
	return '<blockquote>' . do_shortcode($content) . '</blockquote>';
}
add_shortcode('quote', 'quote');

/***** Boxes *****/

function box($atts, $content = null) {
	extract(shortcode_atts(array('type' => '', 'toggle' => '', 'height' => ''), $atts));
	if ($toggle == 1) {
		$toggle = '<span class="hide-box">x</span>';
	}
	$height = isset($atts['height']) ? ' style="min-height: ' . esc_attr($height) . '"' : '';
	return '<div class="box ' . esc_attr($type) . '"' . $height . '>' . do_shortcode($content) . $toggle . '</div>';
}
add_shortcode('box', 'box');

/***** Video *****/

function flexvid($atts, $content = null) {
	return '<div class="flex-vid">' . do_shortcode($content) . '</div>';
}
add_shortcode('flexvid', 'flexvid');

/***** Slider *****/

function slider($atts, $content = null) {
	extract(shortcode_atts(array('type' => 'images'), $atts));
	return '<div id="' . esc_attr($type) . '" class="flexslider clearfix"><ul class="slides">' . do_shortcode($content) . '</ul></div>';
}
add_shortcode('slider', 'slider');

/***** Slider Item *****/

function slide($atts, $content = null) {
	extract(shortcode_atts(array('author' => '', 'type' => 'image'), $atts));
	$author = isset($atts['author']) ? '<span class="testimonial-author"> - ' . esc_attr($author) . '</span>' : '';
	return '<li><div class="' . esc_attr($type) . '">' . do_shortcode($content) . wp_kses_post($author) . '</div></li>';
}
add_shortcode('slide', 'slide');

/***** Testimonial *****/

function testimonial($atts, $content = null) {
	extract(shortcode_atts(array('author' => ''), $atts));
	$author = isset($atts['author']) ? '<span class="testimonial-author"> - ' . esc_attr($author) . '</span>' : '';
	return '<div class="testimonial">' . do_shortcode($content) . wp_kses_post($author) . '</div>';
}
add_shortcode('testimonial', 'testimonial');

?>