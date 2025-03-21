<?php if (!empty($video_link)) : ?>
	<div class="edgt-video-banner-holder">
		<a class="edgt-video-banner-link" href="<?php echo esc_url($video_link); ?>"
		   data-rel="prettyPhoto[<?php echo esc_attr($banner_id); ?>]">
			<?php if (!empty($video_banner)) : ?>
				<?php echo wp_get_attachment_image($video_banner, 'full'); ?>
			<?php endif; ?>
			<div class="edgt-video-banner-overlay">
				<div class="edgt-vb-overlay-tb">
					<div class="edgt-vb-overlay-tc">
						<span class="edgt-vb-play-icon">
						<?php echo eldritch_edge_icon_collections()->renderIcon('fa-play', 'font_awesome'); ?>
						</span>
					</div>
				</div>
			</div>
		</a>
	</div>
<?php endif; ?>