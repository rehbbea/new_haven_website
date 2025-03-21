<div class="edgt-testimonial-content">

	<?php if ($show_image === 'yes' && has_post_thumbnail()): ?>
		<div class="edgt-testimonial-author-image-quote">
			<div class="edgt-testimonial-author-image">
				<?php the_post_thumbnail(); ?>
			</div>
			<img class="edgt-quote-image" src="<?php echo EDGE_ASSETS_ROOT; ?>/img/quote.png" alt="<?php esc_attr_e('Quote image', 'edge-core'); ?>" <?php eldritch_edge_inline_style($quote_styles); ?>/>
		</div>
	<?php endif; ?>


	<div class="edgt-testimonial-content-inner">
		<div class="edgt-testimonial-text-holder">
			<div class="edgt-testimonial-text-inner <?php echo esc_attr($light_class); ?>">
                <h2 class="edgt-testimonial-title"><?php echo trim($title) ?></h2>
				<h5 class="edgt-testimonial-text"><?php echo trim($text) ?></h5>
				<?php if ($show_author == "yes") { ?>
					<div class="edgt-testimonial-author">
						<h4 class="edgt-testimonial-author-text <?php echo esc_attr($light_class); ?>">- <?php echo esc_attr($author) ?></h4>
						<?php if ($show_position == "yes" && $job !== '') { ?>
							<h6 class="edgt-testimonials-job <?php echo esc_attr($light_class); ?>"><?php echo esc_attr($job) ?></h6>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
