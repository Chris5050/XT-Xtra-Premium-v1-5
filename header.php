<!DOCTYPE html>
<html class="no-js<?php xt_html_class(); ?>" <?php language_attributes(); xt_html_tag(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title('|', true, 'right'); ?></title>
<?php wp_head(); ?>
</head>
<body id="<?php xt_body_id(); ?>" <?php body_class(); ?>> 
<?php if (is_active_sidebar('header')) { ?>
<aside class="header-widget">
	<?php dynamic_sidebar('header'); ?>
</aside>
<?php } ?>
<div class="container <?php xt_container_class(); ?>">
<?php xt_before_header(); ?>
<header class="header-wrap">
	<?php if (has_nav_menu('header_nav')) { ?>
	<nav class="header-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'header_nav', 'fallback_cb' => '')); ?>
	</nav>
	<?php } ?>
	<?php xt_logo(); ?>
	<nav class="main-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'main_nav')); ?>
	</nav>
</header>
<?php xt_after_header(); ?>