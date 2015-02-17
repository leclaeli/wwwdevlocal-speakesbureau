<?php
/**
 * The sidebar containing the footer widget area.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

if ( is_active_sidebar( 'sidebar-primary' ) ) : ?>	
	<div id="secondary" class="sidebar-container" role="complementary">
		<div class="widget-area primary">
            <?php get_sidebar( 'search' ); ?>
			<?php dynamic_sidebar( 'sidebar-primary' ); ?>
		</div><!-- .widget-area -->
	</div><!-- #secondary -->
<?php endif; ?>