<?php

add_action('widgets_init', 'register_xt_widgets');

/***** Register Widgets *****/	
   
function register_xt_widgets() {
	register_widget('xt_facebook_widget');
	register_widget('xt_custom_posts_widget');
	register_widget('xt_nip_widget');
	register_widget('xt_comments_widget');
	register_widget('xt_slider_hp_widget');
	register_widget('xt_spotlight_hp_widget');
	register_widget('xt_carousel_hp_widget');
	register_widget('xt_authors_widget');	
	register_widget('xt_social_widget');
} 

/***** Include Widgets *****/

require_once('widgets/xt-facebook-likebox.php');
require_once('widgets/xt-custom-posts.php');
require_once('widgets/xt-nip.php');
require_once('widgets/xt-comments.php');
require_once('widgets/xt-slider.php');
require_once('widgets/xt-spotlight.php');
require_once('widgets/xt-carousel.php');
require_once('widgets/xt-authors.php');
require_once('widgets/xt-social.php');

?>