<form  role="search" method="get" class="" action="/speakersbureau">
    <label>
        <span class="screen-reader-text">Search for:</span>
        <input type="search" tabindex="1" class="search-field" id="custom-search" placeholder="Search …" value="<?php the_search_query(); ?>" name="s" title="Search for:">
        <div>
        <p id="ptag"></p>
        <!-- <input type="checkbox" name="search-topics" value="yes">Topics
        <input type="checkbox" name="search-speakers" value="yes">Speakers -->
        </div>
        <!-- in <?php wp_dropdown_categories( 'show_option_all=All Categories&taxonomy=post_tag' ); ?> -->
        <input name="submit" type="submit" id="submit" value="Go">
    </label>
<!--
        <label for="search">Search in <?php echo home_url( '/' ); ?></label>
        <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
        <input type="image" alt="Search" src="<?php bloginfo( 'template_url' ); ?>/images/search.png" />
        -->

    
    <div class="search-results"></div>

    </fieldset>
</form>
