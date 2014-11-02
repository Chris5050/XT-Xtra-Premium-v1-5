<?php /* Default template for displaying content. */ ?>
<?php $options = get_option('xt_options'); ?>
<article <?php post_class(); ?>>
	<header class="post-header">			
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php xt_post_header(); ?>
	</header>
	<?php dynamic_sidebar('posts-1'); ?>
	<div class="entry clearfix">
		<?php xt_post_content(); ?>
	</div>
	<?php wp_link_pages(array('before' => '<p class="pagination">', 'after' => '</p>', 'link_before' => '<span class="pagelink">', 'link_after' => '</span>', 'nextpagelink' => __('&raquo;', 'xt'), 'previouspagelink' => __('&laquo;', 'xt'), 'pagelink' => '%', 'echo' => 1)); ?>           
	<?php if (has_tag()) : ?>
		<div class="post-tags clearfix">
        	<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
        </div>
	<?php endif; ?>
	<?php dynamic_sidebar('posts-2'); ?>	
</article>