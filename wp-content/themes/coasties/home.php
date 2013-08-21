<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>

	<div id="slider">
		<ul>
		  <li>
			<div class="row">
				<div class="wrapper">
					<div class="small-12 large-centered columns">
						<img src="http://placehold.it/1000x520/636363/ffffff">
					</div>
				</div>
			</div>
		  </li>

		  <li>
			<div class="row">
				<div class="wrapper">
					<div class="small-12 large-centered columns">
						<img src="http://placehold.it/1000x520/636363/ffffff">
					</div>
				</div>
			</div>
		  </li>

		  <li>
			<div class="row">
				<div class="wrapper">
					<div class="small-12 large-centered columns">
						<img src="http://placehold.it/1000x520/636363/ffffff">
					</div>
				</div>
			</div>
		  </li>
		</ul>
		<a href="#" data-direction="prev" class="nav prev"><i class="icon-angle-left"></i></a>
		<a href="#" data-direction="next" class="nav next"><i class="icon-angle-right"></i></a>
	</div>

		<div class="row">
			<div class="wrapper">
				<h3 class="small-12 small-centered columns center title">What is Coasties</h3>
				<span class="dash-berlin"></span>
						<p class="center sub">Coasties professionally hand builds wheels in Port Townsend, Washington for the world over. We started because of our love and commitment to and for coaster brakes. Today that commitment stands and has expanded into building all sorts of custom wheels.  We’re a small, bike loving, customer service oriented group with an unwavering passion for hand building custom wheels.</p>
			</div>
		</div>
		<div class="row">
			<div class="wrapper">
				<div class="big block">
					<div class="overlay"><a href="#">Shop Wheels</a></div>
					<img src="http://lorempixel.com/500/500/transport/"/>
				</div>

				<div class="medium block">
					<div class="overlay"><a href="#">About Coasties</a></div>
					<img src="http://lorempixel.com/480/230/transport/"/>
				</div>

				<div class="small block">
					<div class="overlay"><a href="#">Parts</a></div>
					<img src="http://lorempixel.com/230/250/transport/"/>
				</div>

				<div class="small block">
					<div class="overlay"><a href="#">News</a></div>
					<img src="http://lorempixel.com/230/250/transport/"/>
				</div>
			</div>
		</div>

	<div class="row bottom home">
		<div class="wrapper">
			<h3 class="center title">What's New</h3>
        <?php
            $args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => 3, 'orderby' =>'date','order' => 'DESC' );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				<div <?php post_class( $classes ); ?>>
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
					<a href="<?php the_permalink(); ?>">Shop Now</a>
					<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300" height="300" />'; ?>
					<div class="panel">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?><?php if ( $price_html = $product->get_price_html() ) : ?>
							<span class="price"><?php echo $price_html; ?></span>
							<?php endif; ?>
						</a>
					</div>
				</div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
	</div>

<?php get_footer(); ?>