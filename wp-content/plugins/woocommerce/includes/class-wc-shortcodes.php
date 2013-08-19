<?php
/**
 * WC_Shortcodes class.
 *
 * @class 		WC_Shortcodes
 * @version		2.0.0
 * @package		WooCommerce/Classes
 * @category	Class
 * @author 		WooThemes
 */

class WC_Shortcodes {

	public function __construct() {
		// Regular shortcodes
		add_shortcode( 'product', array( $this, 'product' ) );
		add_shortcode( 'product_page', array( $this, 'product_page_shortcode' ) );
		add_shortcode( 'product_category', array( $this, 'product_category' ) );
		add_shortcode( 'product_categories', array( $this, 'product_categories' ) );
		add_shortcode( 'add_to_cart', array( $this, 'product_add_to_cart' ) );
		add_shortcode( 'add_to_cart_url', array( $this, 'product_add_to_cart_url' ) );
		add_shortcode( 'products', array( $this, 'products' ) );
		add_shortcode( 'recent_products', array( $this, 'recent_products' ) );
		add_shortcode( 'sale_products', array( $this, 'sale_products' ) );
		add_shortcode( 'best_selling_products', array( $this, 'best_selling_products' ) );
		add_shortcode( 'top_rated_products', array( $this, 'top_rated_products' ) );
		add_shortcode( 'featured_products', array( $this, 'featured_products' ) );
		add_shortcode( 'woocommerce_messages', array( $this, 'messages_shortcode' ) );
		add_shortcode( 'product_attribute', array( $this, 'product_attribute' ) );
		add_shortcode( 'related_products', array( $this, 'related_products_shortcode' ) );

		// Pages
		add_shortcode( 'woocommerce_cart', array( $this, 'cart' ) );
		add_shortcode( 'woocommerce_checkout', array( $this, 'checkout' ) );
		add_shortcode( 'woocommerce_order_tracking', array( $this, 'order_tracking' ) );
		add_shortcode( 'woocommerce_my_account', array( $this, 'my_account' ) );
	}

	/**
	 * Shortcode Wrapper
	 *
	 * @param mixed $function
	 * @param array $atts (default: array())
	 * @return string
	 */
	public static function shortcode_wrapper(
		$function,
		$atts = array(),
		$wrapper = array(
			'class' => 'woocommerce',
			'before' => null,
			'after' => null
		)
	){
		ob_start();

		$before 	= empty( $wrapper['before'] ) ? '<div class="' . $wrapper['class'] . '">' : $wrapper['before'];
		$after 		= empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];

		echo $before;
		call_user_func( $function, $atts );
		echo $after;

