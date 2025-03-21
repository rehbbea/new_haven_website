<?php

if(!function_exists('eldritch_edge_accordions_typography_styles')) {
	function eldritch_edge_accordions_typography_styles() {
		$selector = '.edgt-accordion-holder .edgt-title-holder';
		$styles   = array();

		$font_family = eldritch_edge_options()->getOptionValue('accordions_font_family');
		if(eldritch_edge_is_font_option_valid($font_family)) {
			$styles['font-family'] = eldritch_edge_get_font_option_val($font_family);
		}

		$text_transform = eldritch_edge_options()->getOptionValue('accordions_text_transform');
		if(!empty($text_transform)) {
			$styles['text-transform'] = $text_transform;
		}

		$font_style = eldritch_edge_options()->getOptionValue('accordions_font_style');
		if(!empty($font_style)) {
			$styles['font-style'] = $font_style;
		}

		$letter_spacing = eldritch_edge_options()->getOptionValue('accordions_letter_spacing');
		if($letter_spacing !== '') {
			$styles['letter-spacing'] = eldritch_edge_filter_px($letter_spacing).'px';
		}

		$font_weight = eldritch_edge_options()->getOptionValue('accordions_font_weight');
		if(!empty($font_weight)) {
			$styles['font-weight'] = $font_weight;
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_accordions_typography_styles');
}

if(!function_exists('eldritch_edge_accordions_inital_title_color_styles')) {
	function eldritch_edge_accordions_inital_title_color_styles() {
		$selector = '.edgt-accordion-holder.edgt-initial .edgt-title-holder';
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('accordions_title_color')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('accordions_title_color');
		}
		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_accordions_inital_title_color_styles');
}

if(!function_exists('eldritch_edge_accordions_active_title_color_styles')) {

	function eldritch_edge_accordions_active_title_color_styles() {
		$selector = array(
			'.edgt-accordion-holder.edgt-initial .edgt-title-holder.ui-state-active',
			'.edgt-accordion-holder.edgt-initial .edgt-title-holder.ui-state-hover'
		);
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('accordions_title_color_active')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('accordions_title_color_active');
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_accordions_active_title_color_styles');
}
if(!function_exists('eldritch_edge_accordions_inital_icon_color_styles')) {

	function eldritch_edge_accordions_inital_icon_color_styles() {
		$selector = '.edgt-accordion-holder.edgt-initial .edgt-title-holder .edgt-accordion-mark';
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('accordions_icon_color')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('accordions_icon_color');
		}
		if(eldritch_edge_options()->getOptionValue('accordions_icon_back_color')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('accordions_icon_back_color');
		}
		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_accordions_inital_icon_color_styles');
}
if(!function_exists('eldritch_edge_accordions_active_icon_color_styles')) {

	function eldritch_edge_accordions_active_icon_color_styles() {
		$selector = array(
			'.edgt-accordion-holder.edgt-initial .edgt-title-holder.ui-state-active  .edgt-accordion-mark',
			'.edgt-accordion-holder.edgt-initial .edgt-title-holder.ui-state-hover  .edgt-accordion-mark'
		);
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('accordions_icon_color_active')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('accordions_icon_color_active');
		}
		if(eldritch_edge_options()->getOptionValue('accordions_icon_back_color_active')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('accordions_icon_back_color_active');
		}
		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_accordions_active_icon_color_styles');
}

if(!function_exists('eldritch_edge_boxed_accordions_inital_color_styles')) {
	function eldritch_edge_boxed_accordions_inital_color_styles() {
		$selector = '.edgt-accordion-holder.edgt-boxed .edgt-title-holder';
		$styles   = array();

		if(eldritch_edge_options()->getOptionValue('boxed_accordions_color')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_color');
			echo eldritch_edge_dynamic_css('.edgt-accordion-holder.edgt-boxed .edgt-title-holder .edgt-accordion-mark', array('color' => eldritch_edge_options()->getOptionValue('boxed_accordions_color')));
		}
		if(eldritch_edge_options()->getOptionValue('boxed_accordions_back_color')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_back_color');
		}
		if(eldritch_edge_options()->getOptionValue('boxed_accordions_border_color')) {
			$styles['border-color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_border_color');
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_boxed_accordions_inital_color_styles');
}
if(!function_exists('eldritch_edge_boxed_accordions_active_color_styles')) {

	function eldritch_edge_boxed_accordions_active_color_styles() {
		$selector       = array(
			'.edgt-accordion-holder.edgt-boxed.ui-accordion .edgt-title-holder.ui-state-active',
			'.edgt-accordion-holder.edgt-boxed.ui-accordion .edgt-title-holder.ui-state-hover'
		);
		$selector_icons = array(
			'.edgt-accordion-holder.edgt-boxed .edgt-title-holder.ui-state-active .edgt-accordion-mark',
			'.edgt-accordion-holder.edgt-boxed .edgt-title-holder.ui-state-hover .edgt-accordion-mark'
		);
		$styles         = array();

		if(eldritch_edge_options()->getOptionValue('boxed_accordions_color_active')) {
			$styles['color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_color_active');
			echo eldritch_edge_dynamic_css($selector_icons, array('color' => eldritch_edge_options()->getOptionValue('boxed_accordions_color_active')));
		}
		if(eldritch_edge_options()->getOptionValue('boxed_accordions_back_color_active')) {
			$styles['background-color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_back_color_active');
		}
		if(eldritch_edge_options()->getOptionValue('boxed_accordions_border_color_active')) {
			$styles['border-color'] = eldritch_edge_options()->getOptionValue('boxed_accordions_border_color_active');
		}

		echo eldritch_edge_dynamic_css($selector, $styles);
	}

	add_action('eldritch_edge_style_dynamic', 'eldritch_edge_boxed_accordions_active_color_styles');
}