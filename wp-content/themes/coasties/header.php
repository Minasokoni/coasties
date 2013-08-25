<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<script>
/**
 * Replaces class "no-js" with "js" in the <html>-tag when JavaScript is being used.
 * Allows easy styling for browsers [not] supporting/running JavaScript.
 */
document.documentElement.className = document.documentElement.className.replace(/(\s|^)no-js(\s|$)/, '$1js$2');
</script>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">
<?php 
global $woocommerce;
wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<header id="main">
	<div class="wrapper">
		<div id="basket">
			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart' , 'woothemes' ); ?>"><?php echo sprintf(_n('%d item' , '%d items' , $woocommerce->cart->cart_contents_count, 'woothemes' ), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
		</div>
	</div>
	<nav>
		<div class="row">
			<?php wp_nav_menu('menu=main'); ?> 
		</div>
	</nav>
</header>