<div class="edgt-carousel-item-holder">
	<?php if($link !== '') { ?>
	<a href="<?php echo esc_url($link) ?>" target="<?php echo esc_attr($target) ?>">
		<?php } ?>
		<?php if(!empty($image_id)) { ?>
			<span class="edgt-carousel-first-image-holder <?php echo esc_attr($hover_class); ?> <?php echo esc_attr($carousel_image_classes); ?>">
				<?php echo wp_get_attachment_image($image_id, 'full'); ?>
			</span>
		<?php } ?>
		<?php if(!empty($hover_image_id)) { ?>
			<span class="edgt-carousel-second-image-holder <?php echo esc_attr($hover_class); ?> <?php echo esc_attr($carousel_image_classes); ?>">
				<?php echo wp_get_attachment_image($hover_image_id, 'full'); ?>
			</span>
		<?php } ?>
		<?php if($link !== '') { ?>
	</a>
<?php } ?>
</div>