<?php if(is_array($features) && count($features)) : ?>
	<div <?php eldritch_edge_class_attribute($holder_classes); ?>>
		<div class="edgt-cpt-features-holder edgt-cpt-table">
			<div class="edgt-cpt-features-title-holder edgt-cpt-table-head-holder">
				<div class="edgt-cpt-table-head-holder-inner">
					<h3 class="edgt-cpt-features-title"><?php echo wp_kses_post(preg_replace('#^<\/p>|<p>$#', '', $title)); ?></h3>
				</div>
			</div>
			<div class="edgt-cpt-features-list-holder edgt-cpt-table-content">
				<ul class="edgt-cpt-features-list">
					<?php foreach($features as $feature) : ?>
						<li class="edgt-cpt-features-item"><h6><?php echo esc_html($feature); ?></h6></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php echo do_shortcode($content); ?>
	</div>
<?php endif; ?>