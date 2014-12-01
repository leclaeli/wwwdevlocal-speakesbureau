<?php
function codex_custom_init()
{
    $args = array(
      'public' => true,
      'label' => 'Speakers',
      'rewrite' => array( 'slug' => 'speakers' ),
      'menu_icon' => 'dashicons-megaphone',
      'taxonomies' => array('post_tag', 'category'),
      'has_archive' => true,
      'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'trackbacks', 'comments',
            'revisions', 'page-attributes', 'post-formats'
            )
    );
    register_post_type('cpt_speakers', $args);

    $args_topics = array(
      'public' => true,
      'label' => 'Topics',
      'rewrite' => array( 'slug' => 'topics' ),
      'menu_icon' => 'dashicons-category',
      'taxonomies' => array('post_tag', 'category'),
      'has_archive' => true,
      'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'trackbacks', 'comments',
            'revisions', 'page-attributes', 'post-formats'
            )
          );
    register_post_type( 'cpt_topics', $args_topics );
}
add_action( 'init', 'codex_custom_init' );



