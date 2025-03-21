<li <?php eldritch_edge_class_attribute($class_name); ?>>
	<a class="edgt-share-link" href="#" onclick="<?php echo esc_attr($link); ?>">
		<?php if ($custom_icon !== '') : ?>
			<img src="<?php echo esc_url($custom_icon); ?>" alt="<?php echo esc_attr($name); ?>"/>

		<?php else : ?>
			<span class="edgt-social-network-icon <?php echo esc_attr($icon); ?>"></span>
		<?php endif; ?>

		<?php if ($type === 'dropdown') : ?>
			<span aria-hidden="true"
				  class="edgt-social-share-label"> <?php echo esc_html($label); ?> </span>
		<?php endif; ?>
	</a>
</li>