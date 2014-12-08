<form  role="search" method="get" class="" action="/speakersbureau" id="home-s-form">
    <label>
        <div id="search-container">
            <span class="screen-reader-text">Search for:</span>
            <input type="search" tabindex="1" class="search-field" id="home-search" placeholder="Search …" value="<?php the_search_query(); ?>" name="s" title="Search for:" autocomplete="off">
            
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
        <input name="submit" type="submit" id="submit" value="Go">
        <p id="ptag"></p>
         <!-- in <?php wp_dropdown_categories( 'show_option_all=All Categories' ); ?> -->
    </label>
    <!-- <div class="search-results"></div> -->
</form>
