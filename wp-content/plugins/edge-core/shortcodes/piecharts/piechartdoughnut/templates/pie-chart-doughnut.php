<div class="edgt-pie-chart-doughnut-holder">
	<div class="edgt-pie-chart-doughnut">
		<canvas id="pie<?php echo esc_attr($id); ?>" class="edgt-doughnut" height="<?php echo esc_attr($height); ?>" width="<?php echo esc_attr($width); ?>" <?php echo eldritch_edge_get_inline_attrs($pie_chart_data)?>></canvas>
	</div>
	<div class="edgt-pie-legend">
		<ul>
			<?php foreach ($legend_data as $legend_data_item) { ?>
			<li>
				<div class="edgt-pie-color-holder" <?php eldritch_edge_inline_style($legend_data_item['color'])?> ></div>
				<p><?php echo esc_html($legend_data_item['legend']); ?></p>
			<?php } ?>
			</li>
		</ul>
	</div>
</div>