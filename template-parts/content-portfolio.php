<?php
/**
 * The template used for displaying Jetpack Portfolio posts on the Porfolio landing page
 *
 * @package Timber
 * @since Timber 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Project Title and Link
	 */
	?>
	<div class="portfolio__header">

		<?php timber_the_project_types( get_the_ID(), '<div class="portfolio__type">', '</div>' ); ?>

		<h2 <?php echo timber_get_post_title_class_attr( 'portfolio__title h1' ); ?> >
			<a href="<?php the_permalink(); ?>" class="block-link" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'timber' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<?php
					if ( get_the_title() != '' ) :
						// check if the post has a title
						the_title();
					else :
						// if no title is present, use generic text instead
						_e( 'View Project', 'timber' );
					endif;
				?>
			</a>
		</h2>
	</div>

	<a href="<?php the_permalink(); ?>" class="portfolio__link-wrap  block-link" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'timber' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
		<?php
		/*
		 * Project film strip with text boxes and videos ignored
		 */
		timber_the_film_strip( get_the_ID(), true, true );
		?>
	</a>

</article><!-- #post-<?php the_ID(); ?> -->
