<?php
/**
 * Template part for displaying featured projects.
 *
 * @package Timber
 * @since Timber 1.0
 */

//get the slider settings
$projects_slider_height = get_post_meta( timber_get_post_id(), 'projects_slider_height', true);
$show_adjacent_projects = get_post_meta( timber_get_post_id(), 'show_adjacent_projects', true);

//get the featured projects
$featured = timber_get_featured_projects();

if ( ! empty( $featured ) ) : ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main <?php echo 'slider--' . $show_adjacent_projects . ' slider--' . $projects_slider_height ?>">
		<div class="projects-slider">

			<?php
			foreach ( $featured as $post ) : setup_postdata( $post );

				get_template_part( 'template-parts/content', 'project-featured' );

			endforeach; ?>

		</div><!-- .featured-projects-slider -->

		<?php $numFeatured = count( $featured );
		if ( $numFeatured > 1 ) : ?>
		<div class="vertical-title prev"><span><?php echo get_the_title( $featured[ $numFeatured - 1 ] ); ?></span></div>
		<?php endif; ?>

		<?php if ( ! empty( $featured[1] ) ) : ?>
		<div class="vertical-title next"><span><?php echo get_the_title( $featured[1] ); ?></span></div>
		<?php endif; ?>

		<div class="project-slide__content">

			<?php timber_the_project_types( $featured[0]->ID, '<div class="portfolio_types">', '</div>' ); ?>

			<a href="<?php echo esc_url( get_the_permalink( $featured[0]->ID ) ); ?>"
			   class="project-slide__link"
			   title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'timber' ), the_title_attribute( array( 'echo' => 0, 'post' => $featured[0]->ID) ) ) ); ?>"
			   rel="bookmark">
				<div class="project-slide__title js-title-mask">
					<h1><?php echo get_the_title( $featured[0] ); ?></h1>
				</div>
				<div class="project-slide__text"><?php _e( '&#8594; View Project', 'timber' ); ?></div>
			</a>
		</div>
		<div class="projects-slider__bullets  rsBullets"></div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php else :

	get_template_part( 'template-parts/content', 'none' );

endif; ?>