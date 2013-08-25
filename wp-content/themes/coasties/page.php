<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>

	<div id="page">
		<div class="wrapper">
			<?php wp_nav_menu('menu=sidebar&menu_class=sidebar&menu_id=sidebar'); ?>
			<header>
				<h2><?php the_title(); ?></h2>
				<?php if ( has_post_thumbnail() ) { ?>
					<?php
						if ( '' != get_the_post_thumbnail() )
							the_post_thumbnail( 'featured-thumbnail-large' );
					?>
				<?php } ?>
			</header>
			<?php wp_nav_menu('menu=info&menu_class=sidebar&menu_id=customer'); ?> 
			<div class="post">
				<div class="panel">

					<div class="content">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; else: ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php get_footer(); ?>
