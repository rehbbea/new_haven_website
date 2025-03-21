<?php
/**
 * Blockquote shortcode template
 */
?>

<blockquote class="edgt-blockquote-shortcode" <?php eldritch_edge_inline_style($blockquote_style); ?> >
	<h5 class="edgt-blockquote-text">
		<span><?php echo esc_attr($text); ?></span>
	</h5>
</blockquote>