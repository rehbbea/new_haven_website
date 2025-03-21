<div class="edgt-team-slide">
	<div class="edgt-team-slide-inner">
		<?php if ($team_member_image !== ''): ?>
			<div class="edgt-member-image">
				<?php echo wp_get_attachment_image($team_member_image, 'full'); ?>
			</div>
		<?php endif; ?>
		<div class="edgt-content">
			<?php if ($name !== ''): ?>
				<h3 class="edgt-name">
					<?php echo esc_html($name); ?>
				</h3>
			<?php endif; ?>
			<?php if ($position !== ''): ?>
				<div class="edgt-position">
					<?php echo esc_html($position); ?>
				</div>
			<?php endif; ?>
			<?php if ($text !== ''): ?>
				<div class="edgt-text">
					<?php echo esc_html($text); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>