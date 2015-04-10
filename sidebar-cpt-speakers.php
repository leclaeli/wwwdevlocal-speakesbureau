<div id="secondary" class="sidebar-container" role="complementary">
    <div class="widget-area">
        <aside>
            
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
        
        <?php
        query_posts('meta_key=post_views_count&orderby=meta_value_num&order=DESC&post_type=cpt-speakers&posts_per_page=3');
        if (have_posts()): ?>
           <!--  <aside>
                <h3 id="featured-spk">Most Viewed</h3>
                <ul>
                <?php
                    while (have_posts()):
                        the_post(); ?>
                        <li><a href="<?php
                        the_permalink(); ?>"><?php
                        the_title(); ?></a></li>
                <?php
                    endwhile;
                ?>
                </ul>
            </aside> -->
        <?php
        endif;
        wp_reset_query();
        ?>
    
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
            <aside>
                <h3>Related Speakers</h3>
                <ul>
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
                </ul>
            </aside>
        <?php endif; ?>
    
        <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
    
    </div>
</div>
    <!-- #secondary -->


