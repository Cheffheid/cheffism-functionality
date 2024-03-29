<?php
/**
 * This is a re-usable single project template part for displaying a project post on an archive or other taxonomy.
 *
 * @link       http://jeffreydewit.com
 * @since      1.0.0
 *
 * @package    Cheffism_Functionality
 * @subpackage Cheffism_Functionality/template-includes
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'material-block  ' ); ?>>
	<?php
		$project_in_progress = get_post_meta( get_the_ID(), 'cheffism_in_progress', true );

	if ( is_single() ) {
		$img_size  = 'project-thumb-l';
		$img_class = 'project-featured-img';
		$content   = apply_filters( 'the_content', get_the_content() );
		$title     = get_the_title();
	} else {
		$img_size  = 'project-thumb-l';
		$img_class = 'project-featured-thumb';
		$content   = get_the_excerpt();
		$title     = '<a href="' . get_the_permalink() . '" rel="bookmark">' . get_the_title() . '</a>';
	}

	if ( 'on' === $project_in_progress ) {
		$img_class .= ' in_progress';
	}
	?>

	<header class="entry-header">
		<h2 class="entry-title">
			<?php
				echo $title;
			?>
		</h2>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $img_size, array( 'class' => $img_class ) );
	}
	?>

	<?php if ( is_single() ) { ?>

	<div class="project-meta">
		<?php

			$tech      = get_the_term_list(
				get_the_ID(),
				'technologies',
				'<ul class="inline"><li>',
				',</li><li>',
				'</li></ul>'
			);
			$platforms = get_the_terms( get_the_ID(), 'platform' );

			$built_with = '<p>' . __( 'Built with: ' ) . ' ';

			var_dump( $platforms );

		foreach ( $platforms as $platform ) {
			var_dump( $platform );
			$built_with .= '<a href="' . get_term_link( $platform, 'platform' ) . '">' . $platform->name . '</a>';
		}

			$built_with .= '</p>';

			echo $built_with;

		if ( $tech ) {
			echo '<p class="no-margin-bottom">' . __( 'Some key features:' ) . '</p>' . $tech;
		}

		?>
	</div>

	<?php } ?>

	<div class="entry-summary">
		<?php
			echo $content;
		?>
	</div><!-- .entry-summary -->
	<footer>
		<?php

			$project_link = get_post_meta( get_the_ID(), 'cheffism_project_link', true );
		if ( '' !== $project_link && is_single() ) {
			echo '<p><a href="' . $project_link . '" target="_blank" rel="external">' . __( 'View This Site' ) . '</a></p>';
		}
		?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
