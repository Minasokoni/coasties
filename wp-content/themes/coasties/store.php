<?php
/**
 * Template Name: Store
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="row">
		<div class="wrapper">
			<h3 class="small-12 small-centered columns center title"><?php the_title(); ?></h3>
			<span class="dash-berlin"></span>
		</div>
	</div>
	<div class="wrapper">
			<?php the_content(); ?>
	</div>
		<?php endwhile; else: ?>
		<?php endif; ?>
<?php get_footer(); ?>