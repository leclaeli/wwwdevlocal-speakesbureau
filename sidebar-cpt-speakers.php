

	<div id="secondary" class="sidebar-container" role="complementary">
        <div class="widget-area primary">
<?php


?>
<h3>Popular Speakers</h3>
<ul>
<?php
    query_posts('meta_key=post_views_count&orderby=meta_value_num&order=DESC&post_type=cpt_speakers&posts_per_page=3');
    if (have_posts()) : while (have_posts()) : the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php
    endwhile; endif;
    wp_reset_query();
?>
</ul>

<h3>Topics</h3>

<?php // display Speaker's topics
    display_topics();
?>
		</div>
	</div>
    <!-- #secondary -->


