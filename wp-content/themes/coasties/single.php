<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 */

get_header(); ?>

	<div id="blog">
		<div class="wrapper">
			<ul class="sidebar">
				<li class="title">Blog</li>
				<?php wp_list_categories('title_li&hide_empty=0&exclude=1&order=DESC'); ?> 
			</ul>

			<?php while ( have_posts() ) : the_post(); ?>

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
					<div class="content"><?php the_content(); ?></div>
				</div>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template( '', true );
		?>
			</div>

			<?php endwhile; ?>

		</div>
	</div>
<?php get_footer(); ?>