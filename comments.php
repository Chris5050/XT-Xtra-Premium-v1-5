<?php /* Comments Template */
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Do not load page directly. Thankyou!');
if (post_password_required()) { ?>
	<p class="no-comments"><?php echo __('Password protected post area. provide your password for viewing of comments.', 'xt'); ?></p><?php
	return;
}
$comments_by_type = separate_comments($comments);
if (have_comments()) {
	if (!empty($comments_by_type['comment'])) {		
		$comment_count = count($comments_by_type['comment']);
		($comment_count !== 1) ? $comment_text = __('Comments', 'xt') : $comment_text = __('Comment', 'xt'); ?>				
		<h4 class="section-title"><?php echo $comment_count . ' ' . $comment_text . __(' on ', 'xt') . get_the_title(); ?></h4>
		<ol class="commentlist">
			<?php echo wp_list_comments('callback=xt_comments&type=comment'); ?>
		</ol><?php				
	}
	if (get_comments_number() > get_option('comments_per_page')) { ?>
		<div class="comments-pagination">
			<?php paginate_comments_links(array('prev_text' => __('&laquo;', 'xt'), 'next_text' => __('&raquo;', 'xt'))); ?>
		</div><?php
	}
	if (!empty($comments_by_type['pings'])) {
		$pings = $comments_by_type['pings'];
		$ping_count = count($comments_by_type['pings']); ?>
		<h4 class="section-title"><?php echo $ping_count . ' ' . __('Trackbacks & Pingbacks', 'xt'); ?></h4>
		<ol class="pinglist">
        <?php foreach ($pings as $ping) { ?>
			<li class="pings"><?php echo get_comment_author_link($ping); ?></li>
        <?php } ?>
        </ol><?php
	}		
	if (!comments_open()) { ?>
		<p class="no-comments"><?php _e('Comments are closed.', 'xt'); ?></p><?php	
	}
}
if (comments_open()) {       
	$custom_args = array( 
    	'title_reply' => __('Leave a comment', 'xt'), 
        'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.', 'xt') . '</p>',
        'comment_notes_after'  => '', 
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __('Comment', 'xt') . '</label><br/><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>');
	comment_form($custom_args);        				
} 
?>