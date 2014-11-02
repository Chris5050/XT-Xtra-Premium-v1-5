<?php

add_action('xt_after_header', 'xt_newsselector');
add_action('xt_post_header', 'xt_subheading');
add_action('xt_post_header', 'xt_post_meta');
add_action('xt_post_content', 'xt_teaser');
add_action('xt_post_content', 'xt_featured_image');
add_action('xt_post_content', 'xt_share_buttons');
add_action('xt_post_content', 'xt_the_content');
add_action('xt_after_post_content', 'xt_share_buttons');
add_action('xt_after_post_content', 'xt_author_box');
add_action('xt_after_post_content', 'xt_postnav');
add_action('xt_after_post_content', 'xt_related');
add_action('xt_loop_content', 'xt_loop');

/***** News selector *****/

if (!function_exists('xt_newsselector')) {
	function xt_newsselector() {
	global $options;
	if (isset($options['show_selector']) ? $options['show_selector'] : false) : ?>
	<section class="news-selector clearfix">
		<div class="selector-title"><?php if ($options['selector_title']) : echo esc_attr($options['selector_title']); else : _e('News Selector', 'xt'); endif; ?></div>
		<div class="selector-content">
			<ul id="selector">
			<?php
			$selector_posts = empty($options['selector_posts']) ? '5' : $options['selector_posts'];
			$selector_cats = empty($options['selector_cats']) ? '' : $options['selector_cats'];
			$selector_tags = empty($options['selector_tags']) ? '' : $options['selector_tags'];
			$selector_offset = empty($options['selector_offset']) ? '' : $options['selector_offset'];
			$args = array('posts_per_page' => $selector_posts, 'cat' => $selector_cats, 'tag' => $selector_tags, 'offset' => $selector_offset);
			$selector_loop = new WP_Query($args);
			while ($selector_loop->have_posts()) : $selector_loop->the_post(); ?>
    			<li><a href="<?php the_permalink(); ?>"><?php echo '<span class="meta">' . $date = get_the_date(); $date . _e(' in ', 'xt'); $category = get_the_category(); echo $category[0]->cat_name . ' // </span>' ?><?php the_title() ?></a></li>
			<?php endwhile;
			wp_reset_postdata(); ?>
			</ul>
		</div>
	</section>
	<?php endif;
	}
}

/***** Subheading on Posts *****/

if (!function_exists('xt_subheading')) {
	function xt_subheading() {
		global $post;
		if (get_post_meta($post->ID, "xt-subheading", true)) {
			echo '<h2 class="subheading">' . esc_attr(get_post_meta($post->ID, "xt-subheading", true)) . '</h2>' . "\n";
		}
	}
}

/***** Post Meta *****/

if (!function_exists('xt_post_meta')) {
	function xt_post_meta() {
		global $options;
		if (isset($options['post_meta']) ? !$options['post_meta'] : true) {		
			echo '<p class="meta post-meta">' . __('Posted on ', 'xt') . '<span class="updated">' . get_the_date() . '</span>' . __(' by ', 'xt');
			echo '<span class="vcard author"><span class="fn">';
			the_author_posts_link();
			echo '</span></span>' . __(' in ', 'xt');
			the_category(', ');
			echo ' // ';
			comments_number(__('0 Comments', 'xt'), __('1 Comment', 'xt'), __('% Comments', 'xt'));
			echo '</p>' . "\n";
		}	
	}
}

/***** Teasertext on Posts *****/

if (!function_exists('xt_teaser')) {
	function xt_teaser() {
		global $post, $more, $options;
		if (isset($options['teaser_text']) ? !$options['teaser_text'] && !is_attachment() : !is_attachment()) {
			if (has_excerpt()) {
				esc_attr(the_excerpt());
			} elseif (strstr($post->post_content, '<!--more-->')) {
				$more = 0;
				$excerpt = get_the_content('');
				$more = 1;
				echo '<p>' . do_shortcode($excerpt) . '</p>';	
			}
		}
	}
}

/***** Featured Image on Posts *****/

if (!function_exists('xt_featured_image')) {
	function xt_featured_image() {
		global $post, $options;		
		if (isset($options['featured_image']) ? !$options['featured_image'] && has_post_thumbnail() && !is_attachment() : has_post_thumbnail() && !is_attachment()) {
			if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['2nd_sidebar']) && !$options['2nd_sidebar'] || isset($options['site_width']) && $options['site_width'] == 'large' && !isset($options['2nd_sidebar'])) {
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider');
			} else {
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'content');	
			}	
			$full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			$caption_text = get_post(get_post_thumbnail_id())->post_excerpt;
			if (isset($options['no_prettyphoto']) ? !$options['no_prettyphoto'] : true) {
				$attachment_url = '<a href="' . $full[0] . '" rel="prettyPhoto">';
			} else {
				$attachment_page = get_attachment_link(get_post_thumbnail_id());	
				$attachment_url = '<a href="' . $attachment_page . '">';
			}
			echo "\n" . '<div class="post-thumbnail">' . "\n";				
				echo $attachment_url . '<img src="' . $thumbnail[0] . '" alt="' . get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) . '" title="' . get_post(get_post_thumbnail_id())->post_title . '" /></a>' . "\n";		
				if ($caption_text) {
					echo '<span class="wp-caption-text">' . $caption_text . '</span>' . "\n";				
				}
			echo '</div>' . "\n";
		}
	}
}

