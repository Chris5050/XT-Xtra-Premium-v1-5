<?php $options = get_option('xt_options'); ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="wrapper clearfix">
	<div class="main">
    	<div class="content <?php xt_content_class(); ?>">
    		<?php xt_before_page_content(); ?>	
            <div <?php post_class(); ?>>
	        	<div class="entry clearfix">
	        		<?php dynamic_sidebar('pages-1'); ?>
		        	<?php the_content(); ?>
		        </div>
		    </div>
		    <?php dynamic_sidebar('pages-2'); ?>
			<?php endwhile; ?>
				<?php if (isset($options['comments_pages']) ? $options['comments_pages'] : false) : ?>
				<section>
        			<?php comments_template(); ?>
				</section>
				<?php endif; ?>
            <?php endif; ?>
        </div>
        <aside class="sidebar <?php xt_sb_class(); ?>">
    		<?php dynamic_sidebar('sidebar'); ?>     
		</aside>
    </div>
    <?php xt_second_sb(); ?>        
</div>
<?php get_footer(); ?>