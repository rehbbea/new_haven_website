<div class="edgt-pie-chart-with-icon-holder" <?php echo eldritch_edge_get_inline_attrs($data_attr); ?>>
	<div class="edgt-percentage-with-icon" <?php echo eldritch_edge_get_inline_attrs($pie_chart_data); ?>>
		<?php echo eldritch_edge_get_module_part($icon); ?>
	</div>
	<div class="edgt-pie-chart-text" <?php eldritch_edge_inline_style($pie_chart_style)?>>
		<<?php echo esc_html($title_tag)?> class="edgt-pie-title">
			<?php echo esc_html($title); ?>
		</<?php echo esc_html($title_tag)?>>
		<p><?php echo esc_html($text); ?></p>
	</div>
</div>