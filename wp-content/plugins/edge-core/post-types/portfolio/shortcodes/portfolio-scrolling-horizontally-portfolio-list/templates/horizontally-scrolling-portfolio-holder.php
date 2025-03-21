<div class="edgt-horizontally-scrolling-portfolio-list-holder">
    <?php echo edgt_core_get_shortcode_module_template_part('portfolio-scrolling-horizontally-portfolio-list/templates/parts/cover-image',
        'portfolio', '', $cover_image_params); ?>
	<div class="edgt-hspl-images-holder">
		<div class="edgt-hspl-images-row">
			<?php
				if($query_results->have_posts()):
					$i = 1;
					while ( $query_results->have_posts() ) : $query_results->the_post(); ?>
						<article class="edgt-hspl-item">
							<a href="<?php the_permalink() ?>" >
								<?php the_post_thumbnail('full'); ?>
								<div class="edgt-hspl-text-holder">
									<div class="edgt-hspl-text-wrapper">
										<div class="edgt-hspl-text">
											<h4 class="edgt-hspl-title"> <?php echo esc_attr(get_the_title()); ?> </h4>
											<?php echo edgt_core_get_shortcode_module_template_part('portfolio-scrolling-horizontally-portfolio-list/templates/parts/category', 'portfolio', '', array('enable_category' => 'no')); ?>
										</div>
									</div>
								</div>
							</a>
						</article>
					<?php
						if($i % $number_of_items_per_row == 0){ ?>
								</div><div class="edgt-hspl-images-row">
						<?php }

						$i++; endwhile;
				else:
					echo edgt_core_get_shortcode_module_template_part('portfolio-scrolling-horizontally-portfolio-list/templates/parts/posts-not-found', 'portfolio');
				endif;
				wp_reset_postdata();
			?>
		</div>
	</div>
</div>