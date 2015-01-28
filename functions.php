<?php
require_once( get_stylesheet_directory() . '/custom-post-types.php' );
require_once( get_stylesheet_directory() . '/gw-gravity-forms-map-fields-to-field.php' );
require_once( get_stylesheet_directory() . '/gravity-forms-custom-post-types/gfcptaddon.php' );

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


/* Custom entry_meta for child theme */

function twentythirteen_entry_meta() {  
    
    if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
        twentythirteen_entry_date();
        
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
    if ( $categories_list ) {
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

/* Change order for speakers archive page */
// Runs before the posts are fetched
add_filter( 'pre_get_posts' , 'my_change_order' );
// Function accepting current query
function my_change_order( $query ) {
    // Check if the query is for an archive
    if( $query->is_main_query() && $query->is_post_type_archive('cpt-speakers') && !is_admin() )
        if ( !is_front_page() ) {
            // Query was for archive, then set order
            $query->set( 'meta_key', 'last_name' );
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );
            $query->set( 'posts_per_archive_page', -1);
        }
    // Return the query (else there's no more query, oops!)
    return $query;
}

/* Update ACF Fields with Speaker Registration Form input */
add_action("gform_after_submission_1", "acf_post_submission", 10, 2);
 
function acf_post_submission ($entry, $form) {
    $post_id = $entry["post_id"];

    update_field('field_548a088742ae7', $entry['3'], $post_id);
    update_field('field_548a08c442ae8', $entry['4'], $post_id);
    update_field('field_548a08ed42aea', $entry['5'], $post_id);
    update_field('field_548a099242aeb', $entry['7'], $post_id);
    update_field('field_548a09bc42aec', array($entry['8.1'], $entry['8.2'], $entry['8.3']), $post_id);
    update_field('field_548a08d342ae9', $entry['10.1'], $post_id);
    update_field('field_5491cd6c9d8d1', $entry['10.2'], $post_id);
    update_field('field_5491cd9a9d8d2', $entry['10.3'], $post_id);
    update_field('field_5491cdac9d8d3', $entry['10.4'], $post_id);
    update_field('field_5491cdf99d8d4', $entry['10.6'], $post_id);
    update_field('field_5491ce049d8d5', $entry['10.5'], $post_id);
    update_field('field_54a2e8dbe2bef', $entry['18'], $post_id); // Job Title (text)
    update_field('field_54b3f6db4e584', $entry['20'], $post_id); // Willing to speak to media (radio)
    update_field('field_54a2eac9a6903', $entry['21'], $post_id); // Department (select)
    $cat_ids = explode(",", $entry['19']);
    $cat_ids = array_map( 'intval', $cat_ids );
    $cat_ids = array_unique( $cat_ids );
    $term_taxonomy_ids = wp_set_object_terms( $entry['post_id'], $cat_ids, 'topics' );
    if ( is_wp_error( $term_taxonomy_ids ) ) {
    // There was an error somewhere and the terms couldn't be set.
    } else {
        // Success! The post's categories were set.
    }
}

/* Update ACF Fields with Gravity Form input */
add_action("gform_after_submission_3", "acf_presentation_submission", 10, 2);
 
function acf_presentation_submission( $entry, $form ) {
    $post_id = $entry["post_id"];
    update_field('field_54adab60b4b39', $entry['12'], $post_id); // Your Name
    update_field('field_54adac3eb4b3b', $entry['15'], $post_id); // Audiovisual Needs
    update_field('field_54ae9020b4b3c', $entry['8'], $post_id); // Audiovisual Info (radio)
    
    // Topics
    $cat_ids = explode( ",", $entry['11'] );
    $cat_ids = array_map( 'intval', $cat_ids );
    $cat_ids = array_unique( $cat_ids );
    $term_taxonomy_ids = wp_set_object_terms( $entry['post_id'], $cat_ids, 'topics' );
    if ( is_wp_error( $term_taxonomy_ids ) ) {
    // There was an error somewhere and the terms couldn't be set.
    } else {
        // Success! The post's categories were set.
    }

    // Organizations
    $org_ids = explode( ",", $entry['9'] );
    $org_ids = array_map( 'intval', $org_ids );
    $org_ids = array_unique( $org_ids );
    $term_taxonomy_ids = wp_set_object_terms( $entry['post_id'], $org_ids, 'organizations' );
    if ( is_wp_error( $term_taxonomy_ids ) ) {
    // There was an error somewhere and the terms couldn't be set.
    } else {
        // Success! The post's orgegories were set.
    }

    // Other Organizations (Repeater Field)
    $other_orgs = unserialize($entry['10']);
    $count = 1;
    foreach ($other_orgs as $other_org => $org_value) {
        $value[] = array("organization" => $org_value, "acf_fc_layout" => "row_".$count);
        $count++;
    }
    update_field( 'field_54ae90e29986f', $value, $post_id );
    //echo '<pre>'; print_r($value); echo '</pre>';
}

/* Add custom image size */
add_image_size( 'homepage-thumb', 64, 64, array('center','top') ); // (cropped)
add_image_size( 'speakers-thumb', 128, 128, array('center','top') ); // (cropped)
add_image_size( 'speakers-single', 225, 275, array('center','top') ); // (cropped)

/* Ajax Functions */
function MyAjaxFunction(){
    //get the data from ajax() call
    $spkPostID = $_POST['spkPostId'];
    $results = "<h2>".$spkPostID."</h2>";

    $args = array(
    'numberposts' => -1,
    'post_type' => 'cpt-presentations',
    'meta_query' => array(
        'relation' => 'OR',
            array(
                'key' => 'speaker_name',
                'value' => $spkPostID,
                'compare' => 'LIKE'
            )
        )   
    );

    

    add_filter('gform_pre_render_6', 'populate_posts');

    function populate_posts($form){
        print_r($args);
        foreach($form['fields'] as &$field){
            
            if($field['type'] != 'select' || strpos($field['cssClass'], 'populate-posts') === false)
                continue;
            
            // you can add additional parameters here to alter the posts that are retreieved
            // more info: http://codex.wordpress.org/Template_Tags/get_posts
            $posts = get_posts('numberposts=-1&post_status=publish');
            
            // update 'Select a Post' to whatever you'd like the instructive option to be
            $choices = array(array('text' => 'Select a Post', 'value' => ' '));
            
            foreach($posts as $post){
                $choices[] = array('text' => $post->post_title, 'value' => $post->post_title);
            }
            
            $field['choices'] = $choices;
            
        }
        
        return $form;
    }

   die($results);
}
  // creating Ajax call for WordPress
   add_action( 'wp_ajax_nopriv_MyAjaxFunction', 'MyAjaxFunction' );
   add_action( 'wp_ajax_MyAjaxFunction', 'MyAjaxFunction' );


/* Limit number of choices on Gravity form select field */

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


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_meta_box() {

    $screens = array( 'cpt-speakers' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'myplugin_sectionid',
            __( 'Presentations', 'myplugin_textdomain' ),
            'myplugin_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );



/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback( $post ) {

    // args
    $current_id = $post->ID;    
    $args = array(
        'numberposts' => -1,
        'post_type' => 'cpt-presentations',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'speaker_name',
                'value' => $current_id,
                'compare' => 'LIKE'
            )
        )
    );

    // get results
    $the_query = new WP_Query( $args );

    // The Loop
    ?>
    <?php if( $the_query->have_posts() ): ?>
        <ul>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li>
                <?php the_title(); ?>
                <a href="<?php the_permalink(); ?>">View</a>
                <?php edit_post_link(' Edit', '<span>', '</span>'); ?>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php wp_reset_query();  // Restore global post data stomped by the_post().    
}



// function get_http() {
//     $url = 'http://wwwdevlocal.uwm.edu/summer-courses/plugins/';

//     $request = new WP_Http;
//     $result = $request->request($url);
//     $content = array();
//     var_dump($result);
//     if (isset($result->errors)) {
//         // display error message of some sort
//     } else {
//         $content = $result['body'];
//     }
// }
