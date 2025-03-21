<div <?php eldritch_edge_class_attribute($table_classes); ?>>
	<?php if ($featured_package == 'yes') { ?>
		<div class="edgt-featured-comparision-package"><?php esc_html_e('Featured package', 'edge-core'); ?></div>
	<?php } ?>
	<div class="edgt-cpt-table-holder-inner">
		<?php if ($display_border) : ?>
			<div class="edgt-cpt-table-border-top" <?php eldritch_edge_inline_style($border_style); ?>></div>
		<?php endif; ?>

		<div class="edgt-cpt-table-head-holder">
			<div class="edgt-cpt-table-head-holder-inner">
				<?php if ($title !== '') : ?>
					<h3 class="edgt-cpt-table-title"><?php echo esc_html($title); ?></h3>
				<?php endif; ?>

				<?php if ($price !== '') : ?>
					<div class="edgt-cpt-table-price-holder">
						<?php if ($currency !== '') : ?>
						<span class="edgt-cpt-table-currency"><?php echo esc_html($currency); ?></span><!--
						<?php else: ?>
							<!--
						<?php endif; ?>

						 --><span class="edgt-cpt-table-price"><?php echo esc_html($price); ?></span>

						<?php if ($price_period !== '') : ?>
							<span class="edgt-cpt-table-period">
								/ <?php echo esc_html($price_period); ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="edgt-cpt-table-content">
			<?php echo do_shortcode(preg_replace('#^<\/p>|<p>$#', '', $content)); ?>
		</div>
		<?php if($show_button == 'yes') { ?>
			<div class="edgt-cpt-table-footer">
				<?php echo eldritch_edge_get_button_html($button_parameters); ?>
			</div>
		<?php } ?>
	</div>
</div>