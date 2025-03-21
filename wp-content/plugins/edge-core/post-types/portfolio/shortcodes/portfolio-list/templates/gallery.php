<?php // This line is needed for mixItUp gutter ?>
	<article <?php echo edgt_core_get_class_attribute($item_classes); ?>>
		<div class="edgt-portfolio-gallery-item">
			<div class="edgt-ptf-wrapper">
				<a class="edgt-portfolio-link" <?php echo eldritch_edge_get_inline_attrs($link_atts); ?>></a>
				<div class="edgt-ptf-item-image-holder">
					<?php if ($use_custom_image_size && (is_array($custom_image_sizes) && count($custom_image_sizes))) : ?>
						<?php echo eldritch_edge_generate_thumbnail(get_post_thumbnail_id(get_the_ID()), null, $custom_image_sizes[0], $custom_image_sizes[1]); ?>
					<?php else: ?>
						<?php the_post_thumbnail($thumb_size); ?>
					<?php endif; ?>
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
				</div>
			</div>
		</div>
	</article>
<?php // This line is needed for mixItUp gutter ?>