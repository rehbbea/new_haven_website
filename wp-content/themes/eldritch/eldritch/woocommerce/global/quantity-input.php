<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset ( $input_id ) ) {
	$input_id = uniqid( 'quantity_' );
}

if ($max_value && $min_value === $max_value) {
	?>
	<div class="edgt-quantity-buttons quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_attr__( '%s quantity', 'eldritch' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_attr__( 'Quantity', 'eldritch' );
	?>
	<div class="quantity edgt-quantity-buttons">
        <?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<span class="edgt-quantity-plus lnr lnr-chevron-up"></span>
		<input 
            type="text"
            id="<?php echo esc_attr( $input_id ); ?>"
            step="<?php echo esc_attr($step); ?>"
            min="<?php echo esc_attr($min_value); ?>"
            max="<?php echo esc_attr($max_value); ?>"
            name="<?php echo esc_attr($input_name); ?>"
            value="<?php echo esc_attr($input_value); ?>"
            title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'eldritch') ?>"
            class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?> edgt-quantity-input"
            size="4"
            placeholder="<?php echo esc_attr( $placeholder ); ?>"
            pattern="<?php echo esc_attr($pattern); ?>"
            inputmode="<?php echo esc_attr($inputmode); ?>"/>
		<span class="edgt-quantity-minus lnr lnr-chevron-down"></span>
        <?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
    </div>
<?php
}