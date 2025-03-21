<?php
if(!function_exists('eldritch_edge_tabs_typography_styles')) {
	function eldritch_edge_tabs_typography_styles() {
		$selector              = '.edgt-tabs .edgt-tabs-nav li a';
		$tabs_tipography_array = array();
		$font_family           = eldritch_edge_options()->getOptionValue('tabs_font_family');

		if(eldritch_edge_is_font_option_valid($font_family)) {
			$tabs_tipography_array['font-family'] = eldritch_edge_is_font_option_valid($font_family);
		}

		$text_transform = eldritch_edge_options()->getOptionValue('tabs_text_transform');
		if(!empty($text_transform)) {
			$tabs_tipography_array['text-transform'] = $text_transform;
		}

		$font_style = eldritch_edge_options()->getOptionValue('tabs_font_style');
		if(!empty($font_style)) {
			$tabs_tipography_array['font-style'] = $font_style;
		}

		$letter_spacing = eldritch_edge_options()->getOptionValue('tabs_letter_spacing');
		if($letter_spacing !== '') {
			$tabs_tipography_array['letter-spacing'] = eldritch_edge_filter_px($letter_spacing).'px';
		}

		$font_weight = eldritch_edge_options()->getOptionValue('tabs_font_weight');
		if(!empty($font_weight)) {
			$tabs_tipography_array['font-weight'] = $font_weight;
		}

		echo eldritch_edge_dynamic_css($selector, $tabs_tipography_array);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_tabs_typography_styles');
}

if(!function_exists('eldritch_edge_tabs_inital_color_styles')) {
	function eldritch_edge_tabs_inital_color_styles() {
		$selector = '.edgt-tabs .edgt-tabs-nav li a';
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('tabs_color')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('tabs_color');
		}
		if(eldritch_edge_options()->getOptionValue('tabs_back_color')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('tabs_back_color');
		}
		if(eldritch_edge_options()->getOptionValue('tabs_border_color')) {
			$styles['border-color'] = eldritch_edge_options()->getOptionValue('tabs_border_color');
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_tabs_inital_color_styles');
}
if(!function_exists('eldritch_edge_tabs_active_color_styles')) {
	function eldritch_edge_tabs_active_color_styles() {
		$selector = '.edgt-tabs .edgt-tabs-nav li.ui-state-active a, .edgt-tabs .edgt-tabs-nav li.ui-state-hover a';
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('tabs_color_active')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('tabs_color_active');
		}
		if(eldritch_edge_options()->getOptionValue('tabs_back_color_active')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('tabs_back_color_active');
		}
		if(eldritch_edge_options()->getOptionValue('tabs_border_color_active')) {
			$styles['border-color'] = eldritch_edge_options()->getOptionValue('tabs_border_color_active');
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_tabs_active_color_styles');
}