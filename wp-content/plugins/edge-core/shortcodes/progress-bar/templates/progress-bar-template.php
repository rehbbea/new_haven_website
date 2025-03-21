<div class="edgt-progress-bar">
    <h6 class="edgt-progress-title-holder clearfix">
        <span class="edgt-progress-title" <?php eldritch_edge_inline_style($title_color); ?>><?php echo esc_attr($title) ?></span>
		<span class="edgt-progress-number-wrapper <?php echo esc_attr($percentage_classes) ?> ">
			<span class="edgt-progress-number">
				<span class="edgt-percent" <?php eldritch_edge_inline_style($percentage_color); ?>>0</span>
			</span>
		</span>
    </h6>

    <div class="edgt-progress-content-outer" <?php eldritch_edge_inline_style($inactive_bar_style); ?>>
        <div data-percentage=<?php echo esc_attr($percent) ?> class="edgt-progress-content <?php echo esc_attr($bar_class); ?>" <?php eldritch_edge_inline_style($bar_styles); ?>></div>
    </div>
</div>	