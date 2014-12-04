<?php
function codex_custom_posts_init()
{
     $args_cpt_speakers = array(
      'public' => true,
      'label' => 'Speakers',
      'rewrite' => array( 'slug' => 'speakers' ),
      'menu_icon' => 'dashicons-megaphone',
      'taxonomies' => array('post_tag', 'category', 'topics'),
      'has_archive' => true,
      'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'trackbacks', 'comments',
            'revisions', 'page-attributes', 'post-formats'
            )
    );
    register_post_type('cpt-speakers', $args_cpt_speakers);

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'              => _x( 'Topics', 'taxonomy general name' ),
      'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Topics' ),
      'all_items'         => __( 'All Topics' ),
      'parent_item'       => __( 'Parent Topic' ),
      'parent_item_colon' => __( 'Parent Topic:' ),
      'edit_item'         => __( 'Edit Topic' ),
      'update_item'       => __( 'Update Topic' ),
      'add_new_item'      => __( 'Add New Topic' ),
      'new_item_name'     => __( 'New Topic Name' ),
      'menu_name'         => __( 'Topics' ),
    );


    $tax_args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'topics' ),
      );

    register_taxonomy( 'topics', 'cpt-speakers', $tax_args );
}

add_action( 'init', 'codex_custom_posts_init' );
