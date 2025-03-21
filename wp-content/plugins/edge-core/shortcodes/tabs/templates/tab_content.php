<?php
$tab_data_str = '';
$icon_html    = '';
$tab_data_str .= 'data-icon-pack="'.$icon_pack.'" ';
$icon_html .= eldritch_edge_icon_collections()->renderIcon($icon, $icon_pack, array());
$tab_data_str .= 'data-icon-html="'.esc_attr($icon_html).'"';
?>
<div <?php eldritch_edge_class_attribute($tab_classes); ?> <?php eldritch_edge_inline_style($tab_styles); ?> id="tab-<?php echo sanitize_title( $tab_title )?>" <?php echo eldritch_edge_get_module_part($tab_data_str); ?>>
	<?php echo eldritch_edge_remove_auto_ptag($content); ?>
</div>
