<?php
namespace Eldritch\Modules\Shortcodes\ItemShowcaseItem;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ItemShowcaseItem implements ShortcodeInterface {
	private $base;

	function __construct() {
		$this->base = 'edgt_item_showcase_item';
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		vc_map(
			array(
				'name' => esc_html__('Edge Item Showcase List Item', 'edge-core'),
				'base' => $this->base,
				'as_child' => array('only' => 'edgt_item_showcase'),
				'as_parent' => array('except' => 'vc_row'),
				'content_element' => true,
				'category' => esc_html__('by EDGE', 'edge-core'),
				'icon' => 'icon-wpb-item-showcase-item extended-custom-icon',
				'show_settings_on_create' => true,
				'params' => array_merge(
                    eldritch_edge_icon_collections()->getVCParamsArray(),
                    array(
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__('Icon Type', 'edge-core'),
                            'param_name'  => 'icon_type',
                            'value'       => array(
                                esc_html__('Normal', 'edge-core') => 'normal',
                                esc_html__('Circle', 'edge-core') => 'circle',
                                esc_html__('Square', 'edge-core') => 'square',
                            ),
                            'save_always' => true,
                            'admin_label' => true,
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'heading'    => esc_html__('Icon Color', 'edge-core'),
                            'param_name' => 'icon_color',
                            'dependency'  => array(
                                'element' => 'icon_type',
                                'value'   => array('normal', 'square', 'circle')
                            )
                        ),
                        array(
                            'type'       => 'dropdown',
                            'param_name' => 'item_position',
                            'heading'    => esc_html__('Item Position', 'edge-core'),
                            'value'      => array(
                                esc_html__('Left', 'edge-core') => 'left',
                                esc_html__('Right', 'edge-core') => 'right'
                            ),
                            'admin_label' => true
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'item_title',
                            'heading'     => esc_html__('Item Title', 'edge-core'),
                            'admin_label' => true
                        ),
                        array(
                            'type'       => 'textfield',
                            'param_name' => 'item_link',
                            'heading'    => esc_html__('Item Link', 'edge-core'),
                            'dependency' => array('element' => 'item_title', 'not_empty' => true)
                        ),
                        array(
                            'type'       => 'dropdown',
                            'param_name' => 'item_target',
                            'heading'    => esc_html__('Item Target', 'edge-core'),
                            'value'       => array(
                                esc_html__('Self', 'edge-core')  => '_self',
                                esc_html__('Blank', 'edge-core') => '_blank'
                            ),
                            'dependency' => array('element' => 'item_link', 'not_empty' => true),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'item_title_tag',
                            'heading'     => esc_html__('Item Title Tag', 'edge-core'),
                            'value'       => array(
                                ''   => '',
                                'h1' => 'h1',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6',
                            ),
                            'save_always' => true,
                            'dependency'  => array('element' => 'item_title', 'not_empty' => true)
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'item_title_color',
                            'heading'    => esc_html__('Item Title Color', 'edge-core'),
                            'dependency' => array('element' => 'item_title', 'not_empty' => true)
                        ),
                        array(
                            'type'       => 'textarea',
                            'param_name' => 'item_text',
                            'heading'    => esc_html__('Item Text', 'edge-core')
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'item_text_color',
                            'heading'    => esc_html__('Item Text Color', 'edge-core'),
                            'dependency' => array('element' => 'item_text', 'not_empty' => true)
					    ),
				    )
			    )
            )

        );
    }

	public function render($atts, $content = null) {
		$args = array(
            'icon_type'        => '',
            'icon_color'       => '',
			'item_position'    => 'left',
			'item_title'       => '',
			'item_link'        => '',
			'item_target'      => '_self',
			'item_title_tag'   => 'h3',
			'item_title_color' => '',
			'item_text'        => '',
			'item_text_color'  => ''
		);

        $args = array_merge($args, eldritch_edge_icon_collections()->getShortcodeParams());
		
		$params = shortcode_atts($args, $atts);
		extract($params);
        $params['icon_params'] = $this->getIconParameters($params);
		$params['showcase_item_class'] = $this->getShowcaseItemClasses($params);
		$params['item_target'] = !empty($item_target) ? $params['item_target'] : $args['item_target'];
		$params['item_title_tag'] = !empty($item_title_tag) ? $params['item_title_tag'] : $args['item_title_tag'];
		$params['item_title_styles'] = $this->getTitleStyles($params);
		$params['item_text_styles'] = $this->getTextStyles($params);
		
		$html = edge_core_get_core_shortcode_template_part('templates/item-showcase-item-template', 'item-showcase', '', $params);

		return $html;
	}


    /**
     * Returns parameters for icon shortcode as a string
     *
     * @param $params
     *
     * @return array
     */
    private function getIconParameters($params) {
        $params_array = array();

        $iconPackName = eldritch_edge_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);

        $params_array['icon_pack']   = $params['icon_pack'];
        $params_array['icon_color']  = $params['icon_color'];

        if (!empty($params['icon_type'])) {
            $params_array['type'] = $params['icon_type'];
        }

        $params_array[$iconPackName] = $params[$iconPackName];

        $params_array['size'] = 'edgt-icon-medium';

        return $params_array;
    }

	
	/**
	 * Return Showcase Item Classes
	 *
	 * @param $params
	 * @return array
	 */
	private function getShowcaseItemClasses($params) {
		$itemClass = array();

		if (!empty($params['item_position'])) {
			$itemClass[] = 'edgt-is-'. $params['item_position'];
		}

		return implode(' ', $itemClass);
	}
	
	private function getTitleStyles($params) {
		$styles = array();
		
		if (!empty($params['item_title_color'])) {
			$styles[] = 'color: '.$params['item_title_color'];
		}
		
		return implode(';', $styles);
	}
	
	private function getTextStyles($params) {
		$styles = array();
		
		if (!empty($params['item_text_color'])) {
			$styles[] = 'color: '.$params['item_text_color'];
		}
		
		return implode(';', $styles);
	}
}
