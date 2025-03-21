<div class="edgt-image-gallery">
	<div class="edgt-image-gallery-slider" <?php echo eldritch_edge_get_inline_attrs($slider_data); ?>>
		<?php foreach ($images as $image) { ?>
			<div class="edgt-image-gallery-item">
				<?php if ($pretty_photo) { ?>
				<a href="<?php echo esc_url($image['url']) ?>" data-rel="prettyPhoto[single_pretty_photo]"
				   title="<?php echo esc_attr($image['title']); ?>">
					<?php } ?>
					<?php
					$attachment = get_post($image['image_id']);
					?>
					<?php if (is_array($image_size) && count($image_size)) : ?>
						<?php echo eldritch_edge_generate_thumbnail($image['image_id'], null, $image_size[0], $image_size[1]); ?>
					<?php else: ?>
						<?php echo wp_get_attachment_image($image['image_id'], $image_size); ?>
					<?php endif; ?>
					<?php if ($pretty_photo) { ?>
				</a>
			<?php } ?>
				<?php if ($show_title_desc === 'yes'): ?>
					<div class="edgt-title-description">
						<div class="edgt-title-description-inner">
							<div class="edgt-image-gallery-title-holder clearfix">
								<h2 class="edgt-image-gallery-title">
									<?php
									echo esc_html($attachment->post_title);
									?>
								</h2>
							</div>
							<div class="edgt-image-gallery-description-holder clearfix">
								<p class="edgt-image-gallery-description">
									<?php
									echo esc_html($attachment->post_content);
									?>
								</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php } ?>
	</div>
</div>