<?php
namespace EdgeCore\CPT\Match;

use EdgeCore\Lib\PostTypeInterface;

/**
 * Class MatchRegister
 * @package EdgeCore\CPT\Match
 */
class MatchRegister implements PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;

	/**
	 * @var string
	 */
	private $taxBase;

	function __construct() {
		$this->base    = 'match-item';
		$this->taxBase = 'match-category';

		add_filter('single_template', array($this, 'registerSingleTemplate'));
	}

	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Registers custom post type with WordPress
	 */
	public function register() {
		$this->registerPostType();
		$this->registerTax();
		$this->registerTagTax();
	}

	/**
	 * Registers match single template if one does'nt exists in theme.
	 * Hooked to single_template filter
	 *
	 * @param $single string current template
	 *
	 * @return string string changed template
	 */
	public function registerSingleTemplate($single) {
		global $post;

		if($post->post_type == $this->base) {
			if(!file_exists(get_template_directory().'/single-match-item.php')) {
				return EDGE_CORE_CPT_PATH.'/match/templates/single-'.$this->base.'.php';
			}
		}

		return $single;
	}

	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		global $eldritch_Framework, $eldritch_options;

		$menuPosition = 5;
		$menuIcon     = 'dashicons-admin-post';
		$slug         = $this->base;

		if(edgt_core_theme_installed()) {
			$menuPosition = $eldritch_Framework->getSkin()->getMenuItemPosition('match');
			$menuIcon     = $eldritch_Framework->getSkin()->getMenuIcon('match');

			if(isset($eldritch_options['match_single_slug'])) {
				if($eldritch_options['match_single_slug'] != "") {
					$slug = $eldritch_options['match_single_slug'];
				}
			}
		}

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Match', 'edge-core'),
					'singular_name' => esc_html__('Match Item', 'edge-core'),
					'add_item'      => esc_html__('New Match Item', 'edge-core'),
					'add_new_item'  => esc_html__('Add New Match Item', 'edge-core'),
					'edit_item'     => esc_html__('Edit Match Item', 'edge-core')
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array('slug' => $slug),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'supports'      => array(
					'author',
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'page-attributes',
					'comments'
				),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Match Categories', 'taxonomy general name'),
			'singular_name'     => esc_html__('Match Category', 'taxonomy singular name'),
			'search_items'      => esc_html__('Search Match Categories', 'edge-core'),
			'all_items'         => esc_html__('All Match Categories', 'edge-core'),
			'parent_item'       => esc_html__('Parent Match Category', 'edge-core'),
			'parent_item_colon' => esc_html__('Parent Match Category:', 'edge-core'),
			'edit_item'         => esc_html__('Edit Match Category', 'edge-core'),
			'update_item'       => esc_html__('Update Match Category', 'edge-core'),
			'add_new_item'      => esc_html__('Add New Match Category', 'edge-core'),
			'new_item_name'     => esc_html__('New Match Category Name', 'edge-core'),
			'menu_name'         => esc_html__('Match Categories', 'edge-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical' => true,
			'labels'       => $labels,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'match-category'),
		));
	}

	/**
	 * Registers custom tag taxonomy with WordPress
	 */
	private function registerTagTax() {
		$labels = array(
			'name'              => esc_html__('Match Tags', 'taxonomy general name'),
			'singular_name'     => esc_html__('Match Tag', 'taxonomy singular name'),
			'search_items'      => esc_html__('Search Match Tags', 'edge-core'),
			'all_items'         => esc_html__('All Match Tags', 'edge-core'),
			'parent_item'       => esc_html__('Parent Match Tag', 'edge-core'),
			'parent_item_colon' => esc_html__('Parent Match Tags:', 'edge-core'),
			'edit_item'         => esc_html__('Edit Match Tag', 'edge-core'),
			'update_item'       => esc_html__('Update Match Tag', 'edge-core'),
			'add_new_item'      => esc_html__('Add New Match Tag', 'edge-core'),
			'new_item_name'     => esc_html__('New Match Tag Name', 'edge-core'),
			'menu_name'         => esc_html__('Match Tags', 'edge-core'),
		);

		register_taxonomy('match-tag', array($this->base), array(
			'hierarchical' => false,
			'labels'       => $labels,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'match-tag'),
		));
	}
}