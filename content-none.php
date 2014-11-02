<?php /** The template for displaying a "No posts found" message. */ ?>
<div class="entry sb-widget">
<?php if (is_search()) { ?>
	<div class="box alert">
		<p><?php echo __('Error! sorry no match was found for the search terms entered. Change your search terms and try again.', 'xt'); ?></p>
	</div>
<?php } else { ?>
	<div class="box alert">
		<p><?php echo __('It appears we can&rsquo;t find what you&rsquo;re searching for. Perhaps searching different terms may help.', 'xt'); ?></p>
	</div>
<?php } ?>
<?php get_search_form(); ?>
</div>
<div class="row clearfix">
	<div class="col-1-2 mq-content"><?php
		$instance = array('title' => __('Popular posts', 'xt'), 'postcount' => '9', 'order' => 'comment_count', 'excerpt' => 'first');
		$args = array('before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>');
		the_widget('xt_custom_posts_widget', $instance , $args); ?>
	</div>
	<div class="col-1-2 mq-content"><?php	
		$instance = array('title' => __('Random posts', 'xt'), 'postcount' => '9', 'order' => 'rand', 'excerpt' => 'first');
		$args = array('before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>');
		the_widget('xt_custom_posts_widget', $instance , $args); ?>
	</div>
</div>