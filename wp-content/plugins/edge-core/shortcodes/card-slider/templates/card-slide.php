<div class="edgt-card-slide">
	<div class="edgt-card-slide-inner">
		<?php if ($custom_icon !== '') { ?>
			<div class="edgt-card-image" <?php echo eldritch_edge_get_inline_style($custom_icon_inline)?>>
				<?php if (!empty($link)) :
					echo "<a href='" . $link . "'>";
				endif;
				?>
				<?php echo wp_get_attachment_image($custom_icon, 'full'); ?>
				<?php if (!empty($link)) :
					echo "</a>";
				endif;
				?>
			</div>
		<?php } else if ($icon_parameters['icon_pack']) { ?>
			<div class="edgt-icon-holder">
				<?php echo edge_core_get_core_shortcode_template_part('templates/icon', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
			</div>
		<?php } ?>
		<div class="edgt-card-content" <?php echo eldritch_edge_get_inline_style($content_style)?>>
			<?php if ($title !== '') :
			if (!empty($link)) :
				echo "<a href='" . $link . "'>";
			endif;
			?>
			<<?php echo esc_html($title_tag); ?>
			class="edgt-card-title" <?php eldritch_edge_inline_style($title_inline_styles); ?>>
			<?php echo esc_html($title); ?>
		</<?php echo esc_html($title_tag); ?>>
				<?php if (!empty($link)) :
		echo "</a>";
	endif;

	echo do_shortcode('[edgt_separator position="center" width="30" thickness="2" color="'.$separator_color.'"]');
	?>
	<?php endif; ?>
		<?php if ($subtitle !== ''): ?>
			<p class="edgt-card-subtitle">
				<?php echo esc_html($subtitle); ?>
			</p>
		<?php endif; ?>
		<?php if ($text !== ''): ?>
			<p class="edgt-card-text">
				<?php echo esc_html($text); ?>
			</p>
		<?php endif; ?>
		<?php
		if (!empty($link) && !empty($link_text)) :
			echo eldritch_edge_get_button_html($button_parameters);
		endif;
		?>
	</div>
</div>
</div>