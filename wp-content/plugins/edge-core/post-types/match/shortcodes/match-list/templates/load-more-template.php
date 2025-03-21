<?php if ($query_results->max_num_pages > 1) { ?>
	<div class="edgt-match-list-paging">
		<span class="edgt-match-list-load-more">
			<?php if (edgt_core_theme_installed()) : ?>
				<?php

                if($skin == 'light') {
                    $type = 'white-outline';
                    $hover_type = 'white';
                }
                else {
                    $type = 'outline';
                    $hover_type = 'solid';
                }

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
<?php  }