/***** Content on Posts *****/

if (!function_exists('xt_the_content')) {
	function xt_the_content() {
		global $post, $more, $options;
		$ad = 1;
		if (isset($options['teaser_text']) ? !$options['teaser_text'] : true) {		
			if (strstr($post->post_content, '<!--more-->') && !has_excerpt()) {
				$more = 1;
				$ad = 2;
				$content = get_the_content('', true);	
			} else {
				$content = get_the_content(); 
			}
		} else {
			$content = get_the_content(); 	
		}		
		$content = apply_filters('the_content', $content);
		$paragraphs = explode("<p", $content);
		$counter = 0;
		foreach($paragraphs as $content) {	
			if ($counter == 0) {
				echo $content;
			}
			if ($counter > 0) {
				echo '<p' . $content;
			}
			if ($counter == $ad) {		   
           		if (!get_post_meta($post->ID, 'xt-no-ad', true)) {		
			   		if (get_post_meta($post->ID, 'xt-alt-ad', true)) {
				   		echo '<div class="content-ad">' . do_shortcode(get_post_meta($post->ID, 'xt-alt-ad', true)) . '</div>' . "\n";
				   	} else {
						$adcode = !empty($options['content_ad']) ? '<div class="content-ad">' . do_shortcode($options['content_ad']) . '</div>' . "\n" : '';
						echo $adcode;
					}
				}
			}								  	
		$counter++;
		}	
	}
}

/***** Share Buttons on Posts *****/

if (!function_exists('xt_share_buttons')) {
	function xt_share_buttons() { 
		global $options;
		if (isset($options['share_buttons']) && $options['share_buttons']) { ?>
			<section class="share-buttons-container clearfix">
	    		<div class="share-button"><div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="verdana"></div></div>
				<div class="share-button"><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></div>
				<div class="share-button"><div class="g-plusone" data-size="medium"></div></div>           	
			</section>
		<?php 
		}
	}	
}

/***** Author box *****/

if (!function_exists('xt_author_box')) {
	function xt_author_box() {
		global $options;
		if (isset($options['author_box']) ? !$options['author_box'] && get_the_author_meta('description') : get_the_author_meta('description')) {
			$author = get_the_author();
			$website = get_the_author_meta('user_url');
			$facebook = get_the_author_meta('facebook');
			$twitter = get_the_author_meta('twitter');
			$googleplus = get_the_author_meta('googleplus');
			$youtube = get_the_author_meta('youtube');
			echo '<section class="author-box clearfix">' . "\n";
			echo '<div class="author-box-avatar">' . get_avatar(get_the_author_meta('ID'), 115) . '</div>' . "\n";
			echo '<div class="author-box-desc">' . "\n";
			echo '<h5 class="author-box-name">' . __('About ', 'xt') . esc_attr($author) . '</h5>' . "\n";
			echo '<p>';
			echo the_author_meta('user_description') . ' ';
			if (isset($options['author_contact']) ? !$options['author_contact'] : true) {
				if ($website || $facebook || $twitter || $googleplus || $youtube) {
					echo __('Contact: ', 'xt');
					if ($website) {
						echo '<a href="' . esc_url($website) . '" title="' . __('Visit the website of ', 'xt') . esc_attr($author) . '" target="_blank">' . __('Website', 'xt') . '</a> | ';
					}
					if ($facebook) {
						echo '<a href="' . esc_url($facebook) . '" title="' . __('Follow ', 'xt') . esc_attr($author) . __(' on Facebook', 'xt') . '" target="_blank">' . __('Facebook', 'xt') . '</a> | ';
					}
					if ($twitter) {
						echo '<a href="' . esc_url($twitter) . '" title="' . __('Follow ', 'xt') . esc_attr($author) . __(' on Twitter', 'xt') . '" target="_blank">' . __('Twitter', 'xt') . '</a> | ';
					}
					if ($googleplus) {
						echo '<a href="' . esc_url($googleplus) . '" title="' . __('Follow ', 'xt') . esc_attr($author) . __(' on Google+', 'xt') . '" target="_blank">' . __('Google+', 'xt') . '</a> | ';
					}
					if ($youtube) {
						echo '<a href="' . esc_url($youtube) . '" title="' . __('Follow ', 'xt') . esc_attr($author) . __(' on YouTube', 'xt') . '" target="_blank">' . __('YouTube', 'xt') . '</a> | ';
					}
				}
			}
			echo '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . __('More articles written by ', 'xt') . esc_attr($author) . '">' . __('More Posts', 'xt') . '</a>';	
			echo '</p>' . "\n";
			echo '</div>' . "\n";
			echo '</section>' . "\n";		
		}	
	}
}

/***** Post / Image Navigation *****/

