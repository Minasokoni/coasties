<?php
/**
 * Email Order Items
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

foreach ( $items as $item ) :
	$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
	$item_meta    = new WC_Order_Item_Meta( $item['item_meta'] );
	?>
	<tr>
		<td style="text-align:left; vertical-align:middle; border: 1px solid #eee; word-wrap:break-word;"><?php

			// Show title/image etc
			if ( $show_image )
				echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . current( wp_get_attachment_image_src( get_post_thumbnail_id( $_product->id ), 'thumbnail') ) .'" alt="Product Image" height="' . $image_size[1] . '" width="' . $image_size[0] . '" style="vertical-align:middle; margin-right: 10px;" />', $item );

			// Product name
			echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );

			// SKU
			if ( $show_sku && $_product->get_sku() )
				echo ' (#' . $_product->get_sku() . ')';

			// File URLs
			if ( $show_download_links && $_product->exists() && $_product->is_downloadable() ) {

				$download_file_urls = $order->get_downloadable_file_urls( $item['product_id'], $item['variation_id'], $item );

				$i = 0;

				foreach ( $download_file_urls as $file_url => $download_file_url ) {
					echo '<br/><small>';

					$filename = woocommerce_get_filename_from_url( $file_url );

					if ( count( $download_file_urls ) > 1 ) {
						echo sprintf( __( 'Download %d:', 'woocommerce' ), $i + 1 );
					} elseif ( $i == 0 )
						echo __( 'Download:', 'woocommerce' );

					echo ' <a href="' . $download_file_url . '" target="_blank">' . $filename . '</a></small>';

					$i++;
				}
			}

			// Variation
			if ( $item_meta->meta )
				echo '<br/><small>' . nl2br( $item_meta->display( true, true ) ) . '</small>';

		?></td>
		<td style="text-align:left; vertical-align:middle; border: 1px solid #eee;"><?php echo $item['qty'] ;?></td>
		<td style="text-align:left; vertical-align:middle; border: 1px solid #eee;"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td>
	</tr>

	<?php if ( $show_purchase_note && $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) : ?>
		<tr>
			<td colspan="3" style="text-align:left; vertical-align:middle; border: 1px solid #eee;"><?php echo apply_filters( 'the_content', $purchase_note ); ?></td>
		</tr>
	<?php endif; ?>

<?php endforeach; ?>