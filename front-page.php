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
							<div class="searchform-home content-column one_third last_column">
								<h4>Quick Search</h4>
								<?php get_template_part('searchform-front-page');?>
								 <ul id="home-browse" class="sb-ul">
								    <li><a href="speakers/#topics/">Browse Topics</a></li>
								    <li><a href="topics/">Browse Presentations</a></li>
								</ul>
								<div class="search-dropdown-container">
								    <?php $speaker_posts = get_posts('post_type=cpt-speakers&numberposts=-1' ); ?>
								    <ul>
								        <?php
								        foreach ( $speaker_posts as $post ) : setup_postdata( $post ); ?>
								            <li>
								                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								            </li>
								        <?php endforeach; 
								    wp_reset_postdata();?>
								    </ul>
								</div>
							</div>
							<div class="clear_column"></div>
						</div>
						<div class="clear_column"></div>
						<?php wp_reset_query(); the_content(); ?>
						<?php $cloud_args = array(
							'smallest'                  => 12, 
							'largest'                   => 26,
							'unit'                      => 'px', 
							'number'                    => 25,  
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
							<h4>Topic Keywords</h4>
							<?php wp_tag_cloud($cloud_args); ?>
						</div>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

				</article><!-- #post -->
				
			<?php endwhile; ?>

		</div><!-- #primary -->
		
		
		<?php get_sidebar( 'subsidiary' ); ?>
		
	</div><!-- #content -->

<?php get_footer(); ?>