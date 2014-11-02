<?php

add_action('xt_html_class', 'xt_html');
add_action('xt_html_tag', 'xt_fb_og_prefix');
add_action('wp_head', 'xt_google_webfonts', 1);
add_action('wp_head', 'xt_css', 1);
add_action('wp_head', 'xt_seo_meta', 1);
add_action('wp_head', 'xt_google_authorship', 1);
add_action('wp_head', 'xt_fb_og', 1);
add_action('wp_head', 'xt_head_misc', 1);
add_action('xt_body_id', 'xt_responsive');
add_action('xt_container_class', 'xt_responsive');

/***** Add CSS classes to HTML tag *****/

if (!function_exists('xt_html')) {
	function xt_html() {
		global $options;
		isset($options['site_width']) && $options['site_width'] == 'large' || isset($options['2nd_sidebar']) && $options['2nd_sidebar'] ? $site_width = ' xt-large' : $site_width = ' xt-normal';
		isset($options['2nd_sidebar']) && $options['2nd_sidebar'] ? $sidebars = ' xt-two-sb' : $sidebars = ' xt-one-sb';
		isset($options['wt_layout']) ? $widget_titles = $options['wt_layout'] : $widget_titles = 'layout1';
		isset($options['full_bg']) && $options['full_bg'] == 1 ? $fullbg = ' fullbg' : $fullbg = ''; 		
		echo  $site_width . $sidebars . ' wt-' . $widget_titles . $fullbg;
	}
}

/***** Load Google Webfonts *****/

if (!function_exists('xt_google_webfonts')) {
	function xt_google_webfonts() {
		global $options;	
		$font_body = isset($options['font_body']) ? $options['font_body'] : 'open_sans';
		$font_heading = isset($options['font_heading']) ? $options['font_heading'] : 'open_sans';			
		$font_location = array('armata' => 'Armata', 'arvo' => 'Arvo', 'bree_serif' => 'Bree+Serif', 'droid_sans' => 'Droid+Sans', 'droid_sans_mono' => 'Droid+Sans+Mono', 'droid_serif' => 'Droid+Serif', 'lato' => 'Lato', 'lora' => 'Lora', 'merriweather' => 'Merriweather', 'merriweather_sans' => 'Merriweather+Sans', 'monda' => 'Monda', 'nobile' => 'Nobile', 'noto_sans' => 'Noto+Sans', 'noto_serif' => 'Noto+Serif', 'open_sans' => 'Open+Sans', 'oswald' => 'Oswald', 'oxygen' => 'Oxygen', 'pt_sans' => 'PT+Sans', 'pt_serif' => 'PT+Serif', 'raleway' => 'Raleway', 'roboto_condensed' => 'Roboto+Condensed', 'ubuntu' => 'Ubuntu', 'yanone_kaffeesatz' => 'Yanone+Kaffeesatz');
		echo '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=' . $font_location[$font_body]; if ($font_location[$font_heading] != $font_location[$font_body]) { echo '|' . $font_location[$font_heading]; } echo '">' . "\n";	
	}
}

/***** Add Stylesheets *****/

if (!function_exists('xt_css')) {
	function xt_css() {
		global $options;
		echo '<link rel="stylesheet" href="' . get_bloginfo('stylesheet_url') . '" media="screen">' . "\n";
	}
}

/***** Add SEO meta tags *****/

if (!function_exists('xt_seo_meta')) {
	function xt_seo_meta() {
		global $post, $options;
		if (isset($options['activate_seo']) && $options['activate_seo']) {		
			if (is_page() || is_single()) {	
				$tags = get_the_tags();
				$description = get_post_meta($post->ID, "xt-meta-desc", true);
				$keywords = get_post_meta($post->ID, "xt-meta-keywords", true);
				$robots = get_post_meta($post->ID, "xt-robots", true);
				$sep = '';		
				if ($description) {
					echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
				}
				if (isset($options['meta_keywords']) && $options['meta_keywords'] && !$keywords) {
					if ($tags) {
						echo '<meta name="keywords" content="'; foreach($tags as $tag) { echo $sep . $tag->name; $sep = ', '; } echo '" />' . "\n";
					} 
				} 	
				elseif ($keywords) { 
					echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n"; 
				}
				if ($robots) {
					echo '<meta name="robots" content="' . esc_attr($robots) . '" />' . "\n";
				}	
			}
			if (is_attachment()) {	
				if (isset($options['noindex_atts']) && $options['noindex_atts']) {
					echo '<meta name="robots" content="noindex,follow" />' . "\n";	
				}
			}
			if (is_archive()) {
				if (isset($options['noindex_cats']) && $options['noindex_cats'] && is_category()) {
					echo '<meta name="robots" content="noindex,follow" />' . "\n";	
				}
				if (isset($options['noindex_tags']) && $options['noindex_tags'] && is_tag()) {
					echo '<meta name="robots" content="noindex,follow" />' . "\n";	
				}
				if (isset($options['noindex_date']) && $options['noindex_date'] && is_date()) {
					echo '<meta name="robots" content="noindex,follow" />' . "\n";	
				}			
			}				
		}
	}
}

