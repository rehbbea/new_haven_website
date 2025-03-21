<?php
/**
 * Team simple shortcode template
 */
global $eldritch_IconCollections;
$number_of_social_icons = 5;
?>

<div class="edgt-team">
	<div class="edgt-team-inner">
		<?php if ($team_image !== '') { ?>
			<div class="edgt-team-image">
				<img src="<?php echo esc_url($team_image_src); ?>" alt="<?php esc_attr_e('Team image', 'edge-core'); ?>"/>
			</div>
		<?php } ?>

		<?php if ($team_name !== '' || $team_position !== '' || $team_description != "") { ?>
			<div class="edgt-team-info">
				<?php if ($team_name !== '' || $team_position !== '') { ?>
					<div class="edgt-team-title-holder">
						<?php if ($team_name !== '') { ?>
							<h5 class="edgt-team-name"><?php echo esc_attr($team_name); ?></h5>
						<?php } ?>
						<?php if ($team_position !== "") { ?>
							<h6 class="edgt-team-position"><?php echo esc_attr($team_position) ?></h6>
						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($team_description != "") { ?>
					<div class="edgt-team-text">
						<div class="edgt-team-text-inner">
							<div class="edgt-team-description">
								<p><?php echo esc_attr($team_description) ?></p>
							</div>
						</div>
					</div>
				<?php }
				if (!empty($link) && !empty($link_text)) :?>
					<div class="edgt-team-button">
						<?php echo eldritch_edge_get_button_html($button_parameters);?>
					</div>
				<?php endif; ?>
				<div class="edgt-team-social-holder-between">
					<div class="edgt-team-social">
						<div class="edgt-team-social-inner">
							<div class="edgt-team-social-wrapp">

								<?php foreach ($team_social_icons as $team_social_icon) {
									echo eldritch_edge_get_module_part($team_social_icon);
								} ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>