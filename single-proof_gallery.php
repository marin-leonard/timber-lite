<?php
/**
 * The template for displaying PixProof Galleries.
 *
 * @package Timber
 * @since Timber 1.0
 */

get_header(); ?>


<div class="site-header  site-header--placeholder"></div>
<main id="content" class="site-content site-container  <?php echo 'image-scaling--' . $image_scaling; ?>">

	<?php while ( have_posts() ) : the_post();

		/* Include the Post-Format-specific template for the content.
		* If you want to override this in a child theme, then include a file
		* called content-___.php (where ___ is the Post Format name) in a template-parts directory and that will be used instead.
		*/

		the_content();


		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop. ?>

	<div class="site-content__mask  mask--project"></div>

</main>

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="bar--fixed">

		<div class="project-addthis-container">
		<?php get_template_part('template-parts/addthis-share'); ?>
		</div>

		<div class="site-info">
			<div class="portfolio__position"></div>
			<button class="show-details caption js-details"><span><?php _e( 'details', 'timber' ); ?></span></button>
		</div><!-- .site-info -->
		<button class="show-button caption js-show-thumbnails">
			<span class="desktop-thumbnails-label"><?php _e( 'show thumbnails', 'timber' ); ?></span>
			<span class="mobile-thumbnails-label"><?php _e( 'thumbs', 'timber' ); ?></span>
		</button>
	</div>
</footer><!-- #colophon -->

<?php get_footer(); ?>