/***** Add Google Authorship *****/

if (!function_exists('xt_google_authorship')) {
	function xt_google_authorship() {
		global $post, $options;
		if (isset($options['activate_google_author']) && $options['activate_google_author']) {
        	$xt_google_pub = isset($options['google_publisher']) ? $options['google_publisher'] : '';       
        	if (!empty($xt_google_pub) && !is_singular() || !empty($xt_google_pub) && is_home() || !empty($xt_google_pub) && is_front_page()) {
            	echo '<link rel="publisher" href="' . esc_url($xt_google_pub) . '" />' . "\n";
            } else {
            	$xt_google_author = get_the_author_meta('googleplus', $post->post_author);
            	if (empty($xt_google_author) && !empty($xt_google_pub)) {
            		echo '<link rel="publisher" href="' . esc_url($xt_google_pub) . '" />' . "\n";
            	} elseif (!empty($xt_google_author)) {
            		echo '<link rel="author" href="' . esc_url($xt_google_author) .  '" />' . "\n";
            	}
            }
        }
	}
}

/***** Add Facebook Open Graph *****/

if (!function_exists('xt_fb_og')) {
	function xt_fb_og() {
		global $post, $options;
		if (isset($options['activate_fb_og']) && $options['activate_fb_og']) {	
			global $locale;
			$og_url = (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			echo '<meta property="og:locale" content="' . $locale . '" />' . "\n";
			if (is_singular()) {
				if (get_post_meta($post->ID, "xt-seo-title", true)) {
					$og_title = get_post_meta($post->ID, "xt-seo-title", true);	
				} else {
					$og_title = get_the_title();
				}
				$description = get_post_meta($post->ID, "xt-meta-desc", true);
				echo '<meta property="og:title" content="' . esc_attr($og_title) . '" />' . "\n";
				echo '<meta property="og:type" content="article" />' . "\n";
				if ($description) {
					echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";	
				}
				if (has_post_thumbnail()) {
					$og_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'spotlight');
					echo '<meta property="og:image" content="' . esc_url($og_image[0]) . '" />' . "\n";
				}
			}
			else {
				echo '<meta property="og:title" content="' . wp_title('|', false, 'right') . '" />' . "\n";
				echo '<meta property="og:type" content="website" />' . "\n";	
			}
			echo '<meta property="og:url" content="' . esc_url($og_url) . '" />' . "\n";
			echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />' . "\n";
		}
		if (isset($options['verify_gwt']) && !empty($options['verify_gwt'])) {	
			echo '<meta name="google-site-verification" content="' . esc_attr($options['verify_gwt']) . '" />' . "\n";
		}
	}
}

/***** Add Facebook Open Graph Prefix *****/

if (!function_exists('xt_fb_og_prefix')) {
	function xt_fb_og_prefix() {
		global $options;
		if (isset($options['activate_fb_og']) && $options['activate_fb_og']) {
			echo ' prefix="og: http://ogp.me/ns#"';
		}
	}
}

/***** Add Favicon and other stuff *****/

if (!function_exists('xt_head_misc')) {
	function xt_head_misc() {
		global $options;
		if (isset($options['xt_favicon']) && $options['xt_favicon']) {
			echo '<link rel="shortcut icon" href="' . esc_url($options['xt_favicon']) . '">' . "\n";
		}
		if (isset($options['no_responsive']) ? !$options['no_responsive'] : true) {
			echo '<!--[if lt IE 9]>' . "\n";
			echo '<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>' . "\n";
			echo '<![endif]-->' . "\n";
			echo '<meta name="viewport" content="width=device-width; initial-scale=1.0">' . "\n";
		}
		echo '<link rel="pingback" href="' . get_bloginfo('pingback_url') . '"/>' . "\n";
	}
}

/***** Enable / Disable Responsive Layout *****/

if (!function_exists('xt_responsive')) {
	function xt_responsive() {
		global $options;
		isset($options['no_responsive']) && $options['no_responsive'] ? $xt_mobile = 'no-mobile' : $xt_mobile = 'xt-mobile';
		echo $xt_mobile;
	}
}

/***** Clean up head section *****/

if (isset($options['clean_head']) && $options['clean_head'] == 1) {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');		
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);	
}

?>