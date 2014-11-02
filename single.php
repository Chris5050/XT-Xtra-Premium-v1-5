<?php $options = get_option('xt_options'); ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="wrapper clearfix">
	<div class="main">
		<div class="content <?php xt_content_class(); ?>"><?php 
			xt_before_post_content();
			if (is_attachment()) {
				get_template_part('content', 'attachment');	
			} else {
				get_template_part('content', get_post_format());
			}
			xt_after_post_content();
			endwhile;
			comments_template();
			endif; ?>
		</div>
		<aside class="sidebar <?php xt_sb_class(); ?>">
    		<?php dynamic_sidebar('sidebar'); ?>     
		</aside>
	</div>   
    <?php xt_second_sb(); ?>
</div> 
<?php get_footer(); ?>