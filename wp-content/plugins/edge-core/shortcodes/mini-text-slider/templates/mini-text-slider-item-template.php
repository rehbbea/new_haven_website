<div class="edgt-mts-item">
	<div class="edgt-mts-item-inner">
		<?php if (!empty($title)) { ?>
			<h2> <?php echo esc_html($title); ?></h2>
			<?php echo do_shortcode('[edgt_separator position="left" width="73" thickness="2"]');
		} ?>
		<?php if (!empty($subtitle)) { ?>
			<h4> <?php echo esc_html($subtitle); ?></h4>
		<?php } ?>
		<?php if (!empty($text)) { ?>
			<p> <?php echo esc_html($text); ?></p>
		<?php } ?>
	</div>
</div>