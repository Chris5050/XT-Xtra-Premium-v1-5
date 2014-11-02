<?php

/***** Carousel Widget (Homepage) *****/	

class xt_carousel_hp_widget extends WP_Widget {
    function xt_carousel_hp_widget() {
        $widget_ops = array('classname' => 'xt_carousel_hp', 'description' => __('Carousel widget for use on homepage templates', 'xt'));
        $this->WP_Widget('xt_carousel_hp', __('XT Carousel Widget (Homepage)', 'xt'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Latest Posts', 'xt') : $instance['title'], $instance, $this->id_base);
        $category = isset($instance['category']) ? $instance['category'] : '';
        $tags = empty($instance['tags']) ? '' : $instance['tags'];
        $postcount = empty($instance['postcount']) ? '10' : $instance['postcount'];
        $offset = empty($instance['offset']) ? '' : $instance['offset'];  
        $order = $instance['order'];
        $sticky = isset($instance['sticky']) ? $instance['sticky'] : 0;
               
        echo $before_widget; ?>
        <h3 id="carousel-title"><?php echo $title; ?></h3>
        <div id="carousel" class="flexslider">
	        <ul class="slides"><?php
			$args = array('posts_per_page' => $postcount, 'cat' => $category, 'tag' => $tags, 'offset' => $offset, 'orderby' => $order, 'ignore_sticky_posts' => $sticky);
			$carousel_loop = new WP_Query($args);
			while ($carousel_loop->have_posts()) : $carousel_loop->the_post(); ?>
				<li class="carousel-item">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('carousel'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_174x98.png' . '" alt="No Picture" />'; } ?></a>
					<div class="caption"><?php $category = get_the_category(); echo $category[0]->cat_name; ?></div>
				</li><?php 
			endwhile; wp_reset_postdata(); ?>	
			</ul>	
		</div><?php
        echo $after_widget;      
    }    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = $new_instance['category'];
        $instance['tags'] = strip_tags($new_instance['tags']);
        $instance['postcount'] = strip_tags($new_instance['postcount']);
        $instance['offset'] = strip_tags($new_instance['offset']);
        $instance['order'] = $new_instance['order'];
        $instance['sticky'] = $new_instance['sticky'];
        return $instance;     
    }   
    function form($instance) {
        $defaults = array('title' => '', 'category' => '', 'tags' => '', 'postcount' => '10', 'offset' => '0', 'order' => 'date', 'sticky' => 0);
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
      		<input id="<?php echo $this->get_field_id('sticky'); ?>" name="<?php echo $this->get_field_name('sticky'); ?>" type="checkbox" value="1" <?php checked('1', $instance['sticky']); ?>/>
	  		<label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e('Ignore Sticky Posts', 'xt'); ?></label>
    	</p><?php    
    }
}

?>