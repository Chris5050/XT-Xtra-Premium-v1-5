<?php

function xt_customize_register($wp_customize) {

	/***** Register Custom Controls *****/
	
	class xt_Customize_Textarea_Control extends WP_Customize_Control {
    	public $type = 'textarea';
    	public function render_content() { ?>
            <label>
                <span class="customize-textarea"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width: 100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label> <?php
	    }
	}
	
	class xt_Customize_Image_Control extends WP_Customize_Image_Control {
    	public $extensions = array('jpg', 'jpeg', 'gif', 'png', 'ico');
	}

	/***** Add Sections *****/

	$wp_customize->add_section('xt_general', array('title' => __('General Selections', 'xt'), 'priority' => 1));
	$wp_customize->add_section('xt_layout', array('title' => __('Layout Selections', 'xt'), 'priority' => 2));
	$wp_customize->add_section('xt_typo', array('title' => __('Font Selections', 'xt'), 'priority' => 3));
	$wp_customize->add_section('xt_selector', array('title' => __('News Selector Selections', 'xt'), 'priority' => 4));
	$wp_customize->add_section('xt_content', array('title' => __('Posts/Pages Selections', 'xt'), 'priority' => 5));
	$wp_customize->add_section('xt_ads', array('title' => __('Advertising', 'xt'), 'priority' => 6));
	$wp_customize->add_section('xt_seo', array('title' => __('SEO Selections', 'xt'), 'priority' => 7));
    $wp_customize->add_section('xt_css', array('title' => __('Custom CSS', 'xt'), 'priority' => 8));
    $wp_customize->add_section('xt_tracking', array('title' => __('Tracking Code', 'xt'), 'priority' => 9));
   
    /***** Add Settings *****/
    
    $wp_customize->add_setting('xt_options[full_bg]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[no_prettyphoto]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[xt_favicon]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[excerpt_length]', array('default' => '175', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    $wp_customize->add_setting('xt_options[excerpt_more]', array('default' => '[...]', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));
    $wp_customize->add_setting('xt_options[copyright]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));
        
    $wp_customize->add_setting('xt_options[site_width]', array('default' => 'normal', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));
    $wp_customize->add_setting('xt_options[wt_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));
    $wp_customize->add_setting('xt_options[page_title_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));
    $wp_customize->add_setting('xt_options[related_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));
    $wp_customize->add_setting('xt_options[loop_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));
    $wp_customize->add_setting('xt_options[sb_position]', array('default' => 'right', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_select'));   
    $wp_customize->add_setting('xt_options[2nd_sidebar]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[no_responsive]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    
    $wp_customize->add_setting('xt_options[font_size]', array('default' => '14', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    $wp_customize->add_setting('xt_options[font_heading]', array('default' => 'open_sans', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[font_body]', array('default' => 'open_sans', 'type' => 'option'));
    
    $wp_customize->add_setting('xt_options[show_selector]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[selector_title]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));
    $wp_customize->add_setting('xt_options[selector_posts]', array('default' => '5', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    $wp_customize->add_setting('xt_options[selector_cats]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    $wp_customize->add_setting('xt_options[selector_tags]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));
    $wp_customize->add_setting('xt_options[selector_offset]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    
    $wp_customize->add_setting('xt_options[teaser_text]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));       
    $wp_customize->add_setting('xt_options[featured_image]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));  
    $wp_customize->add_setting('xt_options[post_meta]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));   
    $wp_customize->add_setting('xt_options[author_box]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));        
    $wp_customize->add_setting('xt_options[author_contact]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[comments_pages]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));       
    $wp_customize->add_setting('xt_options[post_nav]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[related_posts]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[share_buttons]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    
    $wp_customize->add_setting('xt_options[content_ad]', array('default' => '', 'type' => 'option'));   
    $wp_customize->add_setting('xt_options[loop_ad]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[loop_ad_no]', array('default' => '3', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_integer'));
    
    $wp_customize->add_setting('xt_options[activate_seo]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));       
    $wp_customize->add_setting('xt_options[activate_google_author]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));           
    $wp_customize->add_setting('xt_options[activate_fb_og]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));               
    $wp_customize->add_setting('xt_options[meta_keywords]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[clean_head]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));  
    $wp_customize->add_setting('xt_options[noindex_atts]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));    
    $wp_customize->add_setting('xt_options[noindex_cats]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[noindex_tags]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[noindex_date]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[breadcrumbs]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_checkbox'));
    $wp_customize->add_setting('xt_options[google_publisher]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));
    $wp_customize->add_setting('xt_options[verify_gwt]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'xt_sanitize_text'));    
    
    $wp_customize->add_setting('xt_options[custom_css]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[tracking_code]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_bg_header]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_bg_inner]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_1]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_2]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_3]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_text_general]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_text_second]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_text_meta]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('xt_options[color_links', array('default' => '', 'type' => 'option'));
    
    /***** Add Controls *****/
        
    $wp_customize->add_control('full_bg', array('label' => __('Scale background image to full size', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[full_bg]', 'priority' => 1, 'type' => 'checkbox'));        
    $wp_customize->add_control('no_prettyphoto', array('label' => __('Disable prettyPhoto lightbox', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[no_prettyphoto]', 'priority' => 2, 'type' => 'checkbox'));
    $wp_customize->add_control(new xt_Customize_Image_Control($wp_customize, 'xt_favicon', array('label' => __('Favicon upload', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[xt_favicon]', 'priority' => 3)));    
    $wp_customize->add_control('excerpt_length', array('label' => __('Custom excerpt length in characters', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[excerpt_length]', 'priority' => 4, 'type' => 'text'));
    $wp_customize->add_control('excerpt_more', array('label' => __('Custom excerpt more text', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[excerpt_more]', 'priority' => 5, 'type' => 'text'));    
    $wp_customize->add_control('copyright', array('label' => __('Copyright text', 'xt'), 'section' => 'xt_general', 'settings' => 'xt_options[copyright]', 'priority' => 6, 'type' => 'text'));

	$wp_customize->add_control('site_width', array('label' => __('Set site width', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[site_width]', 'priority' => 1, 'type' => 'select', 'choices' => array('normal' => '980px', 'large' => '1300px')));
    $wp_customize->add_control('wt_layout', array('label' => __('Layout of widget titles', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[wt_layout]', 'priority' => 2, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'layout3' => 'Layout 3')));
    $wp_customize->add_control('page_title_layout', array('label' => __('Layout of page titles', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[page_title_layout]', 'priority' => 3, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2')));
    $wp_customize->add_control('related_layout', array('label' => __('Layout of related articles', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[related_layout]', 'priority' => 4, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2')));
    $wp_customize->add_control('loop_layout', array('label' => __('Layout of archives', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[loop_layout]', 'priority' => 5, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2')));
    $wp_customize->add_control('sb_position', array('label' => __('Position of default sidebar', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[sb_position]', 'priority' => 6, 'type' => 'select', 'choices' => array('left' => __('Left', 'xt'), 'right' => __('Right', 'xt'))));  
    $wp_customize->add_control('2nd_sidebar', array('label' => __('Enable second sidebar', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[2nd_sidebar]', 'priority' => 7, 'type' => 'checkbox'));
    $wp_customize->add_control('no_responsive', array('label' => __('Disable responsive layout', 'xt'), 'section' => 'xt_layout', 'settings' => 'xt_options[no_responsive]', 'priority' => 8, 'type' => 'checkbox'));       
    	
	$wp_customize->add_control('font_size', array('label' => __('Change default font size (px)', 'xt'), 'section' => 'xt_typo', 'settings' => 'xt_options[font_size]', 'priority' => 1, 'type' => 'text'));
	$google_fonts = array('armata' => 'Armata', 'arvo' => 'Arvo', 'bree_serif' => 'Bree Serif', 'droid_sans' => 'Droid Sans', 'droid_sans_mono' => 'Droid Sans Mono', 'droid_serif' => 'Droid Serif', 'lato' => 'Lato', 'lora' => 'Lora', 'merriweather' => 'Merriweather', 'merriweather_sans' => 'Merriweather Sans', 'monda' => 'Monda', 'nobile' => 'Nobile', 'noto_sans' => 'Noto Sans', 'noto_serif' => 'Noto Serif', 'open_sans' => 'Open Sans', 'oswald' => 'Oswald', 'oxygen' => 'Oxygen', 'pt_sans' => 'PT Sans', 'pt_serif' => 'PT Serif', 'raleway' => 'Raleway', 'roboto_condensed' => 'Roboto Condensed', 'ubuntu' => 'Ubuntu', 'yanone_kaffeesatz' => 'Yanone Kaffeesatz');
	$wp_customize->add_control('font_heading', array('label' => __('Select font for headings', 'xt'), 'section' => 'xt_typo', 'settings' => 'xt_options[font_heading]', 'priority' => 2, 'type' => 'select', 'choices' => $google_fonts));
	$wp_customize->add_control('font_body', array('label' => __('Select font for body text', 'xt'), 'section' => 'xt_typo', 'settings' => 'xt_options[font_body]', 'priority' => 3, 'type' => 'select', 'choices' => $google_fonts));

	$wp_customize->add_control('show_selector', array('label' => __('Enable selector', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[show_selector]', 'priority' => 1, 'type' => 'checkbox'));
    $wp_customize->add_control('selector_title', array('label' => __('selector title', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[selector_title]', 'priority' => 2, 'type' => 'text'));
    $wp_customize->add_control('selector_posts', array('label' => __('Number of posts to show', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[selector_posts]', 'priority' => 3, 'type' => 'text'));
    $wp_customize->add_control('selector_cats', array('label'=> __('Custom categories (use ID - e.g. 3,5,9):', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[selector_cats]', 'priority' => 4, 'type' => 'text'));
    $wp_customize->add_control('selector_tags', array('label' => __('Custom tags (use slug - e.g. lifestyle):', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[selector_tags]', 'priority' => 5, 'type' => 'text'));
    $wp_customize->add_control('selector_offset', array('label' => __('Offset', 'xt'), 'section' => 'xt_selector', 'settings' => 'xt_options[selector_offset]', 'priority' => 6, 'type' => 'text'));    
    
    $wp_customize->add_control('teaser_text', array('label' => __('Disable teaser text on posts', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[teaser_text]', 'priority' => 1, 'type' => 'checkbox'));   
    $wp_customize->add_control('featured_image', array('label' => __('Disable featured image on posts', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[featured_image]', 'priority' => 2, 'type' => 'checkbox'));
    $wp_customize->add_control('post_meta', array('label' => __('Disable post meta', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[post_meta]', 'priority' => 3, 'type' => 'checkbox'));
    $wp_customize->add_control('author_box', array('label' => __('Disable author box on posts/archives', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[author_box]', 'priority' => 4, 'type' => 'checkbox'));          
    $wp_customize->add_control('author_contact', array('label' => __('Hide contact information in author box', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[author_contact]', 'priority' => 5, 'type' => 'checkbox'));        
    $wp_customize->add_control('comments_pages', array('label' => __('Enable comments on pages', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[comments_pages]', 'priority' => 6, 'type' => 'checkbox'));       
    $wp_customize->add_control('post_nav', array('label' => __('Enable post / attachment navigation', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[post_nav]', 'priority' => 7, 'type' => 'checkbox'));   
    $wp_customize->add_control('related_posts', array('label' => __('Enable related articles on posts', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[related_posts]', 'priority' => 8, 'type' => 'checkbox'));
    $wp_customize->add_control('share_buttons', array('label' => __('Enable share buttons on posts', 'xt'), 'section' => 'xt_content', 'settings' => 'xt_options[share_buttons]', 'priority' => 9, 'type' => 'checkbox'));
       
    $wp_customize->add_control(new xt_Customize_Textarea_Control($wp_customize, 'content_ad', array('label' => __('Ad code for content ad on posts', 'xt'), 'section' => 'xt_ads', 'settings' => 'xt_options[content_ad]', 'priority' => 1)));
    $wp_customize->add_control(new xt_Customize_Textarea_Control($wp_customize, 'loop_ad', array('label' => __('Ad code for ads on archives', 'xt'), 'section' => 'xt_ads', 'settings' => 'xt_options[loop_ad]', 'priority' => 2)));
    $wp_customize->add_control('loop_ad_no', array('label'=> __('Display ad every x posts on archives:', 'xt'), 'section' => 'xt_ads', 'settings' => 'xt_options[loop_ad_no]', 'priority' => 3, 'type' => 'text'));
    
    $wp_customize->add_control('activate_seo', array('label' => __('Enable SEO features', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[activate_seo]', 'priority' => 1, 'type' => 'checkbox'));          
    $wp_customize->add_control('activate_google_author', array('label' => __('Enable Google Authorship', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[activate_google_author]', 'priority' => 2, 'type' => 'checkbox'));    
    $wp_customize->add_control('activate_fb_og', array('label' => __('Enable Facebook Open Graph', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[activate_fb_og]', 'priority' => 3, 'type' => 'checkbox'));   
    $wp_customize->add_control('meta_keywords', array('label' => __('Use post tags as meta keywords', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[meta_keywords]', 'priority' => 4, 'type' => 'checkbox'));     
    $wp_customize->add_control('clean_head', array('label' => __('Clean up head section', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[clean_head]', 'priority' => 5, 'type' => 'checkbox')); 
    $wp_customize->add_control('noindex_atts', array('label' => __('Set attachments to noindex', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[noindex_atts]', 'priority' => 6, 'type' => 'checkbox'));     
    $wp_customize->add_control('noindex_cats', array('label' => __('Set category archives to noindex', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[noindex_cats]', 'priority' => 7, 'type' => 'checkbox'));
    $wp_customize->add_control('noindex_tags', array('label' => __('Set tag archives to noindex', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[noindex_tags]', 'priority' => 8, 'type' => 'checkbox'));
    $wp_customize->add_control('noindex_date', array('label' => __('Set date based archives to noindex', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[noindex_date]', 'priority' => 9, 'type' => 'checkbox')); 
    $wp_customize->add_control('breadcrumbs', array('label' => __('Enable breadcrumbs', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[breadcrumbs]', 'priority' => 10, 'type' => 'checkbox'));
    $wp_customize->add_control('google_publisher', array('label' => __('Google Publisher Page', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[google_publisher]', 'priority' => 11, 'type' => 'text'));
    $wp_customize->add_control('verify_gwt', array('label' => __('Google Webmaster Tools Verification', 'xt'), 'section' => 'xt_seo', 'settings' => 'xt_options[verify_gwt]', 'priority' => 12, 'type' => 'text'));    
    
    $wp_customize->add_control(new xt_Customize_Textarea_Control($wp_customize, 'custom_css', array('label' => __('Custom CSS', 'xt'), 'section' => 'xt_css', 'settings' => 'xt_options[custom_css]', 'priority' => 1)));
    $wp_customize->add_control(new xt_Customize_Textarea_Control($wp_customize, 'tracking_code', array('label' => __('Tracking Code (e.g. Google Analytics)', 'xt'), 'section' => 'xt_tracking', 'settings' => 'xt_options[tracking_code]', 'priority' => 1)));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_header', array('label' => __('Background Header', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_bg_header]', 'priority' => 10)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_inner', array('label' => __('Background Inner', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_bg_inner]', 'priority' => 11)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_1', array('label' => __('Color 1', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_1]', 'priority' => 12)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_2', array('label' => __('Color 2', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_2]', 'priority' => 13)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_3', array('label' => __('Color 3', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_3]', 'priority' => 14)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_general', array('label' => __('Text: General', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_text_general]', 'priority' => 15)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_second', array('label' => __('Text: 2nd Color', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_text_second]', 'priority' => 16)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_meta', array('label' => __('Text: Post Meta', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_text_meta]', 'priority' => 17)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_links', array('label' => __('Link Color', 'xt'), 'section' => 'colors', 'settings' => 'xt_options[color_links]', 'priority' => 18)));
}
add_action('customize_register', 'xt_customize_register');

/***** Data Sanitization *****/

function xt_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}
function xt_sanitize_integer($input) {
    return strip_tags($input);
}
function xt_sanitize_checkbox($input) {
    if ($input == 1) {
        return 1;
    } else {
        return '';
    }
}
function xt_sanitize_select($input) {
    $valid = array(
        'left' => __('Left', 'xt'),
        'right' => __('Right', 'xt'),
        'normal' => '980px',
        'large' => '1300px',
        'layout1' => 'Layout 1',
        'layout2' => 'Layout 2',
        'layout3' => 'Layout 3'
    ); 
    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

/***** CSS Output *****/

function xt_custom_css() {
	$options = get_option('xt_options');
	$font_css = array('armata' => '"Armata", sans-serif', 'arvo' => '"Arvo", serif', 'bree_serif' => '"Bree Serif", serif', 'droid_sans' => '"Droid Sans", sans-serif', 'droid_sans_mono' => '"Droid Sans Mono", sans-serif', 'droid_serif' => '"Droid Serif", serif', 'lato' => '"Lato", sans-serif', 'lora' => '"Lora", serif', 'merriweather' => '"Merriweather", serif', 'merriweather_sans' => '"Merriweather Sans", sans-serif', 'monda' => '"Monda", sans-serif', 'nobile' => '"Nobile", sans-serif', 'noto_sans' => '"Noto Sans", sans-serif', 'noto_serif' => '"Noto Serif", serif', 'open_sans' => '"Open Sans", sans-serif', 'oswald' => '"Oswald", sans-serif', 'pt_sans' => '"PT Sans", sans-serif', 'pt_serif' => '"PT Serif", serif', 'raleway' => '"Raleway", sans-serif', 'roboto_condensed' => '"Roboto Condensed", sans-serif', 'ubuntu' => '"Ubuntu", sans-serif', 'yanone_kaffeesatz' => '"Yanone Kaffeesatz", sans-serif');
	if (isset($options['font_size']) && $options['font_size'] != '14' || isset($options['font_heading']) && $options['font_heading'] != 'open_sans' || isset($options['font_body']) && $options['font_body'] != 'open_sans' || $options['color_bg_header'] || $options['color_bg_inner'] || $options['color_1'] || $options['color_2'] || $options['color_3'] || $options['color_text_general'] || $options['color_text_second'] || $options['color_text_meta'] || $options['color_links'] || $options['custom_css']) : ?>   
    <style type="text/css">
    	<?php if ($options['font_size'] && $options['font_size'] != '14') { ?>
    		.entry { font-size: <?php echo $options['font_size']; ?>px; font-size: <?php echo $options['font_size'] / 16; ?>rem; }
    	<?php } ?>
    	<?php if (isset($options['font_heading']) && $options['font_heading'] != 'open_sans') { ?>
			h1, h2, h3, h4, h5, h6 { font-family: <?php echo $font_css[$options['font_heading']]; ?>; }
		<?php } ?>
		<?php if (isset($options['font_body']) && $options['font_body'] != 'open_sans') { ?>
			body { font-family: <?php echo $font_css[$options['font_body']]; ?>; }	
		<?php } ?>
    	<?php if ($options['color_bg_header']) { ?>	
    		.header-wrap { background: <?php echo $options['color_bg_header']; ?> }
    	<?php } ?>
    	<?php if ($options['color_bg_inner']) { ?>	
    		.wrapper { background: <?php echo $options['color_bg_inner']; ?> }
    	<?php } ?>
    	<?php if ($options['color_1']) { ?>
    		.main-nav, 
    		.header-nav .menu .menu-item:hover > .sub-menu,
    		.main-nav .menu .menu-item:hover > .sub-menu, 
    		.footer-nav .menu-item:hover,
    		.slide-caption,
    		.spotlight,
    		#carousel,
    		footer,
    		.loop-layout2 .meta,
    		#commentform input#submit:hover,
    		#cancel-comment-reply-link:hover,
    		.wpcf7-submit:hover { background: <?php echo $options['color_1']; ?> }
    	<?php } ?>
    	<?php if ($options['color_2']) { ?>
    		.logo-desc,
    		.selector-title,
    		.header-nav .menu-item:hover,
    		.main-nav li:hover,
    		.footer-nav,
    		.footer-nav .menu .menu-item:hover > .sub-menu,
    		.sl-caption,
    		.subheading,
    		.page-title-layout1,
    		.wt-layout2 .widget-title,
    		.wt-layout2 .footer-widget-title,
    		.caption,
    		.page-numbers:hover,
    		.current,
    		.pagelink,
    		a:hover .pagelink,
    		#commentform input#submit,
    		#cancel-comment-reply-link,
    		.wpcf7-submit,
    		.post-tags li:hover,
    		.tagcloud a:hover { background: <?php echo $options['color_2']; ?>; }
    		.slide-caption,
    		.xt-mobile .slide-caption,
    		#carousel,
    		.wt-layout1 .widget-title, 
    		.wt-layout1 .footer-widget-title,
    		.wt-layout3 .widget-title, 
    		.wt-layout3 .footer-widget-title,
    		.author-box,
    		.cat-desc,
    		#author:hover,
    		#email:hover,
    		#url:hover,
    		#comment:hover,
    		blockquote { border-color: <?php echo $options['color_2']; ?>; }
    		a:hover,
    		.entry a:hover,
    		.slide-title:hover, 
    		.sl-title:hover,
    		.related-title:hover,
    		.dropcap { color: <?php echo $options['color_2']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_3']) { ?>	
    		.news-selector,
    		#searchform,
    		.author-box,
    		.cat-desc,
    		.post-nav-wrap,
    		#wp-calendar caption,
    		.no-comments,
    		#respond,
    		.wpcf7-form { background: <?php echo $options['color_3']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_general']) { ?>	
    		body { color: <?php echo $options['color_text_general']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_second']) { ?>
    		.logo-desc,
    		.header-nav .menu-item:hover a, 
    		.header-nav .sub-menu a,
    		.main-nav li a,
    		.footer-nav .menu-item:hover a, 
    		.footer-nav .sub-menu a,
    		.selector-title,	
    		.subheading,
    		.page-title,
    		footer,
    		.sl-title,
    		.sl-caption,
    		.slide-caption,
    		.caption { color: <?php echo $options['color_text_second']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_meta']) { ?>
    		.meta, .breadcrumb { color: <?php echo $options['color_text_meta']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_links']) { ?>
    		a, .entry a { color: <?php echo $options['color_links']; ?>; }
    	<?php } ?>
    	<?php if ($options['custom_css']) {	echo $options['custom_css']; } ?>
	</style> 
    <?php
	endif;
}
add_action('wp_head', 'xt_custom_css');

?>