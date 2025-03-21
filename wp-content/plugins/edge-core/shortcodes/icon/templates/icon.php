<?php if($icon_animation_holder) : ?>
<span class="edgt-icon-animation-holder" <?php eldritch_edge_inline_style($icon_animation_holder_styles); ?>>
<?php endif; ?>

	<span <?php eldritch_edge_class_attribute($icon_holder_classes); ?> <?php eldritch_edge_inline_style($icon_holder_styles); ?> <?php echo eldritch_edge_get_inline_attrs($icon_holder_data); ?>>
        <?php if($link !== '') : ?>
		<a <?php if($anchor_icon == 'yes'){ echo 'class="edgt-anchor"';}?> href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
			<?php endif; ?>

			<?php echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, $icon_params); ?>

			<?php if($link !== '') : ?>
		</a>
	<?php endif; ?>
    </span>

	<?php if($icon_animation_holder) : ?>
    </span>
<?php endif; ?>
