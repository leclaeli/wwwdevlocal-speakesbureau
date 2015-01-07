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
                        _e( 'Find a Speaker', 'twentythirteen' );
                    endif;
                ?></h1>
                <div class="two_third">
                    <?php get_template_part('searchform-cpt_speakers');?>
                    <div class="az-filter">
                        <h4>A-Z Filter</h4>
                    </div> <!-- to be filled via jQuery -->
                </div>
                <div class="az-placeholder">
                <?php /* A-Z listing */ 
                    $i = 0;
                    $first_char_ln = array();
                    //$first_char_lnt = array();
                    while (have_posts()) : the_post(); {

                    $meta_values = get_post_meta( $post->ID, 'last_name' );

                    foreach ($meta_values as $meta_value => $last_name) {
                        # code...
                        $first_char = substr($last_name, 0, 1);
                        $first_char_ln[]=strtoupper($first_char);
                        $first_char_lc = strtolower($first_char_ln[$i]);
                    if ($i==0) {
                        echo "<span class='az-checkbox'><input type='checkbox' name='$first_char_lc' id='$first_char_lc'><label for='$first_char_lc'>$first_char_ln[$i]</label></span>";
                        $w = 0; }
                        else {
                        $w = 1;
                    }
                    if ($first_char_ln[$i] != $first_char_ln[$i-$w]) {

                    if ($i>0) {
                        echo "";
                    } 
                        echo "<span class='az-checkbox'><input type='checkbox' name='$first_char_lc' id='$first_char_lc'><label for='$first_char_lc'>$first_char_ln[$i]</label></span>";
                    } 
                       $i++;    
                    }
                    }
                    endwhile; 
                ?>
                </div>
                <div id="quick-links" class="one_third last_column searchform-home">
                    <h4>Quick Links</h4>
                    <ul class="sb-ul">
                        <li><a href="">Request a Speaker</a></li>
                        <li><a href="">Become a Speaker</a></li>
                    </ul>
                </div>
                
            </header><!-- .page-header -->

            <div id="tabs">
                <ul>
                    <li><a href="#speakers">Speakers</a></li>
                    <li><a href="#topics">Topics</a></li>
                    <li><a href="#presentations">Presentations</a></li>
                </ul>
                <div id="count-bar">Results</div>
                <div id="speakers">
                    <div id="speaker-container">
                        <?php /* The loop */ ?>
                        <?php while (have_posts()) : the_post(); ?>
                        <?php $meta_values = get_post_meta( $post->ID, 'last_name' ); 
                            foreach ($meta_values as $meta_value => $last_name) {
                                $first_char = substr($last_name, 0, 1);
                            }
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-bookmark="<?php echo $first_char; ?>">
                            <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                            <div class="cpt-thumbnail">
                                <a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('speakers-thumb'); ?></a>
                            </div>
                            <?php else: ?>
                            <div class="cpt-thumbnail">
                                <a href="<?php echo get_permalink(); ?>"><img src="<?php echo get_site_url() ?>/wp-content/uploads/sites/79/2014/11/profile-default-128x128.jpg" width="128" height="128" /></a>
                            </div>
                            <?php endif; ?>
                            <div class="entry-wrapper">
                                <h1 id="speaker-name" class="entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                </h1>
                                
                                <?php if( get_field('job_title') || get_field('department') ): ?>
                                    <p id="job-title"><?php echo get_field('job_title') . ', <span>' . get_field('department') . '</span>'; ?></p>
                                <?php endif; ?>
                                    
                                
                                    <?php //display_topics(", "); ?>
                                    <?php $term_list = get_the_term_list( $post->ID, 'topics', '', ', ' );
                                    if ($term_list) {
                                        echo '<div><h2 id="speaker-topics">Topics:</h2><p>' . $term_list . '</p></div>';
                                    }
                                    $tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
                                    if ( $tag_list ) {
                                        echo '<div><h2 id="speaker-keywords">Keywords:</h2><p>' . $tag_list . '</p></div>';
                                    }
                                    ?>
                                    <?php //twentythirteen_entry_meta(); ?>
                               

                                <?php if ( is_search() || is_archive() )  : // Only display Excerpts for Search and Archives ?>
                                <div class="entry-summary">
                                    <?php //the_excerpt(); ?>
                                </div><!-- .entry-summary -->
                                <?php else : ?>
                                <div class="entry-content">
                                    <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>    
                                    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-wrapper -->
                        <?php endif; ?>
                        </article><!-- #post -->        
                        <?php endwhile; ?>
                    </div><!-- end #speaker-container -->
                </div><!-- #speakers -->
                <?php //twentythirteen_paging_nav(); ?>
                

                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
                
                <div id="topics">
                    <ul>
                        <?php wp_list_categories('orderby=name&taxonomy=topics&title_li='); ?>
                    </ul>
                </div>
                <div id="presentations">
                    List of presentations 
                </div>
            </div> <!-- #tabs -->
        </div><!-- #primary -->
        
    </div><!-- #content -->

<?php get_footer(); ?>