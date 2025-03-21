<article <?php echo edgt_core_get_class_attribute($item_classes); ?>>
	<div class="edgt-portfolio-masonry-item">
		<div class="edgt-ptf-wrapper">
			<a class="edgt-portfolio-link" <?php echo eldritch_edge_get_inline_attrs($link_atts); ?>></a>

			<div class="edgt-item-image-holder">
				<?php
				echo get_the_post_thumbnail(get_the_ID(), $thumb_size);
				?>
			</div>
			<div class="edgt-ptf-item-text-overlay" <?php eldritch_edge_inline_style($shader_styles); ?>>
				<div class="edgt-ptf-item-text-overlay-inner">
					<div class="edgt-ptf-item-text-holder">
						<<?php echo esc_attr($title_tag); ?> class="edgt-ptf-item-title">
						<a <?php echo eldritch_edge_get_inline_attrs($link_atts); ?>>
							<?php echo esc_attr(get_the_title()); ?>
						</a>
					</<?php echo esc_attr($title_tag); ?>>
					<?php if ($show_categories === 'yes') : ?>
						<?php if (!empty($category_html)) : ?>
							<?php echo eldritch_edge_get_module_part($category_html); ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="edgt-ptf-item-overlay-bg"></div>
		</div>
	</div>
	</div>
</article>