		return ob_get_clean();
	}

	/**
	 * Cart page shortcode.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function cart( $atts ) {
		return $this->shortcode_wrapper( array( 'WC_Shortcode_Cart', 'output' ), $atts );
	}

	/**
	 * Checkout page shortcode.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function checkout( $atts ) {
		return $this->shortcode_wrapper( array( 'WC_Shortcode_Checkout', 'output' ), $atts );
	}

	/**
	 * Order tracking page shortcode.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function order_tracking( $atts ) {
		return $this->shortcode_wrapper( array( 'WC_Shortcode_Order_Tracking', 'output' ), $atts );
	}

	/**
	 * Cart shortcode.
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function my_account( $atts ) {
		return $this->shortcode_wrapper( array( 'WC_Shortcode_My_Account', 'output' ), $atts );
	}

	/**
	 * List products in a category shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product_category( $atts ){
		global $woocommerce_loop;

	  	if ( empty( $atts ) ) return;

		extract( shortcode_atts( array(
			'per_page' 		=> '12',
			'columns' 		=> '4',
		  	'orderby'   	=> 'title',
		  	'order'     	=> 'desc',
		  	'category'		=> '',
		  	'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
			), $atts ) );

		if ( ! $category ) return;

		// Default ordering args
		$ordering_args = WC()->query->get_catalog_ordering_args( $orderby, $order );

	  	$args = array(
			'post_type'				=> 'product',
			'post_status' 			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby' 				=> $ordering_args['orderby'],
			'order' 				=> $ordering_args['order'],
			'posts_per_page' 		=> $per_page,
			'meta_query' 			=> array(
				array(
					'key' 			=> '_visibility',
					'value' 		=> array('catalog', 'visible'),
					'compare' 		=> 'IN'
				)
			),
			'tax_query' 			=> array(
		    	array(
			    	'taxonomy' 		=> 'product_cat',
					'terms' 		=> array( esc_attr( $category ) ),
					'field' 		=> 'slug',
					'operator' 		=> $operator
				)
		    )
		);

		if ( isset( $ordering_args['meta_key'] ) ) {
	 		$args['meta_key'] = $ordering_args['meta_key'];
	 	}

	  	ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}


	/**
	 * List all (or limited) product categories
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product_categories( $atts ) {
		global $woocommerce_loop;

		extract( shortcode_atts( array (
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns' 	 => '4',
			'hide_empty' => 1,
			'parent'     => ''
			), $atts ) );

		if ( isset( $atts[ 'ids' ] ) ) {
			$ids = explode( ',', $atts[ 'ids' ] );
		  	$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
	  	$args = array(
	  		'orderby'    => $orderby,
	  		'order'      => $order,
	  		'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

	  	$product_categories = get_terms( 'product_cat', $args );

	  	if ( $parent !== "" )
	  		$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );

	  	if ( $number )
	  		$product_categories = array_slice( $product_categories, 0, $number );

	  	$woocommerce_loop['columns'] = $columns;

	  	ob_start();

	  	// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

	  	if ( $product_categories ) {

	  		woocommerce_product_loop_start();

			foreach ( $product_categories as $category ) {

				woocommerce_get_template( 'content-product_cat.php', array(
					'category' => $category
				) );

			}

			woocommerce_product_loop_end();

		}

		woocommerce_reset_loop();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * Recent Products shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function recent_products( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'columns' 	=> '4',
			'orderby' => 'date',
			'order' => 'desc'
		), $atts));

		$meta_query = WC()->query->get_meta_query();

		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => $meta_query
		);

		ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}


	/**
	 * List multiple products shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function products( $atts ) {
		global $woocommerce_loop;

	  	if (empty($atts)) return;

		extract(shortcode_atts(array(
			'columns' 	=> '4',
		  	'orderby'   => 'title',
		  	'order'     => 'asc'
			), $atts));

	  	$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' 		=> '_visibility',
					'value' 	=> array('catalog', 'visible'),
					'compare' 	=> 'IN'
				)
			)
		);

		if(isset($atts['skus'])){
			$skus = explode(',', $atts['skus']);
		  	$skus = array_map('trim', $skus);
	    	$args['meta_query'][] = array(
	      		'key' 		=> '_sku',
	      		'value' 	=> $skus,
	      		'compare' 	=> 'IN'
	    	);
	  	}

		if(isset($atts['ids'])){
			$ids = explode(',', $atts['ids']);
		  	$ids = array_map('trim', $ids);
	    	$args['post__in'] = $ids;
		}

	  	ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}


	/**
	 * Display a single product
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product( $atts ) {
	  	if (empty($atts)) return;

	  	$args = array(
	    	'post_type' => 'product',
	    	'posts_per_page' => 1,
	    	'no_found_rows' => 1,
	    	'post_status' => 'publish',
	    	'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				)
			)
	  	);

	  	if(isset($atts['sku'])){
	    	$args['meta_query'][] = array(
	      		'key' => '_sku',
	      		'value' => $atts['sku'],
	      		'compare' => '='
	    	);
	  	}

	  	if(isset($atts['id'])){
	    	$args['p'] = $atts['id'];
	  	}

	  	ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce">' . ob_get_clean() . '</div>';
	}

	/**
	 * Display a single product price + cart button
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product_add_to_cart( $atts ) {
	  	global $wpdb;

	  	if ( empty( $atts ) ) return;

	  	if ( ! isset( $atts['style'] ) ) $atts['style'] = 'border:4px solid #ccc; padding: 12px;';

	  	if ( isset( $atts['id'] ) ) {
	  		$product_data = get_post( $atts['id'] );
		} elseif ( isset( $atts['sku'] ) ) {
			$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $atts['sku'] ) );
			$product_data = get_post( $product_id );
		} else {
			return;
		}

		if ( 'product' == $product_data->post_type ) {

			$product = WC()->setup_product_data( $product_data );

			ob_start();
			?>
			<p class="product woocommerce" style="<?php echo $atts['style']; ?>">

				<?php echo $product->get_price_html(); ?>

				<?php woocommerce_template_loop_add_to_cart(); ?>

			</p><?php

			wp_reset_postdata();

			return ob_get_clean();

		} elseif ( 'product_variation' == $product_data->post_type ) {

			$product = get_product( $product_data->post_parent );

			$GLOBALS['product'] = $product;

			$variation = get_product( $product_data );

			ob_start();
			?>
			<p class="product product-variation" style="<?php echo $atts['style']; ?>">

				<?php echo $product->get_price_html(); ?>

				<?php

				$link 	= $product->add_to_cart_url();

				$label 	= apply_filters('add_to_cart_text', __( 'Add to cart', 'woocommerce' ));

				$link = add_query_arg( 'variation_id', $variation->variation_id, $link );

				foreach ($variation->variation_data as $key => $data) {
					if ($data) $link = add_query_arg( $key, $data, $link );
				}

				printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button add_to_cart_button product_type_%s">%s</a>', esc_url( $link ), $product->id, $product->product_type, $label);

				?>

			</p><?php

			wp_reset_postdata();

			return ob_get_clean();

		}
	}

	/**
	 * Get the add to cart URL for a product
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product_add_to_cart_url( $atts ) {
	  	global $wpdb;

	  	if ( empty( $atts ) ) return;

	  	if ( isset( $atts['id'] ) ) {
	  		$product_data = get_post( $atts['id'] );
		} elseif ( isset( $atts['sku'] ) ) {
			$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $atts['sku'] ) );
			$product_data = get_post( $product_id );
		} else {
			return;
		}

		if ( 'product' !== $product_data->post_type ) return;

		$_product = get_product( $product_data );

		return esc_url( $_product->add_to_cart_url() );
	}

	/**
	 * List all products on sale
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function sale_products( $atts ){
	    global $woocommerce_loop;

	    extract( shortcode_atts( array(
	        'per_page'      => '12',
	        'columns'       => '4',
	        'orderby'       => 'title',
	        'order'         => 'asc'
	        ), $atts ) );

		// Get products on sale
		$product_ids_on_sale = woocommerce_get_product_ids_on_sale();

		$meta_query = array();
		$meta_query[] = WC()->query->visibility_meta_query();
	    $meta_query[] = WC()->query->stock_status_meta_query();
	    $meta_query   = array_filter( $meta_query );

		$args = array(
			'posts_per_page'=> $per_page,
			'orderby' 		=> $orderby,
	        'order' 		=> $order,
			'no_found_rows' => 1,
			'post_status' 	=> 'publish',
			'post_type' 	=> 'product',
			'meta_query' 	=> $meta_query,
			'post__in'		=> $product_ids_on_sale
		);

	  	ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * List best selling products on sale
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function best_selling_products( $atts ){
	    global $woocommerce_loop;

	    extract( shortcode_atts( array(
	        'per_page'      => '12',
	        'columns'       => '4'
	        ), $atts ) );

	    $args = array(
	        'post_type' => 'product',
	        'post_status' => 'publish',
	        'ignore_sticky_posts'   => 1,
	        'posts_per_page' => $per_page,
	        'meta_key' 		 => 'total_sales',
	    	'orderby' 		 => 'meta_value_num',
	        'meta_query' => array(
	            array(
	                'key' => '_visibility',
	                'value' => array( 'catalog', 'visible' ),
	                'compare' => 'IN'
	            )
	        )
	    );

	  	ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * List top rated products on sale
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function top_rated_products( $atts ){
	    global $woocommerce_loop;

	    extract( shortcode_atts( array(
	        'per_page'      => '12',
	        'columns'       => '4',
	        'orderby'       => 'title',
	        'order'         => 'asc'
	        ), $atts ) );

	    $args = array(
	        'post_type' => 'product',
	        'post_status' => 'publish',
	        'ignore_sticky_posts'   => 1,
	        'orderby' => $orderby,
	        'order' => $order,
	        'posts_per_page' => $per_page,
	        'meta_query' => array(
	            array(
	                'key' => '_visibility',
	                'value' => array('catalog', 'visible'),
	                'compare' => 'IN'
	            )
	        )
	    );

	  	ob_start();

	  	add_filter( 'posts_clauses', array( &$this, 'order_by_rating_post_clauses' ) );

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		remove_filter( 'posts_clauses', array( &$this, 'order_by_rating_post_clauses' ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * Output featured products
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function featured_products( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'columns' 	=> '4',
			'orderby' => 'date',
			'order' => 'desc'
		), $atts));

		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				),
				array(
					'key' => '_featured',
					'value' => 'yes'
				)
			)
		);

		ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}


	/**
	 * Show a single product page
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function product_page_shortcode( $atts ) {
	  	if ( empty( $atts ) ) return;

		if ( ! isset( $atts['id'] ) && ! isset( $atts['sku'] ) ) return;

	  	$args = array(
	    	'posts_per_page' 	=> 1,
	    	'post_type'	=> 'product',
	    	'post_status' => 'publish',
	    	'ignore_sticky_posts'	=> 1,
	    	'no_found_rows' => 1
	  	);

	  	if ( isset( $atts['sku'] ) ) {
	    	$args['meta_query'][] = array(
	      		'key'     => '_sku',
	      		'value'   => $atts['sku'],
	      		'compare' => '='
	    	);
	  	}

	  	if ( isset( $atts['id'] ) ) {
	    	$args['p'] = $atts['id'];
	  	}

	  	$single_product = new WP_Query( $args );

	  	ob_start();

		while ( $single_product->have_posts() ) : $single_product->the_post(); wp_enqueue_script( 'wc-single-product' ); ?>

			<div class="single-product">

				<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

			</div>

		<?php endwhile; // end of the loop.

		wp_reset_postdata();

		return '<div class="woocommerce">' . ob_get_clean() . '</div>';
	}


	/**
	 * Show messages
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	public function messages_shortcode() {
		ob_start();

		wc_print_messages();

		return ob_get_clean();
	}

	/**
	 * woocommerce_order_by_rating_post_clauses function.
	 *
	 * @access public
	 * @param mixed $args
	 * @return void
	 */
	public function order_by_rating_post_clauses( $args ) {

		global $wpdb;

		$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

		$args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}


	/**
	 * List products with an attribute shortcode
	 * Example [product_attribute attribute='color' filter='black']
	 *
	 * @access public
	 * @param array $atts
	 * @return string
	 */
	function product_attribute( $atts ) {
		global $woocommerce_loop;

		extract( shortcode_atts( array(
			'per_page'  => '12',
			'columns'   => '4',
			'orderby'   => 'title',
			'order'     => 'asc',
			'attribute' => '',
		  	'filter'    => ''
		), $atts ) );

		$attribute 	= strstr( $attribute, 'pa_' ) ? sanitize_title( $attribute ) : 'pa_' . sanitize_title( $attribute );

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $per_page,
			'orderby'             => $orderby,
			'order'               => $order,
			'meta_query'          => array(
				array(
					'key'               => '_visibility',
					'value'             => array('catalog', 'visible'),
					'compare'           => 'IN'
				)
			),
			'tax_query' 			=> array(
				array(
					'taxonomy' 	=> $attribute,
					'terms'     => array_map( 'sanitize_title', explode( ",", $filter ) ),
					'field' 	=> 'slug'
				)
			)
		);

		ob_start();

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce">' . ob_get_clean() . '</div>';
	}

	function related_products_shortcode( $atts ) {

		$atts = shortcode_atts( array(
			'posts_per_page' => '2',
			'columns' 	     => '2',
			'orderby'        => 'rand',
		), $atts);

		if ( isset( $atts['per_page'] ) ) {
			_deprecated_argument( __CLASS__ . '->' . __FUNCTION__, '2.1', __( 'Use $args["posts_per_page"] instead. Deprecated argument will be removed in WC 2.2.', 'woocommerce' ) );
			$atts['posts_per_page'] = $atts['per_page'];
			unset( $atts['per_page'] );
		}

		ob_start();

		woocommerce_related_products( $atts );

		return ob_get_clean();
	}
}
