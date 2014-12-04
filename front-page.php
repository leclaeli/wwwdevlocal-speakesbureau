<?php
/**
 * Template Name: Front-page
 *
 * Description: Displays a full-width front page.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="content" class="content-area">
		<div id="primary" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<?php get_sidebar( 'front-page-banner' ); ?>
				
					<div class="entry-content">
						<div class="content-column two_third">
							<?php 
							    echo do_shortcode("[metaslider id=157]"); 
							?>
						</div>
						<div class="content-column one_third last_column">
							<?php get_template_part('searchform-cpt_speakers');?>
						</div>
						<div class="clear_column"></div>
						<?php wp_reset_query(); the_content(); ?>
						<?php wp_tag_cloud('separator=, '); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

				</article><!-- #post -->
				
			<?php endwhile; ?>

		</div><!-- #primary -->
		
		<?php get_sidebar( 'primary' ); ?>
		<?php get_sidebar( 'subsidiary' ); ?>
		
	</div><!-- #content -->

<?php get_footer(); ?>