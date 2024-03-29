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
		$img_size            = 'project-thumb-l';
		$img_class           = 'project-featured-img';
		$project_content     = apply_filters( 'the_content', get_the_content() );
		$project_title       = get_the_title();
		$project_link        = get_post_meta( get_the_ID(), 'cheffism_project_link', true );

	if ( ! is_single() ) {
		$img_size        = 'project-thumb-l';
		$img_class       = 'project-featured-thumb';
		$project_content = get_the_excerpt();
		$project_title   = '<a href="' . get_the_permalink() . '" rel="bookmark">' . get_the_title() . '</a>';
	}

	if ( 'on' === $project_in_progress ) {
		$img_class .= ' in_progress';
	}
	?>

	<header class="entry-header">
		<h2 class="entry-title">
			<?php
				echo esc_html( $project_title );
			?>
		</h2>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $img_size, array( 'class' => $img_class ) );
	}
	?>

	<?php if ( is_single() ) : ?>

	<div class="project-meta">
		<?php

		$platforms = get_the_terms( get_the_ID(), 'platform' );
		$tech      = get_the_term_list(
			get_the_ID(),
			'technologies',
			'<ul class="inline"><li>',
			',</li><li>',
			'</li></ul>'
		);

		$built_with = '<p>' . __( 'Built with: ' ) . ' ';

		foreach ( $platforms as $platform ) {
			$built_with .= '<a href="' . get_term_link( $platform, 'platform' ) . '">' . $platform->name . '</a>';
		}

		$built_with .= '</p>';

		echo wp_kses_post( $built_with );

		if ( $tech ) {
			echo '<p class="no-margin-bottom">' . esc_html__( 'Some key features:', 'cheffism' ) . '</p>' . wp_kses_post( $tech );
		}

		?>
	</div>

	<?php endif; ?>

	<div class="entry-summary">
		<?php echo wp_kses_post( $project_content ); ?>
	</div><!-- .entry-summary -->

	<?php if ( '' !== $project_link && is_single() ) : ?>
	<footer>
		<p>
			<a href="' . esc_url( $project_link ) . '" target="_blank" rel="external">
				<?php esc_html_e( 'View This Site', 'cheffism' ); ?>
			</a>
		</p>
	</footer>
	<?php endif; ?>
</article><!-- #post -->
