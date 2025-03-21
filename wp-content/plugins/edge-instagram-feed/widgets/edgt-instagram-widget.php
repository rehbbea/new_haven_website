<?php
if (!defined('ABSPATH')) {
	exit;
}

class EdgeInstagramWidget extends WP_Widget {

	protected $params;

	public function __construct() {
		parent::__construct(
			'edgt_instagram_widget',
			esc_html__('Edge Instagram Widget', 'edge-instagram-feed'),
			array('description' => esc_html__('Display instagram images', 'edge-instagram-feed'))
		);

		$this->setParams();
	}

	protected function setParams() {
		$this->params = array(
			array(
				'name'  => 'title',
				'type'  => 'textfield',
				'title' => esc_html__('Title', 'edge-instagram-feed')
			),
			array(
				'name'  => 'number_of_photos',
				'type'  => 'textfield',
				'title' => esc_html__('Number of photos', 'edge-instagram-feed')
			),
			array(
				'name'    => 'number_of_cols',
				'type'    => 'dropdown',
				'title'   => esc_html__('Number of columns', 'edge-instagram-feed'),
				'options' => array(
					'2' => esc_html__('Two', 'edge-instagram-feed'),
					'3' => esc_html__('Three', 'edge-instagram-feed'),
					'4' => esc_html__('Four', 'edge-instagram-feed'),
					'6' => esc_html__('Six', 'edge-instagram-feed'),
					'8' => esc_html__('Eight', 'edge-instagram-feed'),
					'9' => esc_html__('Nine', 'edge-instagram-feed'),
				)
			),
			array(
				'name'    => 'space_between_cols',
				'type'    => 'dropdown',
				'title'   => esc_html__('Space Between Columns?', 'edge-instagram-feed'),
				'options' => array(
					'yes' => esc_html__('Yes', 'edge-instagram-feed'),
					'no'  => esc_html__('No', 'edge-instagram-feed')
				)
			),
			array(
				'name'    => 'show_overlay',
				'type'    => 'dropdown',
				'title'   => esc_html__('Show Overlay?', 'edge-instagram-feed'),
				'options' => array(
					'yes' => esc_html__('Yes', 'edge-instagram-feed'),
					'no'  => esc_html__('No', 'edge-instagram-feed')
				)
			),
			array(
				'name'  => 'transient_time',
				'type'  => 'textfield',
				'title' => esc_html__('Images Cache Time', 'edge-instagram-feed')
			),
		);
	}

	public function getParams() {
		return $this->params;
	}

	public function widget($args, $instance) {
		extract($instance);

		$title              = !empty($title) ? $title : '';
		$number_of_photos   = !(empty($number_of_photos)) ? $number_of_photos : '6';
		$transient_time     = ! empty( $transient_time ) ? $transient_time : '10800';
		$number_of_cols     = !empty($number_of_cols) ? $number_of_cols : '3';
		$show_overlay       = !empty($show_overlay) ? $show_overlay : '';
		$space_between_cols = !empty($space_between_cols) ? $space_between_cols : '';

		echo eldritch_edge_get_module_part($args['before_widget']);

		if ($title !== '') {
			echo eldritch_edge_get_module_part($args['before_title']);
			echo eldritch_edge_get_module_part($title);
			echo eldritch_edge_get_module_part($args['after_title']);
		}

		$instagram_api = EdgeInstagramApi::getInstance();
		$images_array = $instagram_api->getImages($number_of_photos, array(
			'use_transients' => true,
			'transient_name' => $args['widget_id'],
			'transient_time' => $transient_time
		));

		$number_of_cols = $number_of_cols == '' ? 3 : $number_of_cols;
		$space_between_cols = $space_between_cols == 'yes' ? '' : 'without-space';
		$show_overlay = $show_overlay == 'yes' ? true : false;

		if (is_array($images_array) && count($images_array)) { ?>
			<ul class="edgt-instagram-feed clearfix edgt-col-<?php echo esc_attr($number_of_cols); ?> <?php echo esc_attr($space_between_cols); ?>">
				<?php
				foreach ($images_array as $image) { ?>
					<li>
						<div class="edgt-instagram-item-holder">
							<a href="<?php echo esc_url($instagram_api->getHelper()->getImageLink($image)); ?>"
							   target="_blank">
								<?php if (function_exists('eldritch_edge_kses_img')) : ?>
									<?php echo eldritch_edge_kses_img($instagram_api->getHelper()->getImageHTML($image)); ?>
								<?php else : ?>
									<?php echo eldritch_edge_get_module_part($instagram_api->getHelper()->getImageHTML($image)); ?>
								<?php endif; ?>

								<?php if ($show_overlay) : ?>

									<div class="edgt-instagram-overlay">
										<div class="edgt-instagram-overlay-inner">
											<div class="edgt-instagram-overlay-inner2">
												<span
													class="overlay-icon social-instagram"><?php echo eldritch_edge_icon_collections()->renderIcon('social_instagram', 'font_elegant'); ?></span>
											</div>
										</div>
									</div>

								<?php endif; ?>
							</a>
						</div>
					</li>
				<?php } ?>
			</ul>
		<?php }

		echo eldritch_edge_get_module_part($args['after_widget']);
	}

	public function form($instance) {
		foreach ($this->params as $param_array) {
			$param_name = $param_array['name'];
			${$param_name} = isset($instance[$param_name]) ? esc_attr($instance[$param_name]) : '';
		}

		//user has connected with instagram. Show form
		if (get_option('edgt_instagram_code')) {
			foreach ($this->params as $param) {
				switch ($param['type']) {
					case 'textfield':
						?>
						<p>
							<label for="<?php echo esc_attr($this->get_field_id($param['name'])); ?>"><?php echo
								esc_html($param['title']); ?></label>
							<input class="widefat" id="<?php echo esc_attr($this->get_field_id($param['name'])); ?>"
								   name="<?php echo esc_attr($this->get_field_name($param['name'])); ?>" type="text"
								   value="<?php echo esc_attr(${$param['name']}); ?>"/>
						</p>
						<?php
						break;
					case 'dropdown':
						?>
						<p>
							<label for="<?php echo esc_attr($this->get_field_id($param['name'])); ?>"><?php echo
								esc_html($param['title']); ?></label>
							<?php if (isset($param['options']) && is_array($param['options']) && count($param['options'])) { ?>
								<select class="widefat"
										name="<?php echo esc_attr($this->get_field_name($param['name'])); ?>"
										id="<?php echo esc_attr($this->get_field_id($param['name'])); ?>">
									<?php foreach ($param['options'] as $param_option_key => $param_option_val) {
										$option_selected = '';
										if (${$param['name']} == $param_option_key) {
											$option_selected = 'selected';
										}
										?>
										<option <?php echo esc_attr($option_selected); ?>
											value="<?php echo esc_attr($param_option_key); ?>"><?php echo esc_attr($param_option_val); ?></option>
									<?php } ?>
								</select>
							<?php } ?>
						</p>

						<?php
						break;
				}
			}
		} else { ?>
			<p><?php esc_html_e('You haven\'t connected with Instagram. Please go to Edge Options -> Social page and connect with your Instagram account.', 'edgt_instagram_feed'); ?></p>
		<?php }
	}
}

function edgt_instagram_widget_load() {
	register_widget('EdgeInstagramWidget');
}

add_action('widgets_init', 'edgt_instagram_widget_load');