<?php

/***** Slider Widget (Homepage) *****/	

class xt_slider_hp_widget extends WP_Widget {
    function xt_slider_hp_widget() {
        $widget_ops = array('classname' => 'xt_slider_hp', 'description' => __('Slider widget for use on homepage templates', 'xt'));
        $this->WP_Widget('xt_slider_hp', __('XT Slider Widget (Homepage)', 'xt'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $category = isset($instance['category']) ? $instance['category'] : '';
        $tags = empty($instance['tags']) ? '' : $instance['tags'];
        $postcount = empty($instance['postcount']) ? '5' : $instance['postcount'];
        $offset = empty($instance['offset']) ? '' : $instance['offset'];
        $order = isset($instance['order']) ? $instance['order'] : 'date';
        $width = isset($instance['width']) ? $instance['width'] : 'large_slider';
        $sticky = isset($instance['sticky']) ? $instance['sticky'] : 0;
        $excerpt = isset($instance['excerpt']) ? $instance['excerpt'] : 0;
        $excerpt_length = empty($instance['excerpt_length']) ? '175' : $instance['excerpt_length']; 
               
        echo $before_widget; ?>
        <section id="slider" class="flexslider <?php echo $width; ?>">
			<ul class="slides"><?php
			$args = array('posts_per_page' => $postcount, 'cat' => $category, 'tag' => $tags, 'offset' => $offset, 'orderby' => $order, 'ignore_sticky_posts' => $sticky);
			$slider = new WP_query($args);
			while ($slider->have_posts()) : $slider->the_post(); ?>
				<li>
				<article class="slide-wrap">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php 
						if (has_post_thumbnail()) { 
							if ($width == 'large_slider') {
								the_post_thumbnail('slider');
							} else {
								the_post_thumbnail('content');
							}
						} else {
							if ($width == 'large_slider') {
								echo '<img src="' . get_template_directory_uri() . '/images/noimage_940x400.png' . '" alt="No Picture" />';
							} else { 
								echo '<img src="' . get_template_directory_uri() . '/images/noimage_620x264.png' . '" alt="No Picture" />';
							}
						} ?>
					</a>
					<div class="slide-caption">
						<div class="slide-data">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h2 class="slide-title"><?php the_title(); ?></h2></a>
							<?php if ($excerpt == 0) { ?>
								<div class="slide-excerpt"><?php xt_excerpt($excerpt_length); ?></div>
							<?php } ?>
						</div>
					</div>										
				</article>	
				</li><?php 
			endwhile; wp_reset_postdata(); ?>
			</ul>
		</section><?php 
        echo $after_widget;            
    }    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['category'] = $new_instance['category'];
        $instance['tags'] = strip_tags($new_instance['tags']);
        $instance['postcount'] = strip_tags($new_instance['postcount']);
        $instance['offset'] = strip_tags($new_instance['offset']);
        $instance['order'] = $new_instance['order'];
        $instance['width'] = $new_instance['width'];
        $instance['sticky'] = $new_instance['sticky'];
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
        return $instance;     
    }   
    function form($instance) {
        $defaults = array('category' => '', 'tags' => '', 'postcount' => '5', 'offset' => '0', 'order' => 'date', 'width' => 'large_slider', 'sticky' => 0, 'excerpt' => 0, 'excerpt_length' => '175');
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        
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
	    	<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Slider image size:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text">
				<option value="normal_slider" <?php if ($instance['width'] == "normal_slider") { echo "selected='selected'"; } ?>>620x264px</option>
				<option value="large_slider" <?php if ($instance['width'] == "large_slider") { echo "selected='selected'"; } ?>>940x400px</option>
			</select>
        </p>
        <p>
      		<input id="<?php echo $this->get_field_id('sticky'); ?>" name="<?php echo $this->get_field_name('sticky'); ?>" type="checkbox" value="1" <?php checked('1', $instance['sticky']); ?>/>
	  		<label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e('Ignore Sticky Posts', 'xt'); ?></label>
    	</p>
    	<p>
      		<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked('1', $instance['excerpt']); ?>/>
	  		<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Disable excerpt', 'xt'); ?></label>
    	</p>
    	<p>
        	<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Show excerpt with', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['excerpt_length']); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" id="<?php echo $this->get_field_id('excerpt_length'); ?>" /> <?php _e('characters', 'xt'); ?>
	    </p><?php    
    }
}

?>