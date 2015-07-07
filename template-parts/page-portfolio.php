<div class="site-container">

	<div class="site-sidebar"></div>
	<div class="site-content portfolio-archive">

		<?php
		/**
		 * @TODO wait for it
		 * Displays portfolio page content if user opts to
		 * Can be controlled in Appearance > Customize > Theme Options

		if ( ! timber_get_option( 'hide_portfolio_page_content', false ) ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // end of the loop.
		endif;
		 */

		if ( get_query_var( 'paged' ) ) :
			$paged = get_query_var( 'paged' );
		elseif ( get_query_var( 'page' ) ) :
			$paged = get_query_var( 'page' );
		else :
			$paged = 1;
		endif;

		$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '12' );

		$args = array(
			'post_type' => 'jetpack-portfolio',
			'paged' => $paged,
			'posts_per_page' => $posts_per_page,
		);

		$project_query = new WP_Query( $args );

		if ( $project_query -> have_posts() ) : ?>

			<div class="portfolio-wrapper">

				<?php while ( $project_query -> have_posts() ) : $project_query -> the_post();

					get_template_part( 'template-parts/content', 'portfolio' );

				endwhile;

				timber_paging_nav( $project_query->max_num_pages );

				wp_reset_postdata(); ?>

			</div>

		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
	</div>
</div>