<?php
namespace EdgeCore\CPT\Match\Shortcodes;

use EdgeCore\Lib;
use EdgeCore\CPT\Match\Lib as MatchLib;

/**
 * Class MatchFeatured
 * @package EdgeCore\CPT\Match\Shortcodes
 */
class MatchFeatured implements Lib\ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    /**
     * MatchFeatured constructor.
     */
    public function __construct() {
        $this->base = 'edgt_match_featured';

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
     * Maps shortcode to Visual Composer
     *
     * @see vc_map
     */
    public function vcMap() {
        if (function_exists('vc_map')) {
            vc_map(array(
                    'name'                      => esc_html__('Match Featured Items', 'edge-core'),
                    'base'                      => $this->getBase(),
                    'category' => esc_html__( 'by EDGE', 'edge-core' ),
                    'icon'                      => 'icon-wpb-match-featured extended-custom-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array_merge (
                        array(
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Style', 'edge-core'),
                                'param_name'  => 'skin',
                                'value'       => array(
                                    esc_html__('Dark', 'edge-core')  => 'dark',
                                    esc_html__('Light', 'edge-core') => 'light'
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => '',
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Team Name Tag', 'edge-core'),
                                'param_name'  => 'team_title_tag',
                                'value'       => array(
                                    ''   => '',
                                    'h2' => 'h2',
                                    'h3' => 'h3',
                                    'h4' => 'h4',
                                    'h5' => 'h5',
                                    'h6' => 'h6',
                                ),
                                'group'       => esc_html__('Layout Options', 'edge-core'),
                                'description' => ''
                            ),
                            array(
                                'type'        => 'textfield',
                                'admin_label' => true,
                                'heading'     => esc_html__('Image Dimensions', 'edge-core'),
                                'param_name'  => 'custom_image_dimensions',
                                'value'       => '',
                                'description' => esc_html__('Enter custom image dimensions. Enter image size in pixels: 200x100 (Width x Height)', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core'),
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Show Categories', 'edge-core'),
                                'param_name'  => 'show_categories',
                                'value'       => array(
                                    esc_html__('Yes', 'edge-core') => 'yes',
                                    esc_html__('No', 'edge-core')  => 'no',
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => esc_html__('Default value is Yes', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Show Date', 'edge-core'),
                                'param_name'  => 'show_date',
                                'value'       => array(
                                    esc_html__('Yes', 'edge-core') => 'yes',
                                    esc_html__('No', 'edge-core')  => 'no',
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => esc_html__('Default value is Yes', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__('Show Result', 'edge-core'),
                                'param_name'  => 'show_result',
                                'value'       => array(
                                    esc_html__('No', 'edge-core')  => 'no',
                                    esc_html__('Yes', 'edge-core') => 'yes',
                                ),
                                'save_always' => true,
                                'admin_label' => true,
                                'description' => esc_html__('Default value is Yes', 'edge-core'),
                                'group'       => esc_html__('Layout Options', 'edge-core')
                            ),
                        ),
                        MatchLib\MatchQuery::getInstance()->queryVCParams()
                    )
                )
            );
        }
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
            'skin'                          => 'dark',
            'team_title_tag'                => 'h5',
            'custom_image_dimensions'       => '130x130',
            'show_categories'               => 'yes',
            'show_date'                     => 'yes',
            'show_result'                   => 'no',
        );

        $matchQuery = MatchLib\MatchQuery::getInstance();

        $args = array_merge($args, $matchQuery->getShortcodeAtts());

        $params = shortcode_atts($args, $atts);

        extract($params);

        $queryResults = $matchQuery->buildQueryObject($params);
        $params['query_results'] = $queryResults;

        $holder_classes = $this->getMatchHolderClasses($params);

        $html = '';
        $html .= '<div ' . edgt_core_get_class_attribute($holder_classes) . ' >';

        if ($queryResults->have_posts()) {
            while ($queryResults->have_posts()) {
                $queryResults->the_post();

                $new_params = $this->getTeamsOptions($params);
                $new_params['team_title_tag'] = $params['team_title_tag'];

                $html .= edgt_core_get_shortcode_module_template_part('match-featured-items/templates/match', 'match', '', $new_params);
            }

        } else {
            $html .= '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'edge-core') . '</p>';
        }

        wp_reset_postdata();

        $html .= '</div>'; //close edgt-match-featured-holder
        return $html;
    }

    /**
     * Generates match item categories html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemCategoriesHtml($params) {
        $id = get_the_ID();

        $category_html = '';
        if($params['show_categories'] == 'yes') {

            $categories = wp_get_post_terms($id, 'match-category');
            $category_html = '<span class="edgt-match-category-holder">';
            $k = 1;
            foreach ($categories as $cat) {
                $category_html .= '<span>' . $cat->name . '</span>';
                if (count($categories) != $k) {
                    $category_html .= ', ';
                }
                $k++;
            }
            $category_html .= '</span>';
        }

        return $category_html;
    }

    /**
     * Generates match item date html based on id
     *
     * @param $params
     *
     * @return html
     */
    public function getItemDateHtml($params) {
        $id = get_the_ID();
        $html = '';

        if($params['show_date'] == 'yes') {

            $date = get_post_meta($id, 'edgt_match_date_meta', true);

            $dateobj = date_create_from_format('Y-m-d', $date);

            $date = date_format($dateobj, 'jS F Y');


            $time = get_post_meta($id, 'edgt_match_time_meta', true);

            $html = '<span class="edgt-match-date">' . $date . ', ' . $time . '</span>';
        }

        return $html;
    }

    /**
     * Checks if match has external link and returns it. Else returns link to match single page
     *
     * @param $params
     *
     * @return false|mixed|string
     */
    public function getItemLink($params) {

        $match_link_array = array();

        $id = get_the_ID();
        $match_link = get_permalink($id);
        $match_target = '';

        $match_link_array['href'] = $match_link;
        $match_link_array['target'] = $match_target;

        return $match_link_array;

    }

    /**
     * Get shortcode classes
     *
     * @param $params
     *
     * @return string
     */
    public function getMatchHolderClasses($params) {

        $classes = array();

        $classes[] = 'edgt-match-featured-holder';

        if($params['skin'] != '') {
            $classes[] = 'edgt-match-skin-' . $params['skin'];
        }

        return implode(' ', $classes);

    }

    /**
     * Get shortcode classes
     *
     * @param $params
     *
     * @return string
     */
    public function getMatchItemClasses($params) {

        $classes = array();

        $status = get_post_meta($id = get_the_ID(), 'edgt_match_status_meta', true);

        if($status) {
            $classes[] = 'edgt-match-status-' . $status;
        }

        return implode(' ', $classes);

    }

    /**
     * Get versus image
     *
     * @param $params
     *
     * @return string
     */
    public function getVSImageURL($params) {

        $url = '';

        $status = get_post_meta(get_the_ID(), 'edgt_match_status_meta', true);

        if($status == 'finished') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_finished.png';
        }

        if($params['skin'] == 'light') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_light.png';
        }

        if($params['skin'] == 'dark') {
            $url = EDGE_ASSETS_ROOT . '/img/vs_dark.png';
        }

        return $url;

    }

    private function getTeamsOptions($params) {

        $new_params = array();

        $id = get_the_ID();
        $new_params['item_classes'] = $this->getMatchItemClasses($params);
        $new_params['link_atts'] = $this->getItemLink($params);
        $new_params['vs_image'] = $this->getVSImageURL($params);
        $new_params['custom_image_sizes'] = $this->getCustomImageSize($params['custom_image_dimensions']);

        $new_params['status'] = get_post_meta($id, 'edgt_match_status_meta', true);
        $new_params['category'] = $this->getItemCategoriesHtml($params);
        $new_params['date'] = $this->getItemDateHtml($params);
        $new_params['team_one_name'] = get_post_meta($id, 'edgt_match_team_one_name_meta', true);
        $new_params['team_two_name'] = get_post_meta($id, 'edgt_match_team_two_name_meta', true);
        $new_params['team_one_image'] = get_post_meta($id, 'edgt_match_team_one_image_meta', true);
        $new_params['team_two_image'] = get_post_meta($id, 'edgt_match_team_two_image_meta', true);


        $new_params['result'] = '';
        if($params['show_result'] == 'yes') {
            $new_params['result'] = get_post_meta($id, 'edgt_match_result_meta', true);
        }


        return $new_params;
    }

    private function getCustomImageSize($customImageSize) {
        $imageSize = trim($customImageSize);
        //Find digits
        preg_match_all('/\d+/', $imageSize, $matches);
        if (!empty($matches[0])) {
            return array(
                $matches[0][0],
                $matches[0][1]
            );
        }

        return false;
    }

}