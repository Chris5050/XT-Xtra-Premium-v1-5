<?php

/***** Custom Dashboard Widget *****/ 

function xt_info_widget() {
	echo '<div class="admin-theme-thumb"><img src="' . get_template_directory_uri() . '/images/xt_xtra_Thumb.png" /></div><p>Thanks very much for purchasing the <strong>XT-Xtra WP Theme - Premium WordPress Themes</strong>! Should you require help with the theme setup or installation, please refer to the <a href="http://www.xtthemes.com/documentation/" target="_blank">Installation Documents</a> Section. If you cannot find the answer to your question in the Installation Documents, please contact us using the contact us form from <a href="http://www.xtthemes.com/faq/" target="_blank">send us a support ticket</a> at the helpdesk. We usually answer within 24 hours!</p>';
}

function xt_dashboard_widgets() {
	global $wp_meta_boxes;
	add_meta_box('xt_info_widget', 'Theme Support', 'xt_info_widget', 'dashboard', 'normal', 'high');
}
add_action('wp_dashboard_setup', 'xt_dashboard_widgets');

/***** Custom Meta Boxes *****/

add_action('add_meta_boxes', 'xt_add_meta_boxes');
add_action('save_post', 'xt_save_meta_boxes', 10, 2 );

if (!function_exists('xt_add_meta_boxes')) {
	function xt_add_meta_boxes() {
		global $options;
		add_meta_box('xt_post_details', __('Post options', 'xt'), 'xt_post_meta', 'post', 'normal', 'high');
		if (isset($options['activate_seo']) && $options['activate_seo'] == 1) {
			$screens = array('post', 'page');
			foreach ($screens as $screen) {
				add_meta_box('xt_seo_options', __('SEO options', 'xt'), 'xt_seo_meta', $screen, 'normal', 'high');
			}
		}
	}
}

if (!function_exists('xt_post_meta')) {
	function xt_post_meta() {
		global $post;
		wp_nonce_field('xt_meta_box_nonce', 'meta_box_nonce'); 
		echo '<p>';
		echo '<label for="xt-subheading">' . __("Subheading (will be displayed below post title)", 'xt') . '</label>';
		echo '<br />';
		echo '<input class="widefat" type="text" name="xt-subheading" id="xt-subheading" placeholder="Enter subheading" value="' . esc_attr(get_post_meta($post->ID, 'xt-subheading', true)) . '" size="30" />';
		echo '</p>';
		echo '<p>';
		echo '<label for="xt-alt-ad">' . __("Alternative ad code (this will overwrite the global content ad code)", 'xt') . '</label>';
		echo '<br />';
		echo '<textarea name="xt-alt-ad" id="xt-alt-ad" cols="60" rows="3" placeholder="Enter alternative ad code for this post">' . get_post_meta($post->ID, 'xt-alt-ad', true) . '</textarea>'; 
		echo '<br />';	
		echo '</p>';
		echo '<p>';
		echo '<input type="checkbox" id="xt-no-ad" name="xt-no-ad"'; echo checked(get_post_meta($post->ID, 'xt-no-ad', true), 'on'); echo '/>';
		echo '<label for="xt-no-ad">' . __(' Disable content ad for this post', 'xt') . '</label>';
		echo '</p>';
	}
}

