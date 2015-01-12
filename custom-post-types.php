<?php
function codex_custom_posts_init()
{
     $args_cpt_speakers = array(
      'public' => true,
      'label' => 'Speakers',
      'rewrite' => array( 'slug' => 'speakers' ),
      'menu_icon' => 'dashicons-megaphone',
      'taxonomies' => array('post_tag', 'category', 'Organizations'),
      'has_archive' => true,
      'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'revisions', 'page-attributes'
            )
    );
    register_post_type('cpt-speakers', $args_cpt_speakers);

    $args_cpt_presentations = array(
      'public' => true,
      'label' => 'Presentations',
      'rewrite' => array( 'slug' => 'speakers' ),
      'menu_icon' => 'dashicons-format-aside',
      'taxonomies' => array('post_tag', 'category', 'Organizations', 'organizations'),
      'has_archive' => true,
      'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'revisions', 'page-attributes'
            )
    );
    register_post_type('cpt-presentations', $args_cpt_presentations);

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
      'rewrite'           => array( 'slug' => 'Topics' ),
      );

    register_taxonomy( 'topics', array( 'cpt-presentations', 'cpt-speakers' ), $tax_args );

// Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'              => _x( 'Organizations', 'taxonomy general name' ),
      'singular_name'     => _x( 'Organization', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Organizations' ),
      'all_items'         => __( 'All Organizations' ),
      'parent_item'       => __( 'Parent Organization' ),
      'parent_item_colon' => __( 'Parent Organization:' ),
      'edit_item'         => __( 'Edit Organization' ),
      'update_item'       => __( 'Update Organization' ),
      'add_new_item'      => __( 'Add New Organization' ),
      'new_item_name'     => __( 'New Organization Name' ),
      'menu_name'         => __( 'Organizations' ),
    );


      $organization_tax_args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_admin_column' => true,
      );

    register_taxonomy( 'organizations', array( 'cpt-presentations' ), $organization_tax_args );
}

add_action( 'init', 'codex_custom_posts_init' );
