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
						<div id="home-slider-container">
							<div class="content-column two_third">
								<?php 
								    echo do_shortcode("[metaslider id=157]"); 
								?>
							</div>
							<div class="searchform-home content-column one_third last_column widget-area">
								<?php get_sidebar( 'search' ); ?>
							</div>
							<div class="clear_column"></div>
						</div>
						<div class="clear_column"></div>
						<?php wp_reset_query(); the_content(); ?>
						<?php $cloud_args = array(
							'smallest'                  => 12, 
							'largest'                   => 26,
							'unit'                      => 'px', 
							'number'                    => 22,  
							'format'                    => 'flat',
							'separator'                 => "\n",
							'orderby'                   => 'name', 
							'order'                     => 'RAND',
							'exclude'                   => null, 
							'include'                   => null, 
							'topic_count_text_callback' => '',
							'link'                      => 'view', 
							'taxonomy'                  => 'post_tag', 
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						); ?>
						<div id="tag-cloud">
							<h4>Keyword Cloud</h4>
							<?php wp_tag_cloud($cloud_args); ?>
                            <i class="fa fa-cloud"></i>
						</div>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

				</article><!-- #post -->
				
			<?php endwhile; ?>

		</div><!-- #primary -->
	
		<?php get_sidebar( 'subsidiary' ); ?>
		
	</div><!-- #content -->

<?php get_footer(); ?>