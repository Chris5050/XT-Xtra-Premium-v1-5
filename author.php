<?php $options = get_option('xt_options'); ?>
<?php get_header(); ?>
<div class="wrapper clearfix">
	<div class="main">
		<section class="content <?php xt_content_class(); ?>">
			<?php xt_before_page_content(); ?>
			<?php xt_author_box(); ?> 
			<?php xt_loop_content(); ?>	
		</section>
		<aside class="sidebar <?php xt_sb_class(); ?>">
    		<?php dynamic_sidebar('sidebar'); ?>     
		</aside>
	</div>
    <?php xt_second_sb(); ?>
</div>
<?php get_footer(); ?>