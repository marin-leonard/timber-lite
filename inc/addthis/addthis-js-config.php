<?php
global $post;
if ( empty($post) ) return; ?>
<script type="text/javascript">
addthis_config = {
	<?php if (timber_get_option('share_buttons_enable_tracking') && timber_get_option('share_buttons_enable_addthis_tracking')):
	echo 'username : "'.timber_get_option('share_buttons_addthis_username').'",';
	endif; ?>
	ui_click : false,
	ui_delay : 100,
	ui_offset_top: 16,
	ui_offset_left: -12,
	ui_use_css : true,
	data_track_addressbar : false,
	data_track_clickback : false
	<?php if (timber_get_option('share_buttons_enable_tracking') && timber_get_option('share_buttons_enable_ga_tracking')):
		echo ', data_ga_property: "'.timber_get_option('share_buttons_ga_id').'"';
		if (timber_get_option('share_buttons_enable_ga_social_tracking')):
			echo ', data_ga_social : true';
		endif;
	endif; ?>
	};

addthis_share = {
	url : "<?php echo wpgrade_get_current_canonical_url(); ?>",
	title : "<?php wp_title('|', true, 'right'); ?>",
	description : "<?php echo trim(strip_tags(get_the_excerpt())) ?>"
};
</script>