<?php if ($enable_title === 'yes') {
	$title_tag = !empty($title_tag) ? $title_tag : 'h4';
	$title_styles = $this_object->getTitleStyles($params);
	?>
	<div class="edgt-pli-title-holder">		
		<a itemprop="url" class="edgt-pli-title-link" href="<?php echo esc_url($item_link); ?>">
			<<?php echo esc_attr($title_tag); ?> itemprop="name" class="edgt-pli-title entry-title">
				<?php echo esc_attr(get_the_title()); ?>
			</<?php echo esc_attr($title_tag); ?>>
		</a>
	</div>
<?php } ?>