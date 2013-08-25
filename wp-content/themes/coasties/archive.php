<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>

	<div id="blog">
		<div class="wrapper">
			<header></header>
			<ul class="sidebar">
				<li class="title">Blog</li>
				<?php wp_list_categories('title_li&hide_empty=0&exclude=1&order=DESC'); ?> 
			</ul>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div class="post">
				<?php if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyfourteen' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="<?php the_ID(); ?>" class="attachment-featured-thumbnail">
					<?php
						if ( '' != get_the_post_thumbnail() )
							the_post_thumbnail( 'featured-thumbnail-large' );
					?>
				</a>
				<?php } ?>
				<div class="panel">
					<h2><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="info"><p class="date"><?php the_date('M j Y'); ?></p><p class="cat"><?php $category = get_the_category(); if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'">#'.$category[0]->cat_name.'</a>'; } ?></p></div>
					<div class="content"><?php the_excerpt(); ?></div>
				</div>
			</div>

			<?php endwhile; else: ?>
				<h2>No Posts</h2>
			<?php endif; ?>

			<div class="nav">
				<div class="nav-previous left"><?php next_posts_link( '<i class="icon-angle-left"></i> Older' ); ?></div>
				<div class="nav-next right"><?php previous_posts_link( 'Newer <i class="icon-angle-right"></i>' ); ?></div>
			</div>

		</div>
	</div>

<?php get_footer(); ?>