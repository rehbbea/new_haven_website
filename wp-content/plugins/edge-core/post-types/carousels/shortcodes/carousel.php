<?php
namespace EdgeCore\CPT\Carousels\Shortcodes;

use EdgeCore\Lib;

/**
 * Class Carousel
 * @package EdgeCore\CPT\Carousels\Shortcodes
 */
class Carousel implements Lib\ShortcodeInterface
{
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'edgt_carousel';

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
            'name' => esc_html__('Carousel', 'edge-core'),
            'base' => $this->base,
            'category' => esc_html__( 'by EDGE', 'edge-core' ),
            'icon' => 'icon-wpb-carousel-slider extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Carousel Slider', 'edge-core'),
                    'param_name' => 'carousel',
                    'value' => edgt_core_get_carousel_slider_array_vc(),
                    'description' => '',
                    'admin_label' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Order By', 'edge-core'),
                    'param_name' => 'orderby',
                    'value' => array(
                        '' => '',
                        esc_html__('Title', 'edge-core') => 'title',
                        esc_html__('Date', 'edge-core') => 'date',
                    ),
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Order', 'edge-core'),
                    'param_name' => 'order',
                    'value' => array(
                        '' => '',
                        esc_html__('ASC', 'edge-core') => 'ASC',
                        esc_html__('DESC', 'edge-core') => 'DESC',
                    ),
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Number of items showing', 'edge-core'),
                    'param_name' => 'number_of_items',
                    'value' => array(
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6'
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Image Animation', 'edge-core'),
                    'param_name' => 'image_animation',
                    'value' => array(
                        esc_html__('Image Change', 'edge-core') => 'image-change',
                        esc_html__('Image Zoom', 'edge-core') => 'image-zoom'
                    ),
                    'admin_label' => true,
                    'save_always' => true,
                    'description' => esc_html__('Note: Only on "Image Change" zoom image will be used', 'edge-core')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Show navigation?', 'edge-core'),
                    'param_name' => 'show_navigation',
                    'value' => array(
                        esc_html__('Yes', 'edge-core') => 'yes',
                        esc_html__('No', 'edge-core') => 'no',
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => esc_html__('Number of Rows', 'edge-core'),
                    'param_name' => 'show_items_in_rows',
                    'value' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5'
                    ),
                    'description' => ''
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Enable border between items', 'edge-core'),
                    'param_name' => 'border',
                    'value' => array(
                        esc_html__('Yes', 'edge-core') => 'yes',
                        esc_html__('No', 'edge-core') => 'no',
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                    'description' => '',
                    'dependency' => array('element' => 'show_items_in_rows', 'not_empty' => true)
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

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     *
     * @return string
     */
    public function render($atts, $content = null) {

        $args = array(
            'carousel' => '',
            'orderby' => 'date',
            'order' => 'ASC',
            'number_of_items' => '5',
            'image_animation' => 'image-change',
            'show_navigation' => '',
            'show_items_in_rows' => '',
            'border' => '',
            'skin' => '',
        );

        $params = shortcode_atts($args, $atts);
        $params['carousel_data_attributes'] = $this->getCarouselDataAttributes($params);

        extract($params);

        $html = '';

        if ($carousel !== '') {

            if ($show_items_in_rows === '1') {
                $carousel_holder_classes = 'edgt-carousel-one-row';
            } elseif ($show_items_in_rows === '2') {
                $carousel_holder_classes = 'edgt-carousel-two-rows';
            } else {
                $carousel_holder_classes = 'edgt-carousel-three-rows';
            }

            if ($show_navigation == 'yes') {
                $carousel_holder_classes .= ' edgt-carousel-navigation'; // needs spacing before class name
            }

            $carousel_holder_classes .= ' ' . $params['skin']; // needs spacing before class name

            $html .= ' <div class="edgt-carousel-holder clearfix ' . $carousel_holder_classes . '">';
            $html .= '<div class="edgt-carousel " ' . eldritch_edge_get_inline_attrs($carousel_data_attributes) . '>';

            $args = array(
                'post_type' => 'carousels',
                'carousels_category' => $params['carousel'],
                'orderby' => $params['orderby'],
                'order' => $params['order'],
                'posts_per_page' => '-1'
            );

            $query = new \WP_Query($args);

            $post_count = 1;
            $posts_number = count($query->posts);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $carousel_item = $this->getCarouselItemData(get_the_ID(), $params);

                    $border_style = '';
                    if ($border == 'yes') {
                        $border_style = 'border';
                    }

                    if (($post_count % 5 === 1 || $post_count === 1) && $show_items_in_rows === '5') {
                        $html .= ' <div class="edgt-carousel-item-outer-holder ' . $border_style . '">';
                    } elseif (($post_count % 4 === 1 || $post_count === 1) && $show_items_in_rows === '4') {
                        $html .= ' <div class="edgt-carousel-item-outer-holder ' . $border_style . '">';
                    } elseif (($post_count % 3 === 1 || $post_count === 1) && $show_items_in_rows === '3') {
                        $html .= ' <div class="edgt-carousel-item-outer-holder ' . $border_style . '">';
                    } elseif (($post_count % 2 === 1 || $post_count === 1) && $show_items_in_rows === '2') {
                        $html .= ' <div class="edgt-carousel-item-outer-holder ' . $border_style . '">';
                    } elseif ($show_items_in_rows == '') {
                        $html .= ' <div class="edgt-carousel-item-outer-holder ' . $border_style . '">';
                    }

                    $html .= edgt_core_get_shortcode_module_template_part('templates/carousel-template', 'carousels', '', $carousel_item);

                    if ($post_count % 5 === 0 && $show_items_in_rows === '5') {
                        $html .= ' </div>';
                    } elseif ($post_count % 4 === 0 && $show_items_in_rows === '4') {
                        $html .= ' </div>';
                    } elseif ($post_count % 3 === 0 && $show_items_in_rows === '3') {
                        $html .= ' </div>';
                    } elseif ($post_count % 2 === 0 && $show_items_in_rows === '2') {
                        $html .= ' </div>';
                    } elseif ($show_items_in_rows == '') {
                        $html .= ' </div>';
                    } elseif ($post_count === $posts_number) {
                        $html .= '</div>';
                    }
                    $post_count++;
                }
            }

            wp_reset_postdata();


            $html .= '</div>';
            $html .= '</div>';

        }

        return $html;
    }

    /**
     * Return all data that carousel needs, images, titles, links, etc
     *
     * @param $params
     *
     * @return array
     */
    private function getCarouselItemData($item_id, $params) {

        $carousel_item = array();

        if (($meta_temp = get_post_meta($item_id, 'edgt_carousel_image', true)) !== '') {
            $carousel_item['image'] = $meta_temp;
            $carousel_item['image_id'] = edgt_core_get_attachment_id_from_url($carousel_item['image']);
        } else {
            $carousel_item['image'] = '';
        }

        if ($params['image_animation'] == 'image-change' && ($meta_temp = get_post_meta($item_id, 'edgt_carousel_hover_image', true)) !== '') {
            $carousel_item['hover_image'] = $meta_temp;
            $carousel_item['hover_class'] = 'edgt-has-hover-image';
            $carousel_item['hover_image_id'] = edgt_core_get_attachment_id_from_url($carousel_item['hover_image']);
        } else {
            $carousel_item['hover_image'] = '';
            $carousel_item['hover_class'] = '';
        }

        if (($meta_temp = get_post_meta($item_id, 'edgt_carousel_item_link', true)) != '') {
            $carousel_item['link'] = $meta_temp;
        } else {
            $carousel_item['link'] = '';
        }

        if (($meta_temp = get_post_meta($item_id, 'edgt_carousel_item_target', true)) != '') {
            $carousel_item['target'] = $meta_temp;
        } else {
            $carousel_item['target'] = '_self';
        }

        $carousel_item['title'] = get_the_title();

        $carousel_item['carousel_image_classes'] = $this->getCarouselImageClasses($params);

        return $carousel_item;

    }

    /**
     * Return CSS classes for carousel image
     *
     * @param $params
     *
     * @return array
     */
    private function getCarouselImageClasses($params) {

        $carousel_image_classes = array();
        if ($params['image_animation'] !== '') {
            $carousel_image_classes[] = 'edgt-' . $params['image_animation'];
        }

        return implode(' ', $carousel_image_classes);

    }

    /**
     * Return data attributes for carousel
     *
     * @param $params
     *
     * @return array
     */
    private function getCarouselDataAttributes($params) {

        $carousel_data = array();

        if ($params['number_of_items'] !== '') {
            $carousel_data['data-items'] = $params['number_of_items'];
        }

        if ($params['show_navigation'] !== '') {
            $carousel_data['data-navigation'] = $params['show_navigation'];
        }

        return $carousel_data;

    }


}