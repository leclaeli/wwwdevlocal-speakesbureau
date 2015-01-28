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

		<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>
		
		<?php if( get_field('speaker_name') ) : 
			$postid = get_field('speaker_name');
			$speakers_name = get_the_title( $postid[0] );
		?>
		<p>Speaker: <a href="<?php echo get_permalink( $postid[0] ); ?>"><?php echo $speakers_name ?></a></p>
         <?php endif; ?>

         <?php $term_list = get_the_term_list( $post->ID, 'topics', '', ', ' );
			if ($term_list) {
			    echo '<p>Topics: ' . $term_list . '</p>';
		}
		
		$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
		if ( $tag_list ) {
		    echo '<div><h4 id="speaker-keywords">Keywords:</h4><p>' . $tag_list . '</p></div>';
		}
		?>


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
