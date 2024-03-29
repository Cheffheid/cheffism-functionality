<?php
/**
 * Taxonomy template used for Platform and Technologies taxonomies.
 *
 * @package WordPress
 * @subpackage Cheffism
 */

get_header(); ?>

	<div id="primary" role="region">
		<div id="content" class="page-wrap">

			<header>
				<h1 class="list-title">
					<span>
					<?php
					single_cat_title();
					echo '&nbsp;' . __( 'Projects' );
					?>
					</span>
				</h1>

			</header>

			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();

					include __DIR__ . '/includes/project.php';

				endwhile;
				?>

				<?php /* Show page navigation when applicable */ ?>
				<?php if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-above" role="article" class="material-block cf fixed-post-nav">
						<div class="fixed previous"><?php next_posts_link( __( '&larr; Previous Project', 'cheffism' ) ); ?></div>
						<div class="fixed next"><?php previous_posts_link( __( 'Next Project &rarr;', 'cheffism' ) ); ?></div>
					</nav><!-- #nav-above -->
				<?php endif; ?>
			<?php else : ?>
				<p class="no-results">No projects here. Check back later!</p>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_footer();
