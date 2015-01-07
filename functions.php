<?php
require_once( get_stylesheet_directory() . '/custom-post-types.php' );
require_once( get_stylesheet_directory() . '/gw-gravity-forms-map-fields-to-field.php' );

// Add class to body on cpt pages

function add_sidebar_class( $classes ) {
    global $post;
    if (is_singular('cpt-speakers')) {
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
    wp_enqueue_script('elijah-script', get_stylesheet_directory_uri() . '/js/elijah.js', array( 'jquery'), false, false);
    wp_enqueue_script('magnific-script', get_stylesheet_directory_uri() . '/js/magnific.js', array( 'jquery'), false, false);
    wp_enqueue_script('jquery-ui-selectable');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-effects-blind');
    wp_enqueue_style('plugin_name-admin-ui-css',
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
        false,
        false,
        false
    );
    wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri() . '/js/ajax-implementation.js', array( 'jquery' ) );
    // code to declare the URL to the file handling the AJAX request </p>
    wp_localize_script( 'ajax-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
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
    // $terms_list = get_the_term_list($post->ID, 'topics', '<span>Topics:</span>', ', ' );
    // if ( $terms_list ) {
    //     echo '<span class="terms-links">' . $terms_list . '</span>';
    // }    

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

/* Update ACF Fields with Form input */
add_action("gform_after_submission_1", "acf_post_submission", 10, 2);
 
function acf_post_submission ($entry, $form) {
    $post_id = $entry["post_id"];
    // Speakers
    update_field('field_548a088742ae7', $entry['3'], $post_id);
    update_field('field_548a08c442ae8', $entry['4'], $post_id);
    update_field('field_548a08ed42aea', $entry['5'], $post_id);
    update_field('field_548a099242aeb', $entry['7'], $post_id);
    update_field('field_548a09bc42aec', array($entry['8.1'], $entry['8.2'], $entry['8.3']), $post_id);
    update_field('field_548a08d342ae9', $entry['10.1'], $post_id);
    update_field('field_5491cd6c9d8d1', $entry['10.2'], $post_id);
    update_field('field_5491cd9a9d8d2', $entry['10.3'], $post_id);
    update_field('field_5491cdac9d8d3', $entry['10.4'], $post_id);
    update_field('field_5491cdf99d8d4', $entry['10.5'], $post_id);
    update_field('field_5491ce049d8d5', $entry['10.6'], $post_id);
    // Presentations
}

/* Add custom image size */
add_image_size( 'homepage-thumb', 64, 64, array('center','top') ); // (cropped)
add_image_size( 'speakers-thumb', 128, 128, array('center','top') ); // (cropped)

/* Ajax Functions */
function MyAjaxFunction(){
  //get the data from ajax() call
   $GreetingAll = $_POST['GreetingAll'];
   $results = "<h2>".$GreetingAll."</h2>";
   die($results);
}
  // creating Ajax call for WordPress
   add_action( 'wp_ajax_nopriv_MyAjaxFunction', 'MyAjaxFunction' );
   add_action( 'wp_ajax_MyAjaxFunction', 'MyAjaxFunction' );

/* Edit Query */
function speakers_posts_per_page($query) {
    if ( is_post_type_archive('cpt-speakers') && ! is_admin() ) {
       // Set query parameters
        return; // return posts
    }
}
add_action('pre_get_posts','speakers_posts_per_page');

add_action("gform_pre_render", "set_chosen_options"); 
function set_chosen_options($form){
?>
<script type="text/javascript">
    gform.addFilter("gform_chosen_options", "set_chosen_options_js");
    //limit how many options may be chosen in a multi-select to 2
    function set_chosen_options_js(options, element){
        //form id = 3, field id = 11
        if (element.attr("id") == "input_3_11"){
            options.max_selected_options = 2;   
        }
        
        return options;
    }
</script>
<?php
    //return the form object from the php hook  
    return $form;
}