if (!function_exists('xt_postnav')) {
	function xt_postnav() {
		global $post, $options;		
		if (isset($options['post_nav']) && $options['post_nav']) {	
			$parent_post = get_post($post->post_parent);
			$attachment = is_attachment();
			$previous = ($attachment) ? $parent_post : get_adjacent_post(false, '', true);
			$next = get_adjacent_post(false, '', false);
	
			if (!$next && !$previous)
			return;	
		
			if ($attachment) {
				$attachments = get_children(array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $parent_post->ID));	
				$count = count($attachments);
			}
			if ($attachment && $count == 1) {
				$permalink = get_permalink($parent_post);
				echo '<nav class="section-title clearfix" role="navigation">' . "\n";
				echo '<div class="post-nav left">' . "\n";
				echo '<a href="' . $permalink . '">' . __('&larr; Back to article', 'xt') . '</a>';	
				echo '</div>' . "\n";
				echo '</nav>' . "\n";
			} elseif (!$attachment || $attachment && $count > 1) {			
				echo '<nav class="section-title clearfix" role="navigation">' . "\n";
				echo '<div class="post-nav left">' . "\n";
				if ($attachment) {					
					previous_image_link('%link', __('&larr; Previous image', 'xt'));	
				} else {
					previous_post_link('%link', __('&larr; Previous article', 'xt'));	
				}
				echo '</div>' . "\n";
				echo '<div class="post-nav right">' . "\n";
				if ($attachment) {
					next_image_link('%link', __('Next image &rarr;', 'xt'));
				} else {
					next_post_link('%link', __('Next article &rarr;', 'xt'));
				}
				echo '</div>' . "\n";
				echo '</nav>' . "\n";		
			}	
		}		
	}
}

/***** Related Posts *****/

if (!function_exists('xt_related')) {
	function xt_related() {	
		global $post, $options;
		if (isset($options['related_posts']) ? $options['related_posts'] : false) {
			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
				$layout = isset($options['related_layout']) ? $options['related_layout'] : 'layout1'; 
				$tag_ids = array();  
				foreach($tags as $tag) $tag_ids[] = $tag->term_id;  
				$args = array('tag__in' => $tag_ids, 'post__not_in' => array($post->ID), 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'orderby' => 'rand');
				$related = new wp_query($args);   
				if ($related->have_posts()) {
					echo '<section class="related-posts related-' . $layout . '">' . "\n";
					echo '<h3 class="section-title">' . __('Related Articles', 'xt') . '</h3>' . "\n";		
					echo '<ul>' . "\n";
					while ($related->have_posts()) : $related->the_post(); 
						$permalink = get_permalink($post->ID); 
						echo '<li class="related-wrap clearfix">' . "\n";	 
						echo '<div class="related-thumb">' . "\n";  
						echo '<a href="' . $permalink . '" title="' . get_the_title() . '">';
						if (has_post_thumbnail()) {
							the_post_thumbnail('cp_small');	
						} else {
							echo '<img src="' . get_template_directory_uri() . '/images/noimage-cp_small.png' . '" alt="No Picture" />';
						}
						echo '</a>' . "\n";  
						echo '</div>' . "\n";
						echo '<div class="related-data">' . "\n";
						echo '<a href="' . $permalink . '"><h4 class="related-title">' . get_the_title() . '</h4></a>' . "\n";
						echo '<span class="related-subheading">' . esc_attr(get_post_meta($post->ID, "xt-subheading", true)) . '</span>' . "\n";	
						echo '</div>' . "\n";
						echo '</li>' . "\n";	
					endwhile;
					echo '</ul>' . "\n";
					echo '</section>' . "\n"; 
					wp_reset_postdata();
				}
			}
		}
	}
}

/***** Loop Output *****/

if (!function_exists('xt_loop')) {
	function xt_loop() {
		global $options;
		$counter = 0;
		$layout = isset($options['loop_layout']) ? $options['loop_layout'] : 'layout1';
		$adcode = empty($options['loop_ad']) ? '' : '<div class="loop-ad loop-ad-' . $layout . '">' . do_shortcode($options['loop_ad']) . '</div>' . "\n";
		$adcount = empty($options['loop_ad_no']) ? '3' : $options['loop_ad_no'];
		if (have_posts()) {
			while (have_posts()) : the_post();
				get_template_part('/templates/loop-' . $layout, get_post_format());
				if ($counter % $adcount == 0) {
					echo $adcode;
				}
				$counter++;
			endwhile;
			xt_pagination();
		} else { 
			get_template_part('content', 'none');
		}
	}
}

/***** Loop Output Meta Data *****/

if (!function_exists('xt_loop_meta')) {
	function xt_loop_meta() {
		global $options;
		if (isset($options['post_meta']) ? !$options['post_meta'] : true) {
			echo '<p class="meta">' . get_the_date() . ' // ';
			comments_number(__('0 Comments', 'xt'), __('1 Comment', 'xt'), __('% Comments', 'xt'));
			echo '</p>' . "\n";		
		}
	}
}

?>