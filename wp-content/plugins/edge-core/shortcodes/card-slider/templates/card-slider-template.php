<div <?php eldritch_edge_class_attribute($holder_classes); ?> <?php eldritch_edge_inline_style($styles); ?>>
	<div class="edgt-card-slider <?php echo esc_attr($slider_classes); ?>" <?php echo eldritch_edge_get_inline_attrs($data_attrs); ?>>
		<?php echo do_shortcode($content); ?>
	</div>
</div>