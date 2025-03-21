<?php
$icon_html = eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack);
?>

<div class="edgt-message-icon-holder">
	<div class="edgt-message-icon" <?php eldritch_edge_inline_style($icon_attributes); ?>>
		<div class="edgt-message-icon-inner">
			<?php
			echo eldritch_edge_get_module_part($icon_html);
			?>
		</div>
	</div>
</div>

