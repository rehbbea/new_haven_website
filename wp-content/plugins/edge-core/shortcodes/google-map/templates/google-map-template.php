<div class="edgt-google-map-holder">
	<div class="edgt-google-map" id="<?php echo esc_attr($map_id); ?>" <?php echo eldritch_edge_get_module_part($map_data); ?>></div>
	<?php if($scroll_wheel == "false") { ?>
		<div class="edgt-google-map-overlay"></div>
	<?php } ?>
</div>
