<?php
namespace Eldritch\Modules\Shortcodes\SectionTitle;

use Eldritch\Modules\Shortcodes\Lib;

class SectionTitle implements Lib\ShortcodeInterface {
	private $base;

	/**
	 * SectionTitle constructor.
	 */
	public function __construct() {
		$this->base = 'edgt_section_title';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

    /**
     * Maps shortcode to Visual Composer. Hooked on vc_before_init
     *
     */
    public function vcMap() {
        if (function_exists('vc_map')) {
            vc_map( array(
                'name' => esc_html__('Section Title', 'edge-core'),
                'base' => $this->getBase(),
                'category' => esc_html__('by EDGE', 'edge-core'),
                'icon' => 'icon-wpb-section-title extended-custom-icon',
                'allowed_container_element' => 'vc_row',
                'params' =>
                    array(
                        array(
                            'type'			=> 'textfield',
                            'heading'		=> esc_html__('Title Text', 'edge-core'),
                            'param_name'	=> 'title_text',
                            'value'			=> '',
                            'admin_label'	=> true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Title Tag', 'edge-core'),
                            'param_name' => 'title_tag',
                            'value' => array(
                                ''   => '',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6',
                            )
                        ),
                        array(
                            'type'			=> 'textfield',
                            'heading'		=> esc_html__('Subtitle Text', 'edge-core'),
                            'param_name'	=> 'subtitle_text',
                            'value'			=> '',
                            'admin_label'	=> true,
                            'description'   => esc_html__('Subtitle text will be appended below to title text', 'edge-core')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Subitle Tag', 'edge-core'),
                            'param_name' => 'subtitle_tag',
                            'value' => array(
                                ''   => '',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6',
                            )
                        ),
                        array(
                            'type'			=> 'dropdown',
                            'heading'		=> esc_html__('Text Align', 'edge-core'),
                            'param_name'	=> 'text_align',
                            'value'			=> array(
                                ''			=> '',
                                esc_html__('Left', 'edge-core')	=> 'left',
                                esc_html__('Center', 'edge-core')	=> 'center',
                                esc_html__('Right', 'edge-core')	=> 'right',
                                esc_html__('Justify', 'edge-core')	=> 'justify'
                            ),
                            'group'			=> esc_html__('Design Options', 'edge-core')
                        ),

                        array(
                            'type'        => 'colorpicker',
                            'heading'     => esc_html__('Title Text Color', 'edge-core'),
                            'param_name'  => 'title_text_color',
                            'dependency'  => array('element' => 'title_text', 'not_empty' => true),
                            'group'			=> esc_html__('Design Options', 'edge-core')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title Text Size (px)', 'edge-core'),
                            'param_name' => 'title_text_size',
                            'dependency' => array('element' => 'title_text', 'not_empty' => true),
                            'group'			=> esc_html__('Design Options', 'edge-core')
                        ),
                        array(
                            'type'        => 'colorpicker',
                            'heading'     => esc_html__('Subtitle Text Color', 'edge-core'),
                            'param_name'  => 'subtitle_text_color',
                            'dependency'  => array('element' => 'subtitle_text', 'not_empty' => true),
                            'group'			=> esc_html__('Design Options', 'edge-core')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('SubTitle Text Size (px)', 'edge-core'),
                            'param_name' => 'subtitle_text_size',
                            'dependency' => array('element' => 'subtitle_text', 'not_empty' => true),
                            'group'			=> esc_html__('Design Options', 'edge-core')
                        ),
                        array(
                            'type'       => 'attach_image',
                            'heading'    => esc_html__('Image', 'edge-core'),
                            'param_name' => 'separator_image'
                        ),
                        array(
                            'type' => 'textarea_html',
                            'heading' => esc_html__('Content', 'edge-core'),
                            'param_name' => 'content',
                            'value' => '<p>' . esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'edge-core') . '</p>',
                            'description' => '',
                        )
                    )
            ));
        };
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param null $content
     * @return string
     */
    public function render($atts, $content = null) {

        $args = array(
            'title_text' => '',
            'title_tag' => 'h2',
            'subtitle_text' => '',
            'subtitle_tag' => 'h5',
            'text' => '',
            'text_align' => 'center',
            'title_text_color' => '',
            'title_text_size' => '',
            'subtitle_text_color'	=> '',
            'subtitle_text_size' => '',
            'separator_image'	=> '',
        );

        $args = array_merge($args, eldritch_edge_icon_collections()->getShortcodeParams());
        $params = shortcode_atts($args, $atts);
        $params['content'] = $content;

        $params['classes'] = $this->getTitleSectionClass($params);
        $params['title_style'] = $this->getTitleStyle($params);
        $params['subtitle_style'] = $this->getSubtitleStyle($params);
        $params['separator_image_src'] = $this->getSeparatorImage($params);

        //Get HTML from template
        $html = edge_core_get_core_shortcode_template_part('templates/section-title-template', 'section-title', '', $params);

        return $html;

    }

    /**
     * Generates classes for title section
     *
     * @param $params
     *
     * @return array
     */
    private function getTitleSectionClass($params){
        $classes = array();
        $classes[] = 'edgt-section-title';

        if ($params['text_align'] != ''){
            $classes[] = 'edgt-section-align-'.$params['text_align'];
        }

        return $classes;
    }

    /**
     * Generates style for title text
     *
     * @param $params
     *
     * @return string
     */
    private function getTitleStyle($params){
        $title_style = array();

        if ($params['title_text_color'] != ''){
            $title_style[] = 'color: '.$params['title_text_color'];
        }

        if ($params['title_text_size'] != ''){
            $title_style[] = 'font-size: '.eldritch_edge_filter_px($params['title_text_size']).'px';
        }

        return implode(';', $title_style);
    }

    /**
     * Generates style for title subtitle text
     *
     * @param $params
     *
     * @return string
     */
    private function getSubtitleStyle($params){
        $subtitle_style = array();

        if ($params['subtitle_text_color'] != ''){
            $subtitle_style[] = 'color: '.$params['subtitle_text_color'];
        }

        if ($params['subtitle_text_size'] != '') {
            $subtitle_style[] = 'font-size: ' . eldritch_edge_filter_px($params['subtitle_text_size']) . 'px';
        }

        return implode(';', $subtitle_style);
    }

    /**
     * Return Separator image
     *
     * @param $params
     *
     * @return false|string
     */
    private function getSeparatorImage($params) {

        if (is_numeric($params['separator_image'])) {
            $separator_image_src = wp_get_attachment_url($params['separator_image']);
        } else {
            $separator_image_src = $params['separator_image'];
        }

        return $separator_image_src;

    }
}