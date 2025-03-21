<?php

$thumb_size = $this_object->getImageSize($params);
if($thumb_size == 'full' && edge_cpt_portfolio_masonry_item_image_size() != '') {
	$thumb_size = edge_cpt_portfolio_masonry_item_image_size();
}
?>
<div class="edgt-pli-image">
	<?php if(has_post_thumbnail()) { ?>
		<?php echo get_the_post_thumbnail(get_the_ID(),$thumb_size); ?>
	<?php } else { ?>
		<img itemprop="image" class="edgt-pl-original-image" width="800" height="600" src="<?php echo EDGE_ASSETS_ROOT.'/img/portfolio_featured_image.jpg'; ?>" alt="<?php esc_attr_e('Portfolio Featured Image', 'edge-core'); ?>" />
	<?php } ?>
</div>