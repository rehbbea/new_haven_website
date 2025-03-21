<?php
namespace Eldritch\Modules\Shortcodes\Process;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

class ProcessItem implements ShortcodeInterface
{
    private $base;

    public function __construct() {
        $this->base = 'edgt_process_item';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
            'name'                    => esc_html__('Process Item', 'edge-core'),
            'base'                    => $this->getBase(),
            'as_child'                => array('only' => 'edgt_process_holder'),
            'category' => esc_html__( 'by EDGE', 'edge-core' ),
            'icon'                    => 'icon-wpb-process-item extended-custom-icon',
            'show_settings_on_create' => true,
            'params'                  => array_merge(
                \EldritchEdgeIconCollections::get_instance()->getVCParamsArray(),
                array(
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Icon Color', 'edge-core'),
                        'param_name'  => 'icon_color',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Background Color', 'edge-core'),
                        'param_name'  => 'icon_background_color',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Image', 'edge-core'),
                        'param_name' => 'image'
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title', 'edge-core'),
                        'param_name'  => 'title',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textarea',
                        'heading'     => esc_html__('Text', 'edge-core'),
                        'param_name'  => 'text',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Link', 'edge-core'),
                        'param_name'  => 'link',
                        'value'       => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Link Text', 'edge-core'),
                        'param_name' => 'link_text',
                        'dependency' => array(
                            'element'   => 'link',
                            'not_empty' => true
                        )
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Target', 'edge-core'),
                        'param_name' => 'target',
                        'value'      => array(
                            ''                                   => '',
                            esc_html__('Self', 'edge-core')  => '_self',
                            esc_html__('Blank', 'edge-core') => '_blank'
                        ),
                        'dependency' => array(
                            'element'   => 'link',
                            'not_empty' => true
                        )
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Link Color', 'edge-core'),
                        'param_name'  => 'color',
                        'dependency'  => array(
                            'element'   => 'link',
                            'not_empty' => true
                        ),
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Highlight Item?', 'edge-core'),
                        'param_name'  => 'highlighted',
                        'value'       => array(
                            esc_html__('No', 'edge-core')  => 'no',
                            esc_html__('Yes', 'edge-core') => 'yes'
                        ),
                        'save_always' => true,
                        'admin_label' => true
                    )
                ))
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = array(
            'icon_color'            => '',
            'icon_background_color' => '',
            'image'                 => '',
            'title'                 => '',
            'text'                  => '',
            'link'                  => '',
            'link_text'             => '',
            'color'                 => '',
            'target'                => '_self',
            'highlighted'           => ''
        );

        $default_atts = array_merge($default_atts, eldritch_edge_icon_collections()->getShortcodeParams());

        $params = shortcode_atts($default_atts, $atts);

        $params['icon_parameters'] = $this->getIconParameters($params);
        $params['icon_styles'] = $this->getIconStyles($params);
        $params['button_parameters'] = $this->getButtonParameters($params);

        $params['item_classes'] = array(
            'edgt-process-item-holder'
        );

        if ($params['highlighted'] === 'yes') {
            $params['item_classes'][] = 'edgt-pi-highlighted';
        }

        return edge_core_get_core_shortcode_template_part('templates/process-item-template', 'process', '', $params);
    }

    /**
     * Returns styles for icon shortcode as a string
     *
     * @param $params
     *
     * @return array
     */
    private function getIconStyles($params) {
        $styles = array();

            if (!empty($params['icon_background_color'])) {
                $styles[] = 'background-color: ' . $params['icon_background_color'];
            }


        return $styles;
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

        if (empty($params['custom_icon'])) {
            $iconPackName = eldritch_edge_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);

            $params_array['icon_pack'] = $params['icon_pack'];

            $params_array[$iconPackName] = $params[$iconPackName];

            if (!empty($params['icon_color'])) {
                $params_array['icon_color'] = $params['icon_color'];
            }

            if (!empty($params['icon_background_color'])) {
                $params_array['background_color'] = $params['icon_background_color'];
            }

            $params_array['size'] = 'edgt-icon-medium';
        }

        return $params_array;
    }

    private function getButtonParameters($params) {
        $button_params_array = array();

        $button_params_array['type'] = 'underline';

        if (!empty($params['link_text'])) {
            $button_params_array['text'] = $params['link_text'];
        }

        if (!empty($params['link'])) {
            $button_params_array['link'] = $params['link'];
        }

        if (!empty($params['target'])) {
            $button_params_array['target'] = $params['target'];
        }

        if (!empty($params['color'])) {
            $button_params_array['color'] = $params['color'];
        }

        return $button_params_array;
    }

}