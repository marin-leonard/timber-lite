<?php
/**
 * Template part for displaying posts.
 *
 * @package Timber
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<aside class="entry-thumbnail">
		<?php if (has_post_thumbnail()) {
			echo get_the_post_thumbnail($post->ID, 'medium');
		} ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="post-meta">
				<div class="post-meta__content"><i class="fa fa-play"></i></div>
			</div>
		<?php endif; ?>
	</aside>

	<header class="entry-header">

		<div class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : ?>
				<?php timber_posted_on(); ?>
				<?php timber_first_category(); ?>
			<?php else: ?>
				<?php echo get_post_type(); ?>
			<?php endif; ?>
		</div><!-- .entry-meta -->

		<?php the_title( sprintf( '<h1 class="entry-title h3"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php timber_post_excerpt(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'timber' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
