<?php if ($response->status) : ?>
	<?php if (is_array($response->data) && count($response->data)) : ?>
		<div class="edgt-twitter-slider clearfix">
			<span aria-hidden="true" class="twitter-icon edgt-icon-font-elegant social_twitter" <?php eldritch_edge_inline_style($tweet_styles); ?>></span>
			<div class="edgt-twitter-slider-inner" <?php eldritch_edge_inline_style($tweet_styles); ?>>
				<?php foreach ($response->data as $tweet) : ?>
					<div class="item edgt-twitter-slider-item">
						<h2>
							<?php echo EdgeTwitterApi::getInstance()->getHelper()->getTweetText($tweet); ?>
						</h2>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

<?php else: ?>
	<?php echo esc_html($response->message); ?>
<?php endif; ?>
