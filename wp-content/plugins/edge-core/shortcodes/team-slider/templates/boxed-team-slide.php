<div class="edgt-team-slide">
	<div class="edgt-team-slide-inner">
		<div class="edgt-logo-text">
			<?php if ($logo_image !== ''): ?>
				<div class="edgt-logo-image">
					<?php echo wp_get_attachment_image($logo_image, 'full'); ?>
				</div>
			<?php endif; ?>
			<?php if ($text !== ''): ?>
				<div class="edgt-text">
					<?php echo esc_html($text); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="edgt-team-member-info">
			<?php if ($team_member_image !== ''): ?>
				<div class="edgt-member-image">
					<?php echo wp_get_attachment_image($team_member_image, 'full'); ?>
				</div>
			<?php endif; ?>
			<?php if ($name !== ''): ?>
				<h5 class="edgt-name">
					<?php echo esc_html($name); ?>
				</h5>
			<?php endif; ?>
			<?php if ($position !== ''): ?>
				<div class="edgt-position">
					<?php echo esc_html($position); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>