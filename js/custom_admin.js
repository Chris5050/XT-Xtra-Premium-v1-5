jQuery(document).ready(function($){
	
	/***** Simply Countable plugin - character counter for any text input or textarea *****/
	
	$('#xt-seo-title').simplyCountable({
		counter: '#counter-1',
		maxCount: 70
	});	
	$('#xt-meta-desc').simplyCountable({
		counter: '#counter-2',
		maxCount: 160
	});
	
});