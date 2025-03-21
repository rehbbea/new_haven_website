<div <?php eldritch_edge_class_attribute($elements_holder_item_class)?> <?php echo eldritch_edge_get_inline_attrs($elements_holder_item_data); ?> <?php eldritch_edge_inline_style($elements_holder_item_style) ?>>
	<div class="edgt-elements-holder-item-inner">
		<div
			class="edgt-elements-holder-item-content <?php echo esc_attr($elements_holder_item_content_class); ?>" <?php eldritch_edge_inline_style($elements_holder_item_content_style);?>>
			<div class="edgt-elements-holder-item-content-inner">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>
	</div>
</div>