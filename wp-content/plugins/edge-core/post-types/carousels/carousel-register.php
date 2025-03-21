<?php
namespace EdgeCore\CPT\Carousels;

use EdgeCore\Lib;

/**
 * Class CarouselRegister
 * @package EdgeCore\CPT\Carousels
 */
class CarouselRegister implements Lib\PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	/**
	 * @var string
	 */
	private $taxBase;

	public function __construct() {
		$this->base = 'carousels';
		$this->taxBase = 'carousels_category';
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
	}

	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		global $eldritch_Framework;

		$menuPosition = 5;
		$menuIcon = 'dashicons-admin-post';
		if (edgt_core_theme_installed()) {
			$menuPosition = $eldritch_Framework->getSkin()->getMenuItemPosition('carousel');
			$menuIcon = $eldritch_Framework->getSkin()->getMenuIcon('carousel');
		}

		register_post_type($this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__('Edge Carousel', 'edge-core'),
					'menu_name'     => esc_html__('Edge Carousel', 'edge-core'),
					'all_items'     => esc_html__('Carousel Items', 'edge-core'),
					'add_new'       => esc_html__('Add New Carousel Item', 'edge-core'),
					'singular_name' => esc_html__('Carousel Item', 'edge-core'),
					'add_item'      => esc_html__('New Carousel Item', 'edge-core'),
					'add_new_item'  => esc_html__('Add New Carousel Item', 'edge-core'),
					'edit_item'     => esc_html__('Edit Carousel Item', 'edge-core')
				),
				'public'        => false,
				'show_in_menu'  => true,
				'rewrite'       => array('slug' => 'carousels'),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'has_archive'   => false,
				'hierarchical'  => false,
				'supports'      => array('title'),
				'menu_icon'     => $menuIcon
			)
		);
	}

	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__('Carousels', 'edge-core'),
			'singular_name'     => esc_html__('Carousel', 'edge-core'),
			'search_items'      => esc_html__('Search Carousels', 'edge-core'),
			'all_items'         => esc_html__('All Carousels', 'edge-core'),
			'parent_item'       => esc_html__('Parent Carousel', 'edge-core'),
			'parent_item_colon' => esc_html__('Parent Carousel:', 'edge-core'),
			'edit_item'         => esc_html__('Edit Carousel', 'edge-core'),
			'update_item'       => esc_html__('Update Carousel', 'edge-core'),
			'add_new_item'      => esc_html__('Add New Carousel', 'edge-core'),
			'new_item_name'     => esc_html__('New Carousel Name', 'edge-core'),
			'menu_name'         => esc_html__('Carousels', 'edge-core'),
		);

		register_taxonomy($this->taxBase, array($this->base), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array('slug' => 'carousels-category'),
		));
	}

}