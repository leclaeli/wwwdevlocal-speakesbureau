<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		

		<div class="entry-thumbnail">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<?php the_post_thumbnail('speakers-single'); ?>
		<?php endif; ?>	
			<div class="speaker-contact">
			<?php if( get_field('campus_email') ): ?>
	                <p class="campus-email">
	                	<a href="mailto:<?php echo get_field('campus_email'); ?>"><?php echo get_field('campus_email'); ?></a>
	                </p>
	        <?php endif; ?>
	        <?php if( get_field('campus_phone') ): ?>
	                <p class="campus-phone"><?php echo get_field('campus_phone'); ?></p>
	        <?php endif; ?>
	        </div>
	    </div>
		
		<div id="speaker-meta" class="entry-meta">
			
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>
		<?php if( get_field('job_title') && get_field('department') ): ?>
        	<p class="job-title"><?php esc_html_e( the_field('job_title') ); ?><span>, <?php esc_html_e( the_field('department') ); ?></span></p> <!-- span on new line adds extra space -->
        <?php endif; ?>

            

			<?php $term_list = get_the_term_list( $post->ID, 'topics', '', ', ' );
			if ($term_list) {
			    echo '<div><h4 id="speaker-topics">Topics:</h4><p>' . $term_list . '</p></div>';
			}
			$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
			if ( $tag_list ) {
			    echo '<div><h4 id="speaker-keywords">Keywords:</h4><p>' . $tag_list . '</p></div>';
			}

			// Presentations
		    $current_id = $post->ID; 
		    // args   
		    $pres_args = array(
		        'numberposts' => -1,
		        'post_type' => 'cpt-presentations',
		        'meta_query' => array(
		            'relation' => 'OR',
		            array(
		                'key' => 'speaker_name',
		                'value' => $current_id,
		                'compare' => 'LIKE'
		            )
		        )
		    );
		    // get results
		    $the_query = new WP_Query( $pres_args );
		    // The Loop
		    ?>
		    <?php if( $the_query->have_posts() ): ?>
			    <div class="speaker-presentations">
			    	<h4>Presentations:</h4>
			        <ul>
			        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			            <li>
			                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			            </li>
			        <?php endwhile; ?>
			        </ul>
			    </div>
		    <?php endif; ?>
		    <?php wp_reset_query();  // Restore global post data stomped by the_post().
			?>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
		
	</div><!-- .entry-content -->
	<?php endif; ?>

	
</article><!-- #post -->
