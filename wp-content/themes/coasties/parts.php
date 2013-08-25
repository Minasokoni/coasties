<?php
/**
 * Template Name: Parts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>
<div id="parts">
	<div class="wrapper">
		<?php echo do_shortcode('[recent_products per_page="12" columns="4" orderby="date" order="desc"]'); ?>
	</div>
</div>
<?php get_footer(); ?>