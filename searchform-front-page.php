<form  role="search" method="get" class="" action="/speakersbureau" id="home-s-form">
    <label>
    </label>
        <div id="search-container">
            <span class="screen-reader-text">Search for:</span>
            <input type="search" tabindex="1" class="search-field" id="home-search" placeholder="Search …" value="<?php the_search_query(); ?>" name="s" title="Search for:" autocomplete="off">
        </div>
        <input name="submit" type="submit" id="submit" value="Go">
       
        <!-- <p id="ptag"></p> -->
         <!-- in <?php wp_dropdown_categories( 'show_option_all=All Categories' ); ?> -->
    
    <!-- <div class="search-results"></div> -->
</form>

