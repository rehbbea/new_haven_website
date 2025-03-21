<?php
/**
 * Custom Font shortcode template
 */
?>

<<?php echo esc_attr($custom_font_tag); ?> class="edgt-custom-font-holder" <?php eldritch_edge_inline_style($custom_font_style);
echo esc_attr($custom_font_data); ?>>
<?php echo esc_html($content_custom_font); ?>
</<?php echo esc_attr($custom_font_tag); ?>>