if (!function_exists('xt_seo_meta')) {
	function xt_seo_meta() {
		global $post;
		wp_nonce_field('xt_meta_box_nonce', 'meta_box_nonce'); 
		echo '<p>';
		echo '<label for="xt-seo-title">' . __("SEO title (optimize title tag for search engines - max. 70 characters)", 'xt') . '</label>';
		echo '<br />';
		echo '<input class="widefat" type="text" name="xt-seo-title" id="xt-seo-title" placeholder="Enter seo optimized title" value="' . esc_attr(get_post_meta($post->ID, 'xt-seo-title', true)) . '" size="30" />';
		echo '<br />';	
		echo '<span class="char-count">' . __('You have ', 'xt') . '<span id="counter-1"></span>'; echo __(' characters left', 'xt') . '</span>';
		echo '</p>';
		echo '<p>';
		echo '<label for="xt-meta-desc">' . __("Meta description (max. 160 characters recommended)", 'xt') . '</label>';
		echo '<br />';
		echo '<textarea name="xt-meta-desc" id="xt-meta-desc" cols="60" rows="3" placeholder="Enter text">' . esc_attr(get_post_meta($post->ID, 'xt-meta-desc', true)) . '</textarea>'; 
		echo '<br />';	
		echo '<span class="char-count">' . __('You have ', 'xt') . '<span id="counter-2"></span>'; echo __(' characters left', 'xt') . '</span>';
		echo '</p>';
		echo '<p>';
		echo '<label for="xt-meta-keywords">' . __("Meta keywords (only use this to set keywords manually or to overwrite the post tags)", 'xt') . '</label>';
		echo '<br />';
		echo '<input class="widefat" type="text" name="xt-meta-keywords" id="xt-meta-keywords" placeholder="Enter keywords, separated by commas" value="' . esc_attr(get_post_meta($post->ID, 'xt-meta-keywords', true)) . '" size="30" />';
		echo '</p>';
		echo '<p>';
		echo '<label for="xt-robots">' . __("Modify robots meta tags for this post/page (e.g. noindex, nofollow or noodp)", 'xt') . '</label>';
		echo '<br />';
		echo '<input class="widefat" type="text" name="xt-robots" id="xt-robots" placeholder="Enter robots meta tags, separated by commas" value="' . esc_attr(get_post_meta($post->ID, 'xt-robots', true)) . '" size="30" />';
		echo '</p>';
	}
}

if (!function_exists('xt_save_meta_boxes')) {
	function xt_save_meta_boxes($post_id, $post) {
		if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'xt_meta_box_nonce')) {
			return $post->ID;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        	return $post->ID;
		}
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post->ID;
			}
		} 
		elseif (!current_user_can('edit_post', $post_id)) {
			return $post->ID;
		}
		if ('post' == $_POST['post_type']) {
			$meta_data['xt-subheading'] = esc_attr($_POST['xt-subheading']);
			$meta_data['xt-alt-ad'] = $_POST['xt-alt-ad'];	
			$meta_data['xt-no-ad'] = isset($_POST['xt-no-ad']) ? esc_attr($_POST['xt-no-ad']) : '';		
		}
		$meta_data['xt-seo-title'] = isset($_POST['xt-seo-title']) ? esc_attr($_POST['xt-seo-title']) : '';
		$meta_data['xt-meta-desc'] = isset($_POST['xt-meta-desc']) ? esc_attr($_POST['xt-meta-desc']) : '';
		$meta_data['xt-meta-keywords'] = isset($_POST['xt-meta-keywords']) ? esc_attr($_POST['xt-meta-keywords']) : '';
		$meta_data['xt-robots'] = isset($_POST['xt-robots']) ? esc_attr($_POST['xt-robots']) : '';	
		foreach ($meta_data as $key => $value) {
			if ($post->post_type == 'revision') return;
			$value = implode(',', (array)$value);
			if (get_post_meta($post->ID, $key, FALSE)) {
				update_post_meta($post->ID, $key, $value);
			} else {
				add_post_meta($post->ID, $key, $value);
			}
			if (!$value) delete_post_meta($post->ID, $key);
		}
	}
}

/***** Additional fields user profile *****/

if (!function_exists('xt_user_profile')) {
    function xt_user_profile($xt_usercontact) {
        $array_xt_usercontact = array('facebook' => 'Facebook', 'twitter' => 'Twitter', 'googleplus' => 'Google+', 'youtube' => 'YouTube');
        $array_xt_usercontact = array_merge($xt_usercontact, $array_xt_usercontact);
        return $array_xt_usercontact;
    }
    add_filter('user_contactmethods', 'xt_user_profile');
}

?>