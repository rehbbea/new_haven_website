<div <?php eldritch_edge_inline_style($holder_styles); ?> <?php eldritch_edge_class_attribute($holder_classes); ?>>
	<div class="edgt-icon-list-icon-holder">
		<div class="edgt-icon-list-icon-holder-inner clearfix">
			<?php echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, $params);
			?>
		</div>
	</div>
	<p class="edgt-icon-list-text" <?php eldritch_edge_inline_style($title_subtitle_style); ?>>
		<span class="edgt-icon-list-title"  <?php echo eldritch_edge_get_inline_style($title_style) ?>>
			<?php echo esc_attr($title) ?>
		</span>
		<span class="edgt-icon-list-subtitle">
			<?php echo esc_attr($subtitle) ?>
		</span>
	</p>
</div>