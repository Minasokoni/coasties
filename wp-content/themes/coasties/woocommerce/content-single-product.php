<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" data-type="main-window" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		#do_action( 'woocommerce_after_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

		<a href="#" id="guide-btn">Customization guide</a>

	</div><!-- .summary -->

</div><!-- #product-<?php the_ID(); ?> -->
<div id="guide">
	<a class="close" href="#"><i class="icon-remove"></i></a>
	<nav>
		<a class="active" href="#rims">Rims</a>
		<a href="#hubs">Hubs</a>
		<a href="#spokes">Spokes</a>
		<a href="#nipples">Nipples</a>
	</nav>
	<section>
		<div id="rims">
			rims
		</div>
		<div id="hubs">hubs</div>
		<div id="spokes">spokes</div>
		<div id="nipples">nipples</div>
	</section>
</div>

<?php 
	add_action('woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10 );
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
	do_action( 'woocommerce_after_single_product' );
	do_action( 'woocommerce_after_single_product_summary' );
?>
