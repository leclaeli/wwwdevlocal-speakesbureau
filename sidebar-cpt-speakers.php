<div id="secondary" class="sidebar-container" role="complementary">
    <div class="widget-area">
        <aside>
            <h3 id="featured-spk">Most Viewed</h3>
            <ul>
            <?php
            query_posts('meta_key=post_views_count&orderby=meta_value_num&order=DESC&post_type=cpt-speakers&posts_per_page=3');
            if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
                    <li><a href="<?php
                    the_permalink(); ?>"><?php
                    the_title(); ?></a></li>
                    <?php
                endwhile;
            endif;
            wp_reset_query();
            ?>
            </ul>
        </aside>
        <aside>
            <h3>Related Speakers</h3>
            <?php
            //Returns Array of Term ID's for "my_taxonomy"
            $term_list = wp_get_post_terms($post->ID, 'topics', array("fields" => "ids"));
            // args
            $postid = get_the_ID();
            //echo $my_slug;
            $args = array(
                'numberposts' => -1,
                'post_type' => 'cpt-speakers',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'topics',
                        'field'    => 'term_id',
                        'terms'    => $term_list,
                    ),
                ),
                'post__not_in' => array($postid), // - use post ids. Specify post NOT to retrieve. 
            );

            // get results
            $the_query = new WP_Query( $args );

            // The Loop
            ?>
            <?php if( $the_query->have_posts() ): ?>
                <ul>
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php endif; ?>

            <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
        </aside>
    </div>
</div>
    <!-- #secondary -->


