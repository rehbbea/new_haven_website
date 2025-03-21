<?php
/**
 * Counter shortcode template
 */
?>
<div <?php eldritch_edge_class_attribute($counter_classes); ?>>
	<span class="edgt-counter <?php echo esc_attr($type) ?>">
		<?php echo esc_attr($digit); ?>
	</span>

	<div class="edgt-counter-content">
        <?php if (!empty($title)) { ?>
		    <h3 class="edgt-counter-title"> <?php echo esc_attr($title); ?> </h3>
        <?php } ?>
		<?php if (!empty($text)) { ?>
			<p class="edgt-counter-text"><?php echo esc_html($text); ?></p>
		<?php } ?>
		<?php
		if (!empty($link) && !empty($link_text)) :
			echo eldritch_edge_get_button_html($button_parameters);
		endif;
		?>
	</div>
</div>