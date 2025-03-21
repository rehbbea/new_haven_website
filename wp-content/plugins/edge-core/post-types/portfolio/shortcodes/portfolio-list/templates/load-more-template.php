<?php if ($query_results->max_num_pages > 1) { ?>
	<div class="edgt-ptf-list-paging">
		<span class="edgt-ptf-list-load-more">
			<?php if (edgt_core_theme_installed()) : ?>
				<?php

                $type = 'outline';
                $hover_type = 'solid';

                echo eldritch_edge_get_button_html(array(
                    'link' => 'javascript: void(0)',
                    'text' => esc_html__('Load More', 'edge-core'),
                    'size' => 'small',
                    'type' => $type,
                    'hover_type' => $hover_type,
                ));
				?>
			<?php else: ?>
				<a href="javascript: void(0)"><?php esc_html_e('Load More', 'edge-core'); ?></a>
			<?php endif; ?>
		</span>
	</div>
<?php }