<?php if($filter == 'yes') {
	$filter_categories = $this_object->getFilterCategories($params);
	$filter_styles = $this_object->getFilterStyles($params);
	?>
	<div class="edgt-pl-filter-holder">
		<div class="edgt-plf-inner">
			<?php
			if(is_array($filter_categories) && count($filter_categories)){ ?>
				<ul>
					<li class="edgt-pl-filter" data-filter="">
						<span <?php eldritch_edge_inline_style($filter_styles); ?>><?php esc_html_e('All', 'edge-core')?></span>
					</li>
					<?php foreach($filter_categories as $cat) { ?>
						<li class="edgt-pl-filter" data-filter=".portfolio-category-<?php echo esc_attr($cat->slug); ?>">
							<span <?php eldritch_edge_inline_style($filter_styles); ?>><?php echo esc_html($cat->name); ?></span>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
	</div>
<?php } ?>
