<?php

if(!function_exists('eldritch_edge_button_typography_styles')) {
	/**
	 * Typography styles for all button types
	 */
	function eldritch_edge_button_typography_styles() {
		$selector = '.edgt-btn';
		$styles   = array();

		$font_family = eldritch_edge_options()->getOptionValue('button_font_family');
		if(eldritch_edge_is_font_option_valid($font_family)) {
			$styles['font-family'] = eldritch_edge_get_font_option_val($font_family);
		}

		$text_transform = eldritch_edge_options()->getOptionValue('button_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$font_style = eldritch_edge_options()->getOptionValue('button_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$letter_spacing = eldritch_edge_options()->getOptionValue('button_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = eldritch_edge_filter_px($letter_spacing).'px';
		}

		$font_weight = eldritch_edge_options()->getOptionValue('button_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_button_typography_styles');
}

if(!function_exists('eldritch_edge_button_outline_styles')) {
	/**
	 * Generate styles for outline button
	 */
	function eldritch_edge_button_outline_styles() {
		//outline styles
		$outline_styles   = array();
		$outline_selector = '.edgt-btn.edgt-btn-outline';

		if(eldritch_edge_options()->getOptionValue('btn_outline_text_color')) {
			$outline_styles['color'] = eldritch_edge_options()->getOptionValue('btn_outline_text_color');
		}

		if(eldritch_edge_options()->getOptionValue('btn_outline_border_color')) {
			$outline_styles['border-color'] = eldritch_edge_options()->getOptionValue('btn_outline_border_color');
		}

		echo eldritch_edge_dynamic_css($outline_selector, $outline_styles);

		//outline hover styles
		if(eldritch_edge_options()->getOptionValue('btn_outline_hover_text_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-outline:not(.edgt-btn-custom-hover-color):hover',
				array('color' => eldritch_edge_options()->getOptionValue('btn_outline_hover_text_color').'!important')
			);
		}

		if(eldritch_edge_options()->getOptionValue('btn_outline_hover_bg_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-outline:not(.edgt-btn-custom-hover-bg):hover',
				array('background-color' => eldritch_edge_options()->getOptionValue('btn_outline_hover_bg_color').'!important')
			);
		}

		if(eldritch_edge_options()->getOptionValue('btn_outline_hover_border_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-outline:not(.edgt-btn-custom-border-hover):hover',
				array('border-color' => eldritch_edge_options()->getOptionValue('btn_outline_hover_border_color').'!important')
			);
		}
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_button_outline_styles');
}

if(!function_exists('eldritch_edge_button_solid_styles')) {
	/**
	 * Generate styles for solid type buttons
	 */
	function eldritch_edge_button_solid_styles() {
		//solid styles
		$solid_selector = '.edgt-btn.edgt-btn-solid';
		$solid_styles   = array();

		if(eldritch_edge_options()->getOptionValue('btn_solid_text_color')) {
			$solid_styles['color'] = eldritch_edge_options()->getOptionValue('btn_solid_text_color');
		}

		if(eldritch_edge_options()->getOptionValue('btn_solid_border_color')) {
			$solid_styles['border-color'] = eldritch_edge_options()->getOptionValue('btn_solid_border_color');
		}

		if(eldritch_edge_options()->getOptionValue('btn_solid_bg_color')) {
			$solid_styles['background-color'] = eldritch_edge_options()->getOptionValue('btn_solid_bg_color');
		}

		echo eldritch_edge_dynamic_css($solid_selector, $solid_styles);

		//solid hover styles
		if(eldritch_edge_options()->getOptionValue('btn_solid_hover_text_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-solid:not(.edgt-btn-custom-hover-color):hover',
				array('color' => eldritch_edge_options()->getOptionValue('btn_solid_hover_text_color').'!important')
			);
		}

		if(eldritch_edge_options()->getOptionValue('btn_solid_hover_bg_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-solid:not(.edgt-btn-custom-hover-bg):hover',
				array('background-color' => eldritch_edge_options()->getOptionValue('btn_solid_hover_bg_color').'!important')
			);
		}

		if(eldritch_edge_options()->getOptionValue('btn_solid_hover_border_color')) {
			echo eldritch_edge_dynamic_css(
				'.edgt-btn.edgt-btn-solid:not(.edgt-btn-custom-hover-bg):hover',
				array('border-color' => eldritch_edge_options()->getOptionValue('btn_solid_hover_border_color').'!important')
			);
		}
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_button_solid_styles');
}