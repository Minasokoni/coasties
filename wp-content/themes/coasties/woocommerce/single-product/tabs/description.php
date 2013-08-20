<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

$heading = esc_html( apply_filters('woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );

$content =  get_the_content();
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);


?>
<?php if(get_field('product_specs') != ""){ ?>
<div class="specs">
	<h2>Specs</h2>
	<?php the_field('product_specs'); ?>
</div>
<? } ?>


<div class="description">
	<h2><?php echo $heading; ?></h2>
	<p><?php echo truncate($content, 500); ?></p>
</div>

<div id="custom">
	<h4>Don't see the rim color you want?</h4>
	<p>E-mail us with your color requests and we’ll<b/r>do our best to accommodate you.</p>
	<a href="mailto:@gmail.com">Contact us</a>
</div>