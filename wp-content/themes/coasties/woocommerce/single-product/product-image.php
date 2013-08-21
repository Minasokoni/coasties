<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

$attachment_ids = array();

?>
<div class="images">
	
	<?php
	
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
		echo $tag;
	?>
	
	<div id="product-img-slider" class="flexslider">
		<ul class="slides">
			<?php
				if ( has_post_thumbnail() ) {
		
					$image_object		= get_the_post_thumbnail( $post->ID, 'full' );
					$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
					$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
					
					$image = aq_resize( $image_link, 562, NULL, true, false);
					
					if ($image) {
					
					$image_html = '<img class="product-slider-image" data-zoom-image="'.$image_link.'" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" />';
					
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li itemprop="image" data-thumb="'.$image_link.'">%s</li>', $image_html, $image_link, $image_title ), $post->ID );	
					
					}
					
				}
									
				$loop = 0;
				$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
				
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					
					$attachment_ids = $product->get_gallery_attachment_ids();
					
					if ( $attachment_ids ) {
			
						foreach ( $attachment_ids as $attachment_id ) {
				
							$classes = array( 'zoom' );
				
							if ( $loop == 0 || $loop % $columns == 0 )
								$classes[] = 'first';
				
							if ( ( $loop + 1 ) % $columns == 0 )
								$classes[] = 'last';
				
							$image_link = wp_get_attachment_url( $attachment_id );
				
							if ( ! $image_link )
								continue;
							
							$image = aq_resize( $image_link, 562, NULL, true, false);
							
							$image_class = esc_attr( implode( ' ', $classes ) );
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							
							if ($image) {
							
								$image_html = '<img class="product-slider-image" data-zoom-image="'.$image_link.'" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" />';
		
								echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li data-thumb="'.$image_link.'">%s</li>', $image_html, $image_link, $image_class, $image_title ), $attachment_id, $post->ID, $image_class );
							
							}
								
							$loop++;
						}
					
					}
					
				} else {
					
					$attachment_ids = get_posts( array(
						'post_type' 	=> 'attachment',
						'numberposts' 	=> -1,
						'post_status' 	=> null,
						'post_parent' 	=> $post->ID,
						'post__not_in'	=> array( get_post_thumbnail_id() ),
						'post_mime_type'=> 'image',
						'orderby'		=> 'menu_order',
						'order'			=> 'ASC'
					) );
											
					if ($attachment_ids) {
				
						$loop = 0;
						$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
				
						foreach ( $attachment_ids as $key => $attachment ) {
				
							if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 )
								continue;
				
							$classes = array( 'zoom' );
				
							if ( $loop == 0 || $loop % $columns == 0 )
								$classes[] = 'first';
				
							if ( ( $loop + 1 ) % $columns == 0 )
								$classes[] = 'last';
				
							printf( '<a href="%s" title="%s" rel="thumbnails" class="%s">%s</a>', wp_get_attachment_url( $attachment->ID ), esc_attr( $attachment->post_title ), implode(' ', $classes), wp_get_attachment_image( $attachment->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ) );
				
							$loop++;
				
						}					
					}
				}
			?>
		</ul>
	</div>
	
	<?php /* if ( $attachment_ids ) { ?>
	<div id="product-img-nav" class="flexslider">
		<ul class="slides">
			<?php if ( has_post_thumbnail() ) { ?>
			<li itemprop="image"><?php echo get_the_post_thumbnail( $post->ID, 'shop_thumbnail' ); ?></li>
			<?php } ?>
			<?php do_action( 'woocommerce_product_thumbnails' ); ?>
		</ul>
	</div>
	
	<?php } */?>


</div>