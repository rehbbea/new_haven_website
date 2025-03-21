<?php $excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt(); ?>

<div class="edgt-blog-list-item">
	<div class="edgt-categories-list">
		<?php eldritch_edge_get_module_template_part('templates/parts/post-info-category', 'blog'); ?>
	</div>
	<h3 class="edgt-blog-list-title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>
	<?php if ($text_length != '0') : ?>
		<p class="edgt-bl-item-excerpt"><?php echo esc_html($excerpt) ?></p>
	<?php endif; ?>
	<div class="edgt-avatar-date-author">
		<div class="edgt-avatar">
			<a href="<?php echo esc_url(eldritch_edge_get_author_posts_url()); ?>">
				<?php echo eldritch_edge_kses_img(get_avatar(get_the_author_meta('ID'), 75)); ?>
			</a>
		</div>
		<div class="edgt-date-author">
			<div class="edgt-date">
				<span><?php the_time(get_option('date_format')); ?></span>
			</div>
			<div class="edgt-author">
				<?php echo '<span>'.esc_html__('by', 'edge-core').' </span>';?>
				<a href="<?php echo esc_url(eldritch_edge_get_author_posts_url()); ?>">
					<?php echo eldritch_edge_get_the_author_name(); ?>
				</a>
			</div>
		</div>
	</div>
</div>