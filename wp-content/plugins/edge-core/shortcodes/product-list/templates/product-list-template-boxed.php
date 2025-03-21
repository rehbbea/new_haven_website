<div <?php eldritch_edge_class_attribute($holder_classes); ?>>
	<div class="edgt-pl-outer clearfix">
		<?php if ($query_result->have_posts()): while ($query_result->have_posts()) :
			$query_result->the_post(); ?>
			<?php
			$product = eldritch_edge_return_woocommerce_global_variable();

			$rating_enabled = false;
			if ($show_rating == 'yes' && get_option('woocommerce_enable_review_rating') !== 'no') {
				$rating_enabled = true;
				$average = $product->get_average_rating();
			}
			?>
			<div class="edgt-pl-item">
				<div class="edgt-pl-item-inner"
					 style="background-color: <?php echo esc_attr($box_background_color);?>">
					<a class="edgt-product-thumbnail-link" href="<?php the_permalink(); ?>"
					   title="<?php the_title_attribute(); ?>">
						<div class="product-thumbnail">
							<?php echo get_the_post_thumbnail(get_the_ID(), 'shop_single'); ?>
						</div>
						<?php if (get_post_meta($product->get_id(), 'edgt_single_product_new_meta', true) === 'yes') : ?>
							<span class="edgt-new-product edgt-product-mark">
								<?php esc_html_e('NEW', 'edge-core'); ?>
							</span>
						<?php endif;?>
						<?php if (!$product->is_in_stock()) : ?>
							<span class="edgt-out-of-stock edgt-product-mark">
								<?php esc_html_e('SOLD OUT', 'edge-core'); ?>
							</span>
						<?php endif; ?>
						<?php if ($product->is_on_sale()) : ?>
							<span class="edgt-on-sale edgt-product-mark">
								<?php esc_html_e('SALE', 'edge-core'); ?>
							</span>
						<?php endif; ?>
					</a>

					<div class="add-to-cart-holder">
						<?php
						echo sprintf('<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" data-title="%s">%s</a>',
							esc_url($product->add_to_cart_url()),
							esc_attr(isset($quantity) ? $quantity : 1),
							esc_attr($product->get_id()),
							esc_attr($product->get_sku()),
							esc_attr('edgt-btn edgt-btn-small edgt-btn-solid add_to_cart_button ajax_add_to_cart'),
							esc_html($product->add_to_cart_text()),
							esc_html($product->add_to_cart_text())
						);
						?>
					</div>
					<div class="edgt-pl-content-holder">
						<div class="edgt-pl-content-holder-inner"
							 style="background-color: <?php echo esc_attr($box_background_color);?>">
							<<?php echo esc_html($title_tag); ?> class="product-title"><a href="<?php the_permalink(); ?>"
														 title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</<?php echo esc_html($title_tag); ?>>

							<div class="product-price">
								<?php echo eldritch_edge_get_module_part($product->get_price_html());?>
							</div>
							<?php if ($rating_enabled) { ?>
								<div class="edgt-pl-rating-holder">
									<div class="star-rating"
										 title="<?php printf(esc_attr__('Rated %s out of 5', 'edge-core'), $average); ?>">
										<span style="width:<?php echo(($average / 5) * 100); ?>%"></span>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile;
		else: ?>
			<div class="edgt-pl-messsage">
				<p><?php esc_html_e('No posts were found.', 'edge-core'); ?></p>
			</div>
		<?php endif;
		wp_reset_postdata();
		?>
	</div>
</div>