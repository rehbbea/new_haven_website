<div class="edgt-team-slide">
	<div class="edgt-team-slide-inner">
		<?php if ($team_member_image !== '') { ?>
			<div class="edgt-member-image">
				<?php echo wp_get_attachment_image($team_member_image, 'full'); ?>
			</div>
		<?php } ?>
		<div class="edgt-team-info">
			<div class="edgt-team-info-tb">
				<div class="edgt-team-info-tc">
					<?php if ($name !== '' || $position !== '') { ?>
						<div class="edgt-team-title-holder">
							<?php if ($name !== '') { ?>
								<h3 class="edgt-name"><?php echo esc_attr($name); ?></h3>
							<?php } ?>
							<?php if ($position !== "") { ?>
								<h6 class="edgt-position"><?php echo esc_attr($position) ?></h6>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ($text !== '') { ?>
						<div class="edgt-text">
							<?php echo esc_html($text); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>