<?php /**
 * Custom search widget
 */
 ?>
<aside class="quick-search">
    <h3>Quick Search</h3>
    <?php get_template_part('searchform-front-page');?>
     <ul>
        <li><a href="speakers/#topics">Browse Topics</a></li>
        <li><a href="speakers/#presentations">Browse Presentations</a></li>
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
</aside>