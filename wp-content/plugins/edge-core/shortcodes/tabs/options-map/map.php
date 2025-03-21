<?php

if (!function_exists('eldritch_edge_tabs_map')) {
	function eldritch_edge_tabs_map() {

		$panel = eldritch_edge_add_admin_panel(array(
			'title' => esc_html__('Tabs', 'edge-core'),
			'name'  => 'panel_tabs',
			'page'  => '_elements_page'
		));

		//Typography options
		eldritch_edge_add_admin_section_title(array(
			'name'   => 'typography_section_title',
			'title'  => esc_html__('Tabs Navigation Typography', 'edge-core'),
			'parent' => $panel
		));

		$typography_group = eldritch_edge_add_admin_group(array(
			'name'        => 'typography_group',
			'title'       => esc_html__('Tabs Navigation Typography', 'edge-core'),
			'description' => esc_html__('Setup typography for tabs navigation', 'edge-core'),
			'parent'      => $panel
		));

		$typography_row = eldritch_edge_add_admin_row(array(
			'name'   => 'typography_row',
			'next'   => true,
			'parent' => $typography_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'fontsimple',
			'name'          => 'tabs_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family', 'edge-core'),
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'tabs_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'edge-core'),
			'options'       => eldritch_edge_get_text_transform_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'tabs_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'edge-core'),
			'options'       => eldritch_edge_get_font_style_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'textsimple',
			'name'          => 'tabs_letter_spacing',
			'default_value' => '',
			'label'         => esc_html__('Letter Spacing', 'edge-core'),
			'args'          => array(
				'suffix' => 'px'
			)
		));

		$typography_row2 = eldritch_edge_add_admin_row(array(
			'name'   => 'typography_row2',
			'next'   => true,
			'parent' => $typography_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row2,
			'type'          => 'selectsimple',
			'name'          => 'tabs_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'edge-core'),
			'options'       => eldritch_edge_get_font_weight_array()
		));

		//Initial Tab Color Styles

		eldritch_edge_add_admin_section_title(array(
			'name'   => 'tab_color_section_title',
			'title'  => esc_html__('Tab Navigation Color Styles', 'edge-core'),
			'parent' => $panel
		));
		$tabs_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'tabs_color_group',
			'title'       => esc_html__('Tab Navigation Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for tab navigation', 'edge-core'),
			'parent'      => $panel
		));
		$tabs_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'tabs_color_row',
			'next'   => true,
			'parent' => $tabs_color_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_color',
			'default_value' => '',
			'label'         => esc_html__('Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_back_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core')
		));

		//Active Tab Color Styles

		$active_tabs_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'active_tabs_color_group',
			'title'       => esc_html__('Active and Hover Navigation Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for active and hover tabs', 'edge-core'),
			'parent'      => $panel
		));
		$active_tabs_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'active_tabs_color_row',
			'next'   => true,
			'parent' => $active_tabs_color_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_color_active',
			'default_value' => '',
			'label'         => esc_html__('Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_back_color_active',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_tabs_color_row,
			'type'          => 'colorsimple',
			'name'          => 'tabs_border_color_active',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core')
		));

	}

	add_action('eldritch_edge_options_elements_map', 'eldritch_edge_tabs_map');
}