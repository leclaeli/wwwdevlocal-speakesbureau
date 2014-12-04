<?php
require_once( get_stylesheet_directory() . '/custom-post-types.php' );

// Add class to body on cpt pages

// add category nicenames in body and post class
function add_sidebar_class( $classes ) {
    global $post;
    if (is_singular('cpt-speakers') || is_singular('cpt_topics' )) {
  // show adv. #1
        $classes[] = "sidebar-primary";
        return $classes;
} else {
  // show adv. #2
    $classes[] = '';
    return $classes;
}
}
add_filter( 'body_class', 'add_sidebar_class' );

/* Count the number of views each post gets*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/* Set Cookie for one month that will prevent page refreshes from counting towards post views*/

function set_new_cookie() {
    //setting your cookies there
    setcookie("TestCookie", "popular_post_counter", time()+3600*24*30);
}
add_action('init', 'set_new_cookie');


/*
*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
*  Using this method, you can use all the normal WP functions as the $post object is 
*  temporarily initialized within the loop
*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
*/
function display_topics($separator = "")
{
    global $post;
    $post_objects = get_field('acf_topics');
    $i=0;
    if($post_objects):

        echo '<span class="topics-links"><i class="fa fa-folder-open-o"></i>
Topics: ';
        foreach($post_objects as $post): // variable must be called $post (IMPORTANT)
            setup_postdata($post);
            $my_permalink = get_permalink();
            echo "<a href=" . esc_url($my_permalink) . ">";
            $my_title = get_the_title();
            if ($i>0) {
                echo $separator . $my_title;
            } else {
                echo $my_title;
            }
            echo "</a>";
            $i++;
        endforeach;
        echo '</span>';
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
    endif;
}


/**
 * Enqueue a script.
 */
function custom_js_script()
{
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery'), false, false);
    wp_enqueue_script('jquery-ui-selectable');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('plugin_name-admin-ui-css',
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
        false,
        false,
        false
    );
    /**
    * Register and load font awesome CSS files using a CDN.
    *
    * @link http://www.bootstrapcdn.com/#fontawesome
    * @author FAT Media
    */
    wp_enqueue_style( 'prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3' );
}
add_action('wp_enqueue_scripts', 'custom_js_script');


/* Add custom post types to taxonomy pages */

function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

// Get all your post types
$post_types = get_post_types();

$query->set( 'post_type', $post_types );
return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );

/* Custom entry_meta for child theme */
function twentythirteen_entry_meta() {  
    
    if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
        twentythirteen_entry_date();
        
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
    if ( $categories_list ) {
        //echo '<span class="categories-links">' . $categories_list . '</span>';
    }

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
    if ( $tag_list ) {
        echo '<span class="tags-links">Keywords: ' . $tag_list . '</span>';
    }
}

/* Change default excerpt length */
function new_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'new_custom_excerpt_length', 999 );

/* Change order for speakers archive page */
// Runs before the posts are fetched
add_filter( 'pre_get_posts' , 'my_change_order' );
// Function accepting current query
function my_change_order( $query ) {
    // Check if the query is for an archive
    if($query->is_archive && !is_admin() && is_post_type_archive('cpt-speakers'))
        // Query was for archive, then set order
        $query->set( 'meta_key', 'last_name' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'ASC' );
    // Return the query (else there's no more query, oops!)
    return $query;
}


