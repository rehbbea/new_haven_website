<div class="edgt-tabs <?php echo esc_attr($tab_class) ?> clearfix">
	<ul class="edgt-tabs-nav">
		<?php foreach($tabs_titles_subtitles as $tab_title_subtitle) { ?>
			<li>
				<a href="#tab-<?php echo sanitize_title($tab_title_subtitle['tab_title']) ?>">
					<span class="edgt-icon-frame"></span>
				</a>
			</li>
		<?php } ?>
	</ul>
	<?php echo eldritch_edge_remove_auto_ptag($content) ?>
</div>
