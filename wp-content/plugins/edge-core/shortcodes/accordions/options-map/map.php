<?php
if (!function_exists('eldritch_edge_accordions_map')) {
	/**
	 * Add Accordion options to elements panel
	 */
	function eldritch_edge_accordions_map() {

		$panel = eldritch_edge_add_admin_panel(array(
			'title' => esc_html__('Accordions', 'edge-core'),
			'name'  => 'panel_accordions',
			'page'  => '_elements_page'
		));

		//Typography options
		eldritch_edge_add_admin_section_title(array(
			'name'   => 'typography_section_title',
			'title'  => esc_html__('Typography', 'edge-core'),
			'parent' => $panel
		));

		$typography_group = eldritch_edge_add_admin_group(array(
			'name'        => 'typography_group',
			'title'       => esc_html__('Typography', 'edge-core'),
			'description' => esc_html__('Setup typography for accordions navigation', 'edge-core'),
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
			'name'          => 'accordions_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family', 'edge-core'),
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'accordions_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'edge-core'),
			'options'       => eldritch_edge_get_text_transform_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'accordions_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'edge-core'),
			'options'       => eldritch_edge_get_font_style_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'textsimple',
			'name'          => 'accordions_letter_spacing',
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
			'name'          => 'accordions_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'edge-core'),
			'options'       => eldritch_edge_get_font_weight_array()
		));

		//Initial Accordion Color Styles

		eldritch_edge_add_admin_section_title(array(
			'name'   => 'accordion_color_section_title',
			'title'  => esc_html__('Basic Accordions Color Styles', 'edge-core'),
			'parent' => $panel
		));

		$accordions_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'accordions_color_group',
			'title'       => esc_html__('Accordion Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for accordion title', 'edge-core'),
			'parent'      => $panel
		));
		$accordions_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'accordions_color_row',
			'next'   => true,
			'parent' => $accordions_color_group
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_title_color',
			'default_value' => '',
			'label'         => esc_html__('Title Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_icon_color',
			'default_value' => '',
			'label'         => esc_html__('Icon Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_icon_back_color',
			'default_value' => '',
			'label'         => esc_html__('Icon Background Color', 'edge-core')
		));

		$active_accordions_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'active_accordions_color_group',
			'title'       => esc_html__('Active and Hover Accordion Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for active and hover accordions', 'edge-core'),
			'parent'      => $panel
		));
		$active_accordions_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'active_accordions_color_row',
			'next'   => true,
			'parent' => $active_accordions_color_group
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_title_color_active',
			'default_value' => '',
			'label'         => esc_html__('Title Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_icon_color_active',
			'default_value' => '',
			'label'         => esc_html__('Icon Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'accordions_icon_back_color_active',
			'default_value' => '',
			'label'         => esc_html__('Icon Background Color', 'edge-core')
		));

		//Boxed Accordion Color Styles

		eldritch_edge_add_admin_section_title(array(
			'name'   => 'boxed_accordion_color_section_title',
			'title'  => esc_html__('Boxed Accordion Title Color Styles', 'edge-core'),
			'parent' => $panel
		));
		$boxed_accordions_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'boxed_accordions_color_group',
			'title'       => esc_html__('Boxed Accordion Title Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for boxed accordion title', 'edge-core'),
			'parent'      => $panel
		));
		$boxed_accordions_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'boxed_accordions_color_row',
			'next'   => true,
			'parent' => $boxed_accordions_color_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_color',
			'default_value' => '',
			'label'         => esc_html__('Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_back_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core')
		));

		//Active Boxed Accordion Color Styles

		$active_boxed_accordions_color_group = eldritch_edge_add_admin_group(array(
			'name'        => 'active_boxed_accordions_color_group',
			'title'       => esc_html__('Active and Hover Title Color Styles', 'edge-core'),
			'description' => esc_html__('Set color styles for active and hover accordions', 'edge-core'),
			'parent'      => $panel
		));
		$active_boxed_accordions_color_row = eldritch_edge_add_admin_row(array(
			'name'   => 'active_boxed_accordions_color_row',
			'next'   => true,
			'parent' => $active_boxed_accordions_color_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $active_boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_color_active',
			'default_value' => '',
			'label'         => esc_html__('Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_back_color_active',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'edge-core')
		));
		eldritch_edge_add_admin_field(array(
			'parent'        => $active_boxed_accordions_color_row,
			'type'          => 'colorsimple',
			'name'          => 'boxed_accordions_border_color_active',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core')
		));

	}

	add_action('eldritch_edge_options_elements_map', 'eldritch_edge_accordions_map', 11);
}