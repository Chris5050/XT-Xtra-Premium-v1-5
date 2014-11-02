<?php

add_action('xt_before_post_content', 'xt_breadcrumb');
add_action('xt_before_page_content', 'xt_breadcrumb');

/***** Breadcrumbs *****/

if (!function_exists('xt_breadcrumb')) {
	function xt_breadcrumb() {
		if (!is_home() && !is_front_page()) {
			global $post, $options;	
			if (isset($options['breadcrumbs']) && $options['breadcrumbs']) {	
				$delimiter = ' &raquo; ';
				$before_link = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
				$before_title = '<span itemprop="title">';
				$close_span = '</span>';
				echo '<div class="breadcrumb">' . $before_link . '<a href="' . esc_url(home_url()) . '" itemprop="url">' . $before_title . __('Home', 'xt') . $close_span . '</a>' . $close_span . $delimiter;	
				if (is_single() && get_post_type() == 'post' && !is_attachment()) {
					$category = get_the_category();
					$category_id = $category[0]->cat_ID;
					$parent_id = $category[0]->category_parent;
					$parents = get_category_parents($parent_id, true, $delimiter);
					if ($parent_id != 0) {
						echo $parents;
					}
					echo $before_link . '<a href="' . esc_url(get_category_link($category_id)) . '" itemprop="url">' . $before_title . esc_attr($category[0]->name) . $close_span . '</a>' . $close_span . $delimiter;
					echo get_the_title() . '</div>' . "\n";	
				} elseif (is_attachment()) {
					echo __('Media', 'xt') . $delimiter;
					echo get_the_title() . '</div>' . "\n";	
				} elseif (is_page() && !$post->post_parent) {		
					echo get_the_title() . '</div>' . "\n";
				} elseif (is_page() && $post->post_parent) {
					$parent_id  = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = $before_link . '<a href="' . get_permalink($page->ID) . '" itemprop="url">' . $before_title . get_the_title($page->ID) . $close_span . '</a>' . $close_span;
						$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach ($breadcrumbs as $bc); 
					echo $bc . $delimiter;
					echo get_the_title() . '</div>' . "\n";			
				} elseif (is_category() || is_tax()) {				
					$term = get_queried_object();
					$term_id = $term->term_id;
					if (is_category()) {
						$term_id = get_category($term_id);
						$parents = get_category($term_id->parent);
						if ($term_id->parent != 0) {
							echo (get_category_parents($parents, true, $delimiter));	
						}
					} elseif (is_tax()) {
						$taxonomy = get_taxonomy($term->taxonomy);
						echo $taxonomy->labels->name . $delimiter;					
					}
					echo single_cat_title('', false) . '</div>' . "\n";
				} elseif (is_tag()) {
					echo single_term_title('', false) . '</div>' . "\n";	
				} elseif (is_author()) {
					global $author;
					$user_info = get_userdata($author);				
					echo __('Authors', 'xt') . $delimiter . esc_attr($user_info->display_name) . '</div>' . "\n";							
				} elseif (is_404()) {
					echo __('Page not found (404)', 'xt') . '</div>' . "\n";
				} elseif (is_search()) {
					echo __('Search', 'xt') . $delimiter . get_search_query() . '</div>' . "\n";
				} elseif (is_date()) {
					$arc_year = get_the_time('Y'); 
					$arc_month = get_the_time('F');
					$arc_month_num = get_the_time('m');
					$arc_day = get_the_time('d');
					$arc_day_full = get_the_time('l');
					$url_year = get_year_link($arc_year);
					$url_month = get_month_link($arc_year, $arc_month_num);							
					if (is_day()) {
						echo $before_link . '<a href="' . $url_year . '" title="' . __('Yearly Archives', 'xt') . '" itemprop="url">' . $before_title . $arc_year . $close_span . '</a>' . $close_span . $delimiter;
						echo $before_link . '<a href="' . $url_month . '" title="' . __('Monthly Archives', 'xt') . '" itemprop="url">' . $before_title . $arc_month . $close_span . '</a>' . $close_span . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
						echo '</div>' . "\n";
					} elseif (is_month()) {
						echo $before_link . '<a href="' . $url_year . '" title="' . __('Yearly Archives', 'xt') . '" itemprop="url">' . $before_title . $arc_year . $close_span . '</a>' . $close_span . $delimiter . $arc_month . '</div>' . "\n";
					} elseif (is_year()) {
						echo $arc_year . '</div>' . "\n";
					}
				} elseif (is_single() && get_post_type() != 'post' || is_post_type_archive(get_post_type())) {	
					$post_type_data = get_post_type_object(get_post_type());
					$post_type_name = $post_type_data->labels->name;
					if (is_single() && get_post_type() != 'post') {
						$post_type_slug = $post_type_data->rewrite['slug'];						
						$permalinks = get_option('permalink_structure');						
						if ($permalinks == '') {
							echo $before_link . '<a href="' . esc_url(home_url()) . '?post_type=' . $post_type_slug . get_post_type() .'" itemprop="url">' . $before_title . $post_type_name . $close_span . '</a>' . $close_span . $delimiter;	
						} else {
							echo $before_link . '<a href="' . esc_url(home_url()) . '/' . $post_type_slug . '/" itemprop="url">' . $before_title . $post_type_name . $close_span . '</a>' . $close_span . $delimiter;	
						}
						echo get_the_title() . '</div>' . "\n";
					} elseif (is_post_type_archive(get_post_type())) {
						echo $post_type_name . '</div>' . "\n";
					} 
				}
			}
		}
	}
}

?>