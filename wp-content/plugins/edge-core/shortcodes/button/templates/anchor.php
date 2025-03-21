<a href="<?php echo esc_url($link); ?>"
   target="<?php echo esc_attr($target); ?>" <?php eldritch_edge_inline_style($button_styles); ?> <?php eldritch_edge_class_attribute($button_classes); ?> <?php echo eldritch_edge_get_inline_attrs($button_data); ?> <?php echo eldritch_edge_get_inline_attrs($button_custom_attrs); ?>>
	<span class="edgt-btn-text"><?php echo esc_html($text); ?></span>
	<?php if ($params['type'] === 'underline'): ?>
		<span
			class="edgt-btn-underline-line" <?php if (!empty($color)) echo 'style="background-color:' . $color . '"'; ?>></span>
	<?php endif; ?>

	<?php if ($show_icon) : ?>
		<span class="edgt-btn-icon-holder" <?php if (!empty($icon_styles)) echo 'style="'. $icon_styles.'"'; ?>>
			<?php echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, array(
				'icon_attributes' => array(
					'class' => 'edgt-btn-icon-elem'
				)
			)); ?>
		</span>
	<?php endif; ?>

	<?php if ($display_helper) : ?>
		<span class="edgt-btn-helper" <?php eldritch_edge_inline_style($helper_styles); ?>></span>
	<?php endif; ?>
</a>