<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<ul class="variation">
	<?php foreach ( $item_data as $data ) : ?>
		<li><?php echo wp_kses_post( $data['value'] ); ?> <?php echo esc_html( $data['key'] ); ?>s</li>
	<?php endforeach; ?>
</ul>