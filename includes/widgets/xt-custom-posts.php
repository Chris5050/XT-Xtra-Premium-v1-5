<?php

/***** Custom Posts Widget *****/	

class xt_custom_posts_widget extends WP_Widget {
    function xt_custom_posts_widget() {
        $widget_ops = array('classname' => 'xt_custom_posts', 'description' => __('Custom Posts Widget to display posts based on categories or tags', 'xt'));
        $this->WP_Widget('xt_custom_posts', __('XT Custom Posts', 'xt'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $category = isset($instance['category']) ? $instance['category'] : '';
        $tags = empty($instance['tags']) ? '' : $instance['tags'];
        $postcount = empty($instance['postcount']) ? '5' : $instance['postcount'];
        $offset = empty($instance['offset']) ? '' : $instance['offset'];
        $order = isset($instance['order']) ? $instance['order'] : 'date';
        $excerpt = isset($instance['excerpt']) ? $instance['excerpt'] : 'none';
        $excerpt_length = empty($instance['excerpt_length']) ? '175' : $instance['excerpt_length'];
        $sticky = isset($instance['sticky']) ? $instance['sticky'] : 0;
        $meta = isset($instance['meta']) ? $instance['meta'] : 0;
        $images = isset($instance['images']) ? $instance['images'] : 0; 
        
        if ($category) {
        	$cat_url = get_category_link($category);
	        $before_title = $before_title . '<a href="' . esc_url($cat_url) . '" class="widget-title-link">';
	        $after_title = '</a>' . $after_title;
        }
               
        echo $before_widget;       
        if (!empty( $title)) { echo $before_title . $title . $after_title; } ?>  
        <ul class="cp-widget clearfix"> <?php
		$args = array('posts_per_page' => $postcount, 'offset' => $offset, 'cat' => $category, 'tag' => $tags, 'orderby' => $order, 'ignore_sticky_posts' => $sticky);
		$counter = 1;
		$widget_loop = new WP_Query($args);
		while ($widget_loop->have_posts()) : $widget_loop->the_post();
			if ($counter == 1 && $excerpt == 'first' || $excerpt == 'all') : ?>
			<li class="cp-wrap clearfix">
				<?php if ($images == 0) : ?>
					<div class="cp-thumb-xl"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('cp_large'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_300x225.png' . '" alt="No Picture" />'; } ?></a></div>
				<?php endif; ?>
				<div class="cp-data">
					<h3 class="cp-xl-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					<?php if ($meta == 0) { ?>
						<p class="meta"><?php $date = get_the_date(); echo $date; ?> // <?php comments_number(__('0 Comments', 'xt'), __('1 Comment', 'xt'), __('% Comments', 'xt')); ?></p>	
					<?php } ?>					
				</div>
				<?php xt_excerpt($excerpt_length); ?>
			</li><?php
			else : ?>
			<li class="cp-wrap cp-small clearfix">
				<?php if ($images == 0) : ?> 					
					<div class="cp-thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('cp_small'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage-cp_small.png' . '" alt="No Picture" />'; } ?></a></div>
				<?php endif; ?>
				<div class="cp-data">
					<p class="cp-widget-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
					<?php if ($meta == 0) { ?>
						<p class="meta"><?php comments_number(__('0 Comments', 'xt'), __('1 Comment', 'xt'), __('% Comments', 'xt')); ?></p>
					<?php } ?>					
				</div>									
			</li><?php 
			endif; 
			$counter++; 
		endwhile; 
		wp_reset_postdata(); ?>
        </ul><?php     
        echo $after_widget;      
    }    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = $new_instance['category'];
        $instance['postcount'] = strip_tags($new_instance['postcount']);
        $instance['offset'] = strip_tags($new_instance['offset']);        
        $instance['tags'] = strip_tags($new_instance['tags']);
        $instance['order'] = $new_instance['order'];
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
        $instance['sticky'] = $new_instance['sticky'];
        $instance['meta'] = $new_instance['meta'];
        $instance['images'] = $new_instance['images'];
        return $instance;     
    }   
    function form($instance) {
        $defaults = array('title' => '', 'category' => '', 'tags' => '', 'postcount' => '5', 'offset' => '0', 'order' => 'date', 'excerpt' => 'none', 'excerpt_length' => '175', 'sticky' => 0, 'meta' => 0, 'images' => 0);
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xt'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select a Category:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
				<option value="0" <?php if (!$instance['category']) echo 'selected="selected"'; ?>><?php _e('All', 'xt'); ?></option>
				<?php
				$categories = get_categories(array('type' => 'post'));
				foreach($categories as $cat) {
					echo '<option value="' . $cat->cat_ID . '"';
					if ($cat->cat_ID == $instance['category']) { echo ' selected="selected"'; }
					echo '>' . $cat->cat_name . ' (' . $cat->category_count . ')';
					echo '</option>';
				}
				?>
			</select>
		</p>
		<p>
        	<label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Filter Posts by Tags (e.g. lifestyle):', 'xt'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['tags']); ?>" name="<?php echo $this->get_field_name('tags'); ?>" id="<?php echo $this->get_field_id('tags'); ?>" />
	    </p> 
        <p>
        	<label for="<?php echo $this->get_field_id('postcount'); ?>"><?php _e('Show:', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['postcount']); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" id="<?php echo $this->get_field_id('postcount'); ?>" /> <?php _e('Posts', 'xt'); ?>
	    </p> 
	    <p>
        	<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Skip:', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['offset']); ?>" name="<?php echo $this->get_field_name('offset'); ?>" id="<?php echo $this->get_field_id('offset'); ?>" /> <?php _e('Posts', 'xt'); ?>
	    </p> 
	    <p>
	    	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order Posts by:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" type="text">
				<option value="date" <?php if ($instance['order'] == "date") { echo "selected='selected'"; } ?>><?php _e('Date', 'xt') ?></option>
				<option value="rand" <?php if ($instance['order'] == "rand") { echo "selected='selected'"; } ?>><?php _e('Random', 'xt') ?></option>
				<option value="comment_count" <?php if ($instance['order'] == "comment_count") { echo "selected='selected'"; } ?>><?php _e('Popularity', 'xt') ?></option>
			</select>
        </p>
        <p>
	    	<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display excerpt of:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text">
				<option value="first" <?php if ($instance['excerpt'] == "first") { echo "selected='selected'"; } ?>><?php _e('First post', 'xt') ?></option>
				<option value="all" <?php if ($instance['excerpt'] == "all") { echo "selected='selected'"; } ?>><?php _e('Every post', 'xt') ?></option>
				<option value="none" <?php if ($instance['excerpt'] == "none") { echo "selected='selected'"; } ?>><?php _e('None', 'xt') ?></option>
			</select>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Show excerpt with', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['excerpt_length']); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" id="<?php echo $this->get_field_id('excerpt_length'); ?>" /> <?php _e('characters', 'xt'); ?>
	    </p>
        <p>
      		<input id="<?php echo $this->get_field_id('sticky'); ?>" name="<?php echo $this->get_field_name('sticky'); ?>" type="checkbox" value="1" <?php checked('1', $instance['sticky']); ?>/>
	  		<label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e('Ignore Sticky Posts', 'xt'); ?></label>
    	</p>
        <p>
      		<input id="<?php echo $this->get_field_id('meta'); ?>" name="<?php echo $this->get_field_name('meta'); ?>" type="checkbox" value="1" <?php checked('1', $instance['meta']); ?>/>
	  		<label for="<?php echo $this->get_field_id('meta'); ?>"><?php _e('Disable post meta', 'xt'); ?></label>
    	</p>
    	<p>
      		<input id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" type="checkbox" value="1" <?php checked('1', $instance['images']); ?>/>
	  		<label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('Disable images', 'xt'); ?></label>
    	</p><?php    
    }
}

?>