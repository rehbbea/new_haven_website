<div <?php post_class('edgt-blog-list-item clearfix'); ?>>
	<div class="edgt-blog-list-item-inner">
		<div class="edgt-item-image clearfix">
			<a href="<?php echo esc_url(get_permalink()) ?>">
				<?php the_post_thumbnail('thumbnail'); ?>
			</a>
		</div>
		<div class="edgt-item-text-holder">
			<h5 class="edgt-item-title">
			<a href="<?php echo esc_url(get_permalink()) ?>">
				<?php echo esc_attr(get_the_title()) ?>
			</a>
		</h5>

		<?php if ($text_length != '0') {
			$excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt(); ?>
			<p class="edgt-excerpt"><?php echo esc_html($excerpt) ?></p>
		<?php } ?>
		<div class="edgt-item-date">
			<span><?php the_time(get_option('date_format')); ?></span>
		</div>
	</div>
	</div>
</div>
