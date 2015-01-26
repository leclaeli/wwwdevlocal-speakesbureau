

	<div id="secondary" class="sidebar-container" role="complementary">
    <div class="widget-area primary">



 <?php 

// args
$postid = get_the_ID();
//echo $my_slug;
$args = array(
    'numberposts' => -1,
    'post_type' => 'cpt-speakers',
    'meta_query' => array(
        'relation' => 'OR',
            array(
                'key' => 'topics',
                'value' => $postid,
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
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
    <?php endwhile; ?>
    </ul>
<?php endif; ?>

<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
		</div>
	</div>
    <!-- #secondary -->


