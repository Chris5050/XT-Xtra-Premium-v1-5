<?php

/***** Comments Widget *****/	

class xt_comments_widget extends WP_Widget {
    function xt_comments_widget() {
        $widget_ops = array('classname' => 'xt_comments', 'description' => __('XT Recent Comments widget to display your recent comments including user avatars', 'xt'));
        $this->WP_Widget('xt_comments', __('XT Recent Comments', 'xt'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $number = empty($instance['number']) ? '5' : $instance['number'];
        $offset = empty($instance['offset']) ? '' : $instance['offset'];
        $avatar_size = isset($instance['avatar_size']) ? $instance['avatar_size'] : '48';
        
        echo $before_widget;
        if (!empty($title)) { echo $before_title . $title . $after_title; } ?>
        <ul class="user-widget row clearfix"><?php
		$comments = get_comments(array('number' => $number, 'offset' => $offset, 'status' => 'approve')); 
		if ($comments) {
			foreach ($comments as $comment) { ?>
				<li class="uw-wrap clearfix"><?php
					if ($avatar_size != 'no_avatar') { ?>
						<div class="uw-avatar"><a href="<?php echo get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID; ?>" title="<?php echo $comment->comment_author; ?>"><?php echo get_avatar($comment->comment_author_email, $avatar_size); ?></a></div><?php
					} ?>
					<div class="uw-text"><?php echo $comment->comment_author . __(' on ', 'xt'); ?><a href="<?php echo get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID; ?>" title="<?php echo $comment->comment_author . ' | ' . get_the_title($comment->comment_post_ID); ?>"><?php echo get_the_title($comment->comment_post_ID); ?></a></div>
				</li><?php
			} 
		} ?>
        </ul><?php    
        echo $after_widget;      
    }    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = strip_tags($new_instance['number']);
        $instance['offset'] = strip_tags($new_instance['offset']);
        $instance['avatar_size'] = $new_instance['avatar_size'];
        return $instance;     
    }   
    function form($instance) {
        $defaults = array('title' => __('Recent Comments', 'xt'), 'number' => '5', 'offset' => '0', 'avatar_size' => '48');
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'xt'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Show:', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['number']); ?>" name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" /> <?php _e('Comments', 'xt'); ?>
	    </p>
	    <p>
        	<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Skip:', 'xt'); ?></label>
			<input type="text" size="2" value="<?php echo esc_attr($instance['offset']); ?>" name="<?php echo $this->get_field_name('offset'); ?>" id="<?php echo $this->get_field_id('offset'); ?>" /> <?php _e('Comments', 'xt'); ?>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Avatar Size in px:', 'xt'); ?></label>
			<select id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="text">
				<option value="16" <?php if ($instance['avatar_size'] == "16") { echo "selected='selected'"; } ?>><?php _e('16 x 16', 'xt') ?></option>
				<option value="32" <?php if ($instance['avatar_size'] == "32") { echo "selected='selected'"; } ?>><?php _e('32 x 32', 'xt') ?></option>
				<option value="48" <?php if ($instance['avatar_size'] == "48") { echo "selected='selected'"; } ?>><?php _e('48 x 48', 'xt') ?></option>
				<option value="64" <?php if ($instance['avatar_size'] == "64") { echo "selected='selected'"; } ?>><?php _e('64 x 64', 'xt') ?></option>
				<option value="no_avatar" <?php if ($instance['avatar_size'] == "no_avatar") { echo "selected='selected'"; } ?>><?php _e('No Avatars', 'xt') ?></option>
			</select>
        </p><?php    
    }
}

?>