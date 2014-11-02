<?php /* Template Name: Contact */ ?>
<?php $options = get_option('xt_options'); ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="wrapper clearfix">
	<div class="main">
    	<div class="content <?php xt_content_class(); ?>">
    		<?php xt_before_page_content(); ?>
            <div <?php post_class(); ?>>
	        	<div class="entry clearfix">
	        		<?php the_content(); ?>
	        	</div>
		    </div>
			<?php endwhile; ?>
            <?php endif; ?>
        </div>
        <aside class="sidebar <?php xt_sb_class(); ?>">
    		<?php dynamic_sidebar('contact'); ?>     
		</aside>
    </div> 
    <?php if (isset($options['2nd_sidebar']) && $options['2nd_sidebar']) : ?>
    <aside class="sidebar-2 sb-right">
    	<?php dynamic_sidebar('contact-2'); ?>     
    </aside>
    <?php endif; ?>       
</div>
<?php get_footer(); ?>