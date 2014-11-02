<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url()); ?>/">
    <fieldset>
	<input type="text" value="<?php _e('To search, type and hit enter', 'xt'); ?>" onfocus="if (this.value == '<?php _e('To search, type and hit enter', 'xt'); ?>') this.value = ''" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="" />
    </fieldset>
</form>