<?php
/**
 * Pie Chart Basic Shortcode Template
 */
?>
<div <?php eldritch_edge_class_attribute($holder_classes); ?> <?php echo eldritch_edge_get_inline_attrs($data_attr); ?>>

	<div class="edgt-percentage" <?php echo eldritch_edge_get_inline_attrs($pie_chart_data); ?>>
		<?php if ($type_of_central_text == "title") { ?>
			<<?php echo esc_attr($title_tag); ?> class="edgt-pie-title">
				<?php echo esc_html($title); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } else { ?>
			<span class="edgt-to-counter">
				<?php echo esc_html($percent); ?>
			</span>
		<?php } ?>
	</div>
	<div class="edgt-pie-chart-text" <?php eldritch_edge_inline_style($pie_chart_style); ?>>
		<?php if ($type_of_central_text == "title") { ?>
			<span class="edgt-to-counter">
				<?php echo esc_html($percent); ?>
			</span>
		<?php } else { ?>
			<<?php echo esc_attr($title_tag); ?> class="edgt-pie-title">
				<?php echo esc_html($title); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<p><?php echo esc_html($text); ?></p>
	</div>
</div>