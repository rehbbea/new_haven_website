<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="edgt-post-content">
		<?php eldritch_edge_get_module_template_part('templates/single/parts/image', 'blog'); ?>
		<div class="edgt-post-text">
			<div class="edgt-post-text-inner clearfix">
				<?php eldritch_edge_get_module_template_part('templates/single/parts/title', 'blog'); ?>
				<div class="edgt-post-info">
					<?php eldritch_edge_post_info(array('date' => 'yes')) ?>
					<div class="edgt-post-info-category">
						<?php the_category('/ '); ?>
					</div>
				</div>
				<?php the_content(); ?>
			</div>
		</div>
		<div class="edgt-tags-share-holder clearfix">
			<?php do_action('eldritch_edge_before_blog_article_closed_tag'); ?>
			<div class="edgt-share-icons-single">
				<?php $post_info_array['share'] = eldritch_edge_options()->getOptionValue('enable_social_share') == 'yes'; ?>
				<?php if (eldritch_edge_core_installed() && $post_info_array['share'] == 'yes'): ?>
					<span class="edgt-share-label"><?php esc_html_e('Share', 'eldritch'); ?></span>
				<?php endif; ?>
				<?php if ( eldritch_edge_core_installed() ) { ?>
                    <?php echo eldritch_edge_get_social_share_html(array(
                        'type'      => 'list',
                        'icon_type' => 'normal'
                    )); ?>
                <?php } ?>
			</div>
		</div>
	</div>
</article>