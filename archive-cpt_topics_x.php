<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <div id="content" class="content-area">
        <div id="primary" class="site-content" role="main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php
                    if ( is_day() ) :
                        printf( __( '%s', 'twentythirteen' ), get_the_date() );
                    elseif ( is_month() ) :
                        printf( __( '%s', 'twentythirteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentythirteen' ) ) );
                    elseif ( is_year() ) :
                        printf( __( '%s', 'twentythirteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentythirteen' ) ) );
                    else :
                        _e( 'Topics', 'twentythirteen' );
                    endif;
                ?></h1>
            <?php get_template_part('searchform-cpt_speakers');?>
            </header><!-- .page-header -->


<div> 
<div id="select-result">none</div>
            <?php /* The loop */ ?>
            <?php while (have_posts()) : the_post(); ?>
               
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
    
        <?php if ( is_single() ) : ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php else : ?>
        <h1 class="entry-title">
            <!--<a href="<?php the_permalink(); ?>" rel="bookmark">--><?php the_title(); ?><!--</a>-->
        </h1>
        <?php endif; // is_single() ?>
        
        <div class="entry-meta">
            <?php twentythirteen_entry_meta(); ?>
            <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
            <?php display_topics(", "); ?>
        </div><!-- .entry-meta -->
        
        <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
        <div class="entry-thumbnail">
            <?php if ( is_single() || is_home() ) : ?>
                <?php the_post_thumbnail(); ?>
            <?php else : ?>
                <a href="<?php echo get_permalink(); ?>">
                <?php the_post_thumbnail('thumbnail'); ?>
                </a>
            <?php endif; ?> 
        </div>
        <?php endif; ?>    
    </header><!-- .entry-header -->
    

    <?php if ( is_search() || is_archive() )  : // Only display Excerpts for Search and Archives ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>    
            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
            <?php get_template_part( 'author-bio' ); ?>
        <?php endif; ?>
    </footer><!-- .entry-meta -->

</article><!-- #post -->

                
            <?php endwhile; ?>

            </div>

            <?php twentythirteen_paging_nav(); ?>

        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>

        </div><!-- #primary -->
        
        <?php get_sidebar( 'primary' ); ?>
        <?php get_sidebar( 'subsidiary' ); ?>
        
    </div><!-- #content -->

<?php get_footer(); ?>