<?php

if(!function_exists('eldritch_edge_button_map')) {
	function eldritch_edge_button_map() {
		$panel = eldritch_edge_add_admin_panel(array(
			'title' => esc_html__('Button', 'edge-core'),
			'name'  => 'panel_button',
			'page'  => '_elements_page'
		));

		eldritch_edge_add_admin_field(array(
			'name'        => 'button_hover_animation',
			'type'        => 'select',
			'label'       => esc_html__('Hover Animation', 'edge-core'),
			'description' => esc_html__('Choose default hover animation type', 'edge-core'),
			'parent'      => $panel,
			'options'     => eldritch_edge_get_btn_hover_animation_types()
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
			'description' => esc_html__('Setup typography for all button types', 'edge-core'),
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
			'name'          => 'button_font_family',
			'default_value' => '',
			'label'         => esc_html__('Font Family', 'edge-core'),
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'button_text_transform',
			'default_value' => '',
			'label'         => esc_html__('Text Transform', 'edge-core'),
			'options'       => eldritch_edge_get_text_transform_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'selectsimple',
			'name'          => 'button_font_style',
			'default_value' => '',
			'label'         => esc_html__('Font Style', 'edge-core'),
			'options'       => eldritch_edge_get_font_style_array()
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $typography_row,
			'type'          => 'textsimple',
			'name'          => 'button_letter_spacing',
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
			'name'          => 'button_font_weight',
			'default_value' => '',
			'label'         => esc_html__('Font Weight', 'edge-core'),
			'options'       => eldritch_edge_get_font_weight_array()
		));

		//Outline type options
		eldritch_edge_add_admin_section_title(array(
			'name'   => 'type_section_title',
			'title'  => esc_html__('Types', 'edge-core'),
			'parent' => $panel
		));

		$outline_group = eldritch_edge_add_admin_group(array(
			'name'        => 'outline_group',
			'title'       => esc_html__('Outline Type', 'edge-core'),
			'description' => esc_html__('Setup outline button type', 'edge-core'),
			'parent'      => $panel
		));

		$outline_row = eldritch_edge_add_admin_row(array(
			'name'   => 'outline_row',
			'next'   => true,
			'parent' => $outline_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $outline_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core'),
			'description'   => ''
		));

		$outline_row2 = eldritch_edge_add_admin_row(array(
			'name'   => 'outline_row2',
			'next'   => true,
			'parent' => $outline_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $outline_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_outline_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Border Color', 'edge-core'),
			'description'   => ''
		));

		//Solid type options
		$solid_group = eldritch_edge_add_admin_group(array(
			'name'        => 'solid_group',
			'title'       => esc_html__('Solid Type', 'edge-core'),
			'description' => esc_html__('Setup solid button type', 'edge-core'),
			'parent'      => $panel
		));

		$solid_row = eldritch_edge_add_admin_row(array(
			'name'   => 'solid_row',
			'next'   => true,
			'parent' => $solid_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_text_color',
			'default_value' => '',
			'label'         => esc_html__('Text Hover Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Background Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_bg_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Background Color', 'edge-core'),
			'description'   => ''
		));

		$solid_row2 = eldritch_edge_add_admin_row(array(
			'name'   => 'solid_row2',
			'next'   => true,
			'parent' => $solid_group
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_border_color',
			'default_value' => '',
			'label'         => esc_html__('Border Color', 'edge-core'),
			'description'   => ''
		));

		eldritch_edge_add_admin_field(array(
			'parent'        => $solid_row2,
			'type'          => 'colorsimple',
			'name'          => 'btn_solid_hover_border_color',
			'default_value' => '',
			'label'         => esc_html__('Hover Border Color', 'edge-core'),
			'description'   => ''
		));
	}

	add_action('eldritch_edge_options_elements_map', 'eldritch_edge_button_map');
}