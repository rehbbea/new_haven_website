<div class="edgt-message  <?php echo esc_attr($message_classes) ?>" <?php echo eldritch_edge_get_inline_style($message_styles) ?>>
	<div class="edgt-message-inner">
		<?php
		if($type == 'with_icon') {
			$icon_html = edge_core_get_core_shortcode_template_part('templates/'.$type, 'message', '', $params);
			echo eldritch_edge_get_module_part($icon_html);
		}
		?>
		<a href="#" class="edgt-close">
			<i class="q_font_elegant_icon icon_close" <?php eldritch_edge_inline_style($close_icon_style); ?>></i>
		</a>

		<div class="edgt-message-text-holder">
			<div class="edgt-message-text">
				<p class="edgt-message-text-inner">
					<?php echo eldritch_edge_remove_auto_ptag($content, true) ?>
				</p>
			</div>
		</div>
	</div>
</div>
