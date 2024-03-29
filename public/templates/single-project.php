<?php
/**
 * Default template file for displaying a single Project page.
 *
 * @package WordPress
 * @subpackage Cheffism
 */

get_header(); ?>

		<div id="primary">
			<div id="content" class="content main-wrap">

			<?php
			if ( have_posts() ) {
				while ( have_posts() ) :
					the_post();

					include __DIR__ . '/includes/project.php';

				endwhile;
			}
			?>

				<nav id="nav-above" role="article" class="material-block cf fixed-post-nav">
					<div class="fixed previous"><?php previous_post_link( '%link', '&larr; Previous Project' ); ?></div>
					<div class="fixed next"><?php next_post_link( '%link', 'Next Project &rarr;' ); ?></div>
				</nav><!-- #nav-above -->
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>
