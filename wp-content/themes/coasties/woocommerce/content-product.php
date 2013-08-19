<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $catalog_mode;

$image_html = "";

if ( has_post_thumbnail() ) {
	$image_html = wp_get_attachment_image( get_post_thumbnail_id(), 'shop_catalog' );					
}else{
	$image_html = '<img src=\''.woocommerce_placeholder_img_src().'\'/>';
}

$tag = "";

if ($product->is_on_sale()) {
	
	$tag = apply_filters('woocommerce_sale_flash', '<span class="badge sale">'.__( 'Sale', 'woocommerce' ).'</span>', $post, $product);

} else if (!$product->get_price()) {
	
	$tag = '<span class="badge free">' . __( 'Free', 'swiftframework' ) . '</span>';
	
} else {

	$postdate 		= get_the_time( 'Y-m-d' );			// Post date
	$postdatestamp 	= strtotime( $postdate );			// Timestamped post date
	$newness 		= 7; 	// Newness in days

	if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
		$tag = '<span class="badge new">' . __( 'New', 'swiftframework' ) . '</span>';
	}
	
}

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3);

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<div <?php post_class( $classes ); ?>>
	<?php echo $tag; ?>
	<a href="<?php the_permalink(); ?>">Shop Now</a>
	<?php echo $image_html; ?>
	<div class="panel">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?><?php if ( $price_html = $product->get_price_html() ) : ?>
			<span class="price"><?php echo $price_html; ?></span>
			<?php endif; ?>
		</a>
	</div>
</div>