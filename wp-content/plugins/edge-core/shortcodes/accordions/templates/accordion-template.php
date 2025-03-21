<h4 class="clearfix edgt-title-holder">
<span class="edgt-accordion-mark edgt-left-mark">
		<span class="edgt-accordion-mark-icon">
			<span class="icon_plus"></span>
			<span class="icon_minus-06"></span>
		</span>
</span>
<span class="edgt-tab-title">
	<?php if ($params['icon']) : ?>
		<span class="edgt-icon-accordion-holder">
				 <?php echo eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack); ?>
		</span>
	<?php endif; ?>
	<span class="edgt-tab-title-inner">
		<?php echo esc_attr($title) ?>
	</span>
</span>
</h4>
<div class="edgt-accordion-content">
	<div class="edgt-accordion-content-inner">
		<?php echo do_shortcode($content) ?>

		<?php if (is_array($link_params) && count($link_params)) : ?>
			<a class="edgt-arrow-link" target="<?php echo esc_attr($link_params['link_target']); ?>"
			   href="<?php echo esc_url($link_params['link']); ?>">
				<span class="edgt-al-icon">
					<span class="icon-arrow-right-circle"></span>
				</span>
				<span class="edgt-al-text"><?php echo esc_html($link_params['link_text']); ?></span>
			</a>
		<?php endif; ?>
	</div>
</div>
