<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) return;

$text = $post->post_excerpt;
$text = truncate($text, 230);
?>
<div itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $text ) ?>
</div>