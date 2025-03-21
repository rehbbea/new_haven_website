<?php
namespace Eldritch\Modules\Shortcodes\ItemShowcase;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ItemShowcase implements ShortcodeInterface
{
    private $base;

    function __construct() {
        $this->base = 'edgt_item_showcase';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
            'name'      => esc_html__('Edge Item Showcase', 'edge-core'),
            'base'      => $this->base,
            'category'  => esc_html__('by EDGE', 'edge-core'),
            'icon'      => 'icon-wpb-item-showcase extended-custom-icon',
            'as_parent' => array('only' => 'edgt_item_showcase_item'),
            'js_view'   => 'VcColumnView',
            'params'    => array(
                array(
                    'type'       => 'attach_image',
                    'param_name' => 'item_image',
                    'heading'    => esc_html__('Image', 'edge-core')
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Full height image', 'edge-core'),
                    'param_name'  => 'full_height_image',
                    'value'       => array(
                        esc_html__('Yes', 'edge-core') => 'yes',
                        esc_html__('No', 'edge-core')  => 'no'
                    ),
                    'save_always' => true
                ),
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'image_top_offset',
                    'heading'     => esc_html__('Image Top Offset', 'edge-core'),
                    'value'       => '0px',
                    'save_always' => true
                ),
                array(
                    'type'       => 'colorpicker',
                    'param_name' => 'left_holder_background_color',
                    'heading'    => esc_html__('Left Holder Background Color', 'edge-core'),
                ),
                array(
                    'type'       => 'colorpicker',
                    'param_name' => 'right_holder_background_color',
                    'heading'    => esc_html__('Right Holder Background Color', 'edge-core'),
                ),
                array(
                    'type'       => 'textfield',
                    'param_name' => 'left_right_holder_padding',
                    'heading'    => esc_html__('Left/Right Holder padding', 'edge-core'),
                    'description' => esc_html__('Add padding for left and right holder, for example: 10px 15px 20px 25px', 'edge-core')
                )
            )
        ));
    }

    public function render($atts, $content = null) {
        $args = array(
            'item_image'                    => '',
            'full_height_image'             => '',
            'image_top_offset'              => '',
            'left_holder_background_color'  => '',
            'right_holder_background_color' => '',
            'left_right_holder_padding'     => '66px 0px 73px'
        );

        $params = shortcode_atts($args, $atts);

        $params['data_attrs'] = $this->getDataAttribute($params);

        extract($params);

        $html = '';

        $item_image_style = '';
        if (!empty($image_top_offset)) {
            $item_image_style = 'margin-top: ' . eldritch_edge_filter_px($image_top_offset) . 'px';
        }

        $item_image_height = array('edgt-is-image');

        if ($params['full_height_image'] == 'yes') {
            $item_image_height[] = 'edgt-full-height-image';
        }

        $html .= '<div class="edgt-item-showcase-holder clearfix" ' . eldritch_edge_get_inline_attrs($params['data_attrs']) . '>';
        $html .= '<div ' . eldritch_edge_get_class_attribute($item_image_height) .' '. eldritch_edge_get_inline_style($item_image_style) . '>';
        if (!empty($item_image)) {
            $html .= wp_get_attachment_image($item_image, 'full');
        }
        $html .= '</div>';
        $html .= do_shortcode($content);
        $html .= '</div>';

        return $html;
    }

    /**
     * Return Team Slider data attribute
     *
     * @param $params
     *
     * @return string
     */

    private function getDataAttribute($params) {

        $data_attrs = array();

        if ($params['left_holder_background_color'] !== '') {
            $data_attrs['data-left-holder-background'] = $params['left_holder_background_color'];
        }

        if ($params['right_holder_background_color'] !== '') {
            $data_attrs['data-right-holder-background'] = $params['right_holder_background_color'];
        }

        if ($params['left_right_holder_padding'] !== '') {
            $data_attrs['data-holder-padding'] = $params['left_right_holder_padding'];
        }

        return $data_attrs;
    }
}