<button type="submit" <?php eldritch_edge_inline_style($button_styles); ?> <?php eldritch_edge_class_attribute($button_classes); ?> <?php echo eldritch_edge_get_inline_attrs($button_data); ?> <?php echo eldritch_edge_get_inline_attrs($button_custom_attrs); ?>>
	<span class="edgt-btn-text"><?php echo esc_html($text); ?></span>

	<?php if($show_icon) : ?>
		<span class="edgt-btn-icon-holder">
			<?php  echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, array(
				'icon_attributes' => array(
					'class' => 'edgt-btn-icon-elem'
				)
			)); ?>
		</span>
	<?php endif; ?>

	<?php if($display_helper) : ?>
		<span class="edgt-btn-helper" <?php eldritch_edge_inline_style($helper_styles); ?>></span>
	<?php endif; ?>

</button>