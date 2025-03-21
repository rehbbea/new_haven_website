<?php
/**
 * Dropcaps shortcode template
 */
?>

<span class="edgt-dropcaps <?php echo esc_attr($dropcaps_class); ?>" <?php eldritch_edge_inline_style($dropcaps_style); ?>>
	<?php echo esc_html($letter); ?>
</span>