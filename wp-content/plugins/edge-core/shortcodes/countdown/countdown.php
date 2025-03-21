<?php
namespace Eldritch\Modules\Counter;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Countdown
 */
class Countdown implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'edgt_countdown';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 *
	 * @see edgt_core_get_carousel_slider_array_vc()
	 */
	public function vcMap() {

		vc_map(array(
			'name'                      => 'Countdown',
			'base'                      => $this->getBase(),
			'category' => esc_html__( 'by EDGE', 'edge-core' ),
			'admin_enqueue_css'         => array(eldritch_edge_get_skin_uri() . '/assets/css/edgt-vc-extend.css'),
			'icon'                      => 'icon-wpb-countdown extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Type', 'edge-core'),
					'param_name'  => 'countdown_type',
					'value'       => array(
						esc_html__('Type 1', 'edge-core') => 'countdown_type_one',
						esc_html__('Type 2', 'edge-core') => 'countdown_type_two'
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Year', 'edge-core'),
					'param_name'  => 'year',
					'value'       => array(
						''     => '',
						'2022' => '2022',
						'2023' => '2023',
						'2024' => '2024',
						'2025' => '2025',
						'2026' => '2026',
						'2027' => '2027',
						'2028' => '2028',
						'2029' => '2029',
						'2030' => '2030'
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Month', 'edge-core'),
					'param_name'  => 'month',
					'value'       => array(
						''                                     => '',
						esc_html__('January', 'edge-core')   => '1',
						esc_html__('February', 'edge-core')  => '2',
						esc_html__('March', 'edge-core')     => '3',
						esc_html__('April', 'edge-core')     => '4',
						esc_html__('May', 'edge-core')       => '5',
						esc_html__('June', 'edge-core')      => '6',
						esc_html__('July', 'edge-core')      => '7',
						esc_html__('August', 'edge-core')    => '8',
						esc_html__('September', 'edge-core') => '9',
						esc_html__('October', 'edge-core')   => '10',
						esc_html__('November', 'edge-core')  => '11',
						esc_html__('December', 'edge-core')  => '12'
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Day', 'edge-core'),
					'param_name'  => 'day',
					'value'       => array(
						''   => '',
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
						'19' => '19',
						'20' => '20',
						'21' => '21',
						'22' => '22',
						'23' => '23',
						'24' => '24',
						'25' => '25',
						'26' => '26',
						'27' => '27',
						'28' => '28',
						'29' => '29',
						'30' => '30',
						'31' => '31',
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Hour', 'edge-core'),
					'param_name'  => 'hour',
					'value'       => array(
						''   => '',
						'0'  => '0',
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
						'19' => '19',
						'20' => '20',
						'21' => '21',
						'22' => '22',
						'23' => '23',
						'24' => '24'
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Minute', 'edge-core'),
					'param_name'  => 'minute',
					'value'       => array(
						''   => '',
						'0'  => '0',
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
						'19' => '19',
						'20' => '20',
						'21' => '21',
						'22' => '22',
						'23' => '23',
						'24' => '24',
						'25' => '25',
						'26' => '26',
						'27' => '27',
						'28' => '28',
						'29' => '29',
						'30' => '30',
						'31' => '31',
						'32' => '32',
						'33' => '33',
						'34' => '34',
						'35' => '35',
						'36' => '36',
						'37' => '37',
						'38' => '38',
						'39' => '39',
						'40' => '40',
						'41' => '41',
						'42' => '42',
						'43' => '43',
						'44' => '44',
						'45' => '45',
						'46' => '46',
						'47' => '47',
						'48' => '48',
						'49' => '49',
						'50' => '50',
						'51' => '51',
						'52' => '52',
						'53' => '53',
						'54' => '54',
						'55' => '55',
						'56' => '56',
						'57' => '57',
						'58' => '58',
						'59' => '59',
						'60' => '60',
					),
					'admin_label' => true,
					'save_always' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Month Label', 'edge-core'),
					'param_name'  => 'month_label',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Day Label', 'edge-core'),
					'param_name'  => 'day_label',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Hour Label', 'edge-core'),
					'param_name'  => 'hour_label',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Minute Label', 'edge-core'),
					'param_name'  => 'minute_label',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Second Label', 'edge-core'),
					'param_name'  => 'second_label',
					'description' => ''
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Font Family', 'edge-core'),
					'param_name'  => 'font_family',
					'description' => '',
					'group'       => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Text Transform', 'edge-core'),
					'param_name'  => 'text_transform',
					'value'       => array(
						'None'       => 'none',
						'Capitalize' => 'capitalize',
						'Uppercase'  => 'uppercase',
						'Lowercase'  => 'lowercase'
					),
					'description' => '',
					'group'       => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Digit Font Size (px)', 'edge-core'),
					'param_name'  => 'digit_font_size',
					'description' => '',
					'group'       => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Digit color', 'edge-core'),
					'param_name'  => 'digit_color',
					'group'       => esc_html__('Design Options', 'edge-core'),
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Label Font Size (px)', 'edge-core'),
					'param_name'  => 'label_font_size',
					'description' => '',
					'group'       => esc_html__('Design Options', 'edge-core')
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__('Label color', 'edge-core'),
					'param_name'  => 'label_color',
					'group'       => esc_html__('Design Options', 'edge-core'),
					'admin_label' => true
				),

			)
		));

	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'countdown_type'  => 'countdown_type_one',
			'year'            => '',
			'month'           => '',
			'day'             => '',
			'hour'            => '',
			'minute'          => '',
			'month_label'     => esc_html__('Months', 'edge-core'),
			'day_label'       => esc_html__('Days', 'edge-core'),
			'hour_label'      => esc_html__('Hours', 'edge-core'),
			'minute_label'    => esc_html__('Minutes', 'edge-core'),
			'second_label'    => esc_html__('Seconds', 'edge-core'),
			'font_family'     => '',
			'text_transform'  => '',
			'digit_font_size' => '',
			'digit_color'     => '',
			'label_font_size' => '',
			'label_color'     => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['id'] = mt_rand(1000, 9999);

		$params['style'] = $this->getStyle($params);

		//Get HTML from template
		if ($params['countdown_type'] == 'countdown_type_one') {
			$html = edge_core_get_core_shortcode_template_part('templates/countdown-template-one', 'countdown', '', $params);
		} else {
			$html = edge_core_get_core_shortcode_template_part('templates/countdown-template-two', 'countdown', '', $params);
		}

		return $html;
	}

	/* Return Style for Countdown
	*
	* @param $params
	*
	* @return string
	*/
	private function getStyle($params) {

		$styles = array();

		if (!empty($params['font_family'])) {
			$styles[] = 'font-family: ' . $params['font_family'];
		}

		if (!empty($params['text_transform'])) {
			$styles[] = 'text-transform: ' . $params['text_transform'];
		}

		return $styles;
	}

}