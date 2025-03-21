<div <?php eldritch_edge_class_attribute($holder_classes) ?>>
	<?php if ($link != '') { ?>
		<a href="<?php echo esc_url($link) ?>" target="<?php echo esc_attr($link_target) ?>"></a>
	<?php } ?>
	<div class="edgt-image-holder">
		<?php echo wp_get_attachment_image($image, 'full'); ?>
	</div>
	<div class="edgt-text-holder" <?php eldritch_edge_inline_style($text_style); ?>>
		<div class="edgt-text-holder-table">
			<div class="edgt-text-holder-cell">
				<h3 class="edgt-iwt-text">
					<?php echo esc_html($text); ?>
				</h3>
			</div>
		</div>
	</div>
</div>