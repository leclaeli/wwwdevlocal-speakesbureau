<?php
/**
 * The Template for displaying all single posts.
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
				
				<?php
if (!isset($_COOKIE['TestCookie'])) {
    setPostViews(get_the_ID());
}

				  ?>
				<?php get_template_part( 'content', 'cpt' ); ?>
				<?php twentythirteen_post_nav(); ?>
				<?php comments_template(); ?>

			<?php endwhile; ?>

		</div><!-- #primary -->
		
		<?php get_sidebar( 'cpt_speakers' ); ?>	
		
	</div><!-- #content -->

<?php get_footer(); ?>