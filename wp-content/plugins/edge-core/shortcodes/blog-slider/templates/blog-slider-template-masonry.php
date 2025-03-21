<div <?php eldritch_edge_class_attribute($holder_classes); ?> <?php echo eldritch_edge_get_inline_attrs($holder_data); ?>>
	<?php if ($query->have_posts()) : ?>
		<?php while ($query->have_posts()) :
			$query->the_post();

			eldritch_edge_get_post_format_html('masonry-slider');

		endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p><?php esc_html_e('No posts were found.', 'edge-core'); ?></p>
	<?php endif; ?>
</div>