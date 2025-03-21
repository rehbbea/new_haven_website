<?php
namespace Eldritch\Modules\Accordion;

use Eldritch\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * class Accordions
 */
class Accordion implements ShortcodeInterface
{
    /**
     * @var string
     */
    private $base;

    function __construct() {
        $this->base = 'edgt_accordion';
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {

        vc_map(array(
            'name' => esc_html__('Accordion', 'edge-core'),
            'base' => $this->base,
            'as_parent' => array('only' => 'edgt_accordion_tab'),
            'content_element' => true,
            'category' => esc_html__( 'by EDGE', 'edge-core' ),
            'icon' => 'icon-wpb-accordion extended-custom-icon',
            'show_settings_on_create' => true,
            'js_view' => 'VcColumnView',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'edge-core'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'edge-core')
                ),
                array(
                    'type' => 'dropdown',
                    'class' => '',
                    'heading' => esc_html__('Style', 'edge-core'),
                    'param_name' => 'style',
                    'value' => array(
                        esc_html__('Accordion', 'edge-core') => 'accordion',
                        esc_html__('Boxed Accordion', 'edge-core') => 'boxed_accordion',
                        esc_html__('Toggle', 'edge-core') => 'toggle',
                        esc_html__('Boxed Toggle', 'edge-core') => 'boxed_toggle'
                    ),
                    'save_always' => true,
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'admin_label' => true,
                    'heading' => esc_html__('Skin', 'edge-core'),
                    'param_name' => 'skin',
                    'value' => array(
                        esc_html__('Default', 'edge-core') => 'default',
                        esc_html__('Dark', 'edge-core') => 'edgt-dark-skin',
                        esc_html__('Light', 'edge-core') => 'edgt-light-skin'
                    ),
                    'description' => '',
                    'save_always' => true
                ),
            )
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = (array(
            'el_class' => '',
            'style' => 'accordion',
            'skin' => '',
        ));
        $params = shortcode_atts($default_atts, $atts);
        extract($params);

        $acc_class = $this->getAccordionClasses($params);
        $params['acc_class'] = $acc_class;
        $params['content'] = $content;

        $output = '';

        $output .= edge_core_get_core_shortcode_template_part('templates/accordion-holder-template', 'accordions', '', $params);

        return $output;
    }

    /**
     * Generates accordion classes
     *
     * @param $params
     *
     * @return string
     */
    private function getAccordionClasses($params) {

        $accordion_classes = array();
        $style = $params['style'];
        switch ($style) {
            case 'toggle':
                $accordion_classes[] = 'edgt-toggle edgt-initial';
                break;
            case 'boxed_toggle':
                $accordion_classes[] = 'edgt-toggle edgt-boxed';
                break;
            case 'boxed_accordion':
                $accordion_classes[] = 'edgt-accordion edgt-boxed';
                break;
            default:
                $accordion_classes[] = 'edgt-accordion edgt-initial';
        }

        $accordion_classes[] = ($params['skin'] !== '') ? $params['skin'] : '';

        $add_class = $params['el_class'];
        if ($add_class !== '') {
            $accordion_classes[] = $add_class;
        }

        $accordion_classes = implode(' ', $accordion_classes);

        return $accordion_classes;
    }
}
