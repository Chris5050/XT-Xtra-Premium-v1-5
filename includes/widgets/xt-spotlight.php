<?php

/***** Spotlight Widget (Homepage) *****/	

class xt_spotlight_hp_widget extends WP_Widget {
    function xt_spotlight_hp_widget() {
        $widget_ops = array('classname' => 'xt_spotlight_hp', 'description' => __('Spotlight / Featured widget for use on homepage templates', 'xt'));
        $this->WP_Widget('xt_spotlight_hp', __('XT Spotlight Widget (Homepage)', 'xt'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('In the spotlight', 'xt') : $instance['title'], $instance, $this->id_base);
        $category = isset($instance['category']) ? $instance['category'] : '';
        $tags = empty($instance['tags']) ? '' : $instance['tags'];
        $offset = empty($instance['offset']) ? '' : $instance['offset'];
        $order = isset($instance['order']) ? $instance['order'] : 'date';
        $width = isset($instance['width']) ? $instance['width'] : 'normal_sl';
        $excerpt_length = empty($instance['excerpt_length']) ? '175' : $instance['excerpt_length'];
        $excerpt = isset($instance['excerpt']) ? $instance['excerpt'] : 0;
        $meta = isset($instance['meta']) ? $instance['meta'] : 0;  
              
        echo $before_widget; ?>
		<article class="spotlight"><?php
		$args = array('posts_per_page' => 1, 'cat' => $category, 'tag' => $tags, 'offset' => $offset, 'orderby' => $order, 'ignore_sticky_posts' => 1);
		$spotlight_loop = new WP_Query($args);
		while ($spotlight_loop->have_posts()) : $spotlight_loop->the_post(); ?>
			<div class="sl-caption"><?php echo $title; ?></div>	
			<div class="sl-thumb">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php
					if (has_post_thumbnail()) { 
						if ($width == 'normal_sl') {
							the_post_thumbnail('spotlight');
						} else {
							the_post_thumbnail('slider');
						}
					} else {
						if ($width == 'normal_sl') {
							echo '<img src="' . get_template_directory_uri() . '/images/noimage_580x326.png' . '" alt="No Picture" />';
						} else { 
							echo '<img src="' . get_template_directory_uri() . '/images/noimage_940x400.png' . '" alt="No Picture" />';
						}
					} ?>
				</a>
			</div>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h2 class="sl-title"><?php the_title(); ?></h2></a>
			<?php if ($meta == 0) { ?>
				<p class="meta"><?php _e('by ', 'xt') . the_author() . _e(' in ', 'xt'); ?><?php $category = get_the_category(); echo $category[0]->cat_name; ?></p>
			<?php } ?>
			<?php if ($excerpt == 0) { ?>
				<?php xt_excerpt($excerpt_length); ?>
			<?php } ?>
			<?php if ($meta == 0) { ?>
			<p class="meta"><?php comments_number(__('0 Comments', 'xt'), __('1 Comment', 'xt'), __('% Comments', 'xt')); ?></p>
			<?php } 
		endwhile; wp_reset_postdata(); ?>		
		</article><?php 
        echo $after_widget;             
    }    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = $new_instance['category'];
        $instance['tags'] = strip_tags($new_instance['tags']);
        $instance['offset'] = strip_tags($new_instance['offset']);
        $instance['order'] = $new_instance['order'];
        $instance['width'] = $new_instance['width'];
        $instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['meta'] = $new_instance['meta'];
        return $instance;     
    }   
    function form($instance) {
        $defaults = array('title' => '', 'category' => '', 'tags' => '', 'offset' => '0', 'order' => 'date', 'width' => 'normal_sl', 'excerpt_length' => '175', 'excerpt' => 0, 'meta' => 0);
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
	    	<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Image size:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text">
				<option value="normal_sl" <?php if ($instance['width'] == "normal_sl") { echo "selected='selected'"; } ?>>580x326px</option>
				<option value="large_sl" <?php if ($instance['width'] == "large_sl") { echo "selected='selected'"; } ?>>940x400px</option>
			</select>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Show excerpt with', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['excerpt_length']); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" id="<?php echo $this->get_field_id('excerpt_length'); ?>" /> <?php _e('characters', 'xt'); ?>
	    </p>
        <p>
      		<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked('1', $instance['excerpt']); ?>/>
	  		<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Disable excerpt', 'xt'); ?></label>
    	</p>
        <p>
      		<input id="<?php echo $this->get_field_id('meta'); ?>" name="<?php echo $this->get_field_name('meta'); ?>" type="checkbox" value="1" <?php checked('1', $instance['meta']); ?>/>
	  		<label for="<?php echo $this->get_field_id('meta'); ?>"><?php _e('Disable post meta', 'xt'); ?></label>
    	</p><?php    
    }
}

?>