<div <?php eldritch_edge_class_attribute($item_classes); ?>>
	<div class="edgt-pi-holder-inner  clearfix">
		<div class="edgt-pi-holder">
			<?php if (!empty($image)) : ?>
				<div class="edgt-pi">
					<div class="edgt-pi-inner">
						<?php echo wp_get_attachment_image($image, 'full'); ?>
					</div>
				</div>
			<?php else: ?>
				<div class="edgt-pi icon" <?php eldritch_edge_inline_style($icon_styles)?>>
					<?php echo edge_core_get_core_shortcode_template_part('templates/icon', 'process', '', array('icon_parameters' => $icon_parameters)); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="edgt-pi-content-holder">
			<?php if (!empty($title)) : ?>
				<div class="edgt-pi-title-holder">
					<h3 class="edgt-pi-title"><?php echo esc_html($title); ?></h3>
				</div>
			<?php endif; ?>

			<?php if (!empty($text)) : ?>
				<div class="edgt-pi-text-holder">
					<p><?php echo esc_html($text); ?></p>
				</div>
			<?php endif; ?>

			<?php
			if (!empty($link) && !empty($link_text)) :
				echo eldritch_edge_get_button_html($button_parameters);
			endif;
			?>
		</div>
	</div>
</div>