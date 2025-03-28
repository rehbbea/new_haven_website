<div <?php eldritch_edge_class_attribute($holder_classes); ?> <?php eldritch_edge_inline_style($element_styles); ?> <?php echo eldritch_edge_get_inline_attrs($holder_data); ?>>
    <?php if ($link !== '') { ?>
        <a class="edgt-iwt-icon-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
    <?php } ?>
    <div class="edgt-iwt-icon-holder">
		<?php if (!empty($custom_icon)) : ?>
			<span
				class="edgt-iwt-custom-icon" <?php eldritch_edge_inline_style($custom_icon_styles); ?>><?php echo wp_get_attachment_image($custom_icon, 'full'); ?></span>
		<?php else: ?>
			<?php echo edge_core_get_core_shortcode_template_part('templates/icon', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
		<?php endif; ?>
	</div>
    <?php if ($link !== '') { ?>
        </a>
    <?php } ?>
	<div class="edgt-iwt-content-holder" <?php eldritch_edge_inline_style($content_styles); ?>>
		<?php if ($title != ''){ ?>
        <?php if ($link !== '') { ?>
        <a class="edgt-iwt-title-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
            <?php } ?>
		<div class="edgt-iwt-title-holder">
			<<?php echo esc_attr($title_tag); ?>
			class="edgt-iwt-title" <?php eldritch_edge_inline_style($title_styles); ?>
			><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
        </div>
        <?php if ($link !== '') { ?>
        </a>
        <?php } ?>
	<?php } ?>
	<div class="edgt-iwt-text-holder">
        <?php if ($text != '') { ?>
		    <p <?php eldritch_edge_inline_style($text_styles); ?>><?php echo esc_html($text); ?></p>
        <?php } ?>

		<?php
		if (!empty($link) && !empty($link_text)) :
			echo eldritch_edge_get_button_html($button_parameters);
		endif;
		?>
	</div>
</div>
</div>