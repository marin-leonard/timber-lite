<?php
/**
 * The template used for displaying a project (Jetpack Portfolio Single Post) using the Filmstrip layout
 *
 * @package Timber
 * @since Timber 1.0
 */
?>


<header class="site-sidebar">
    <div class="site-sidebar__content">

    <?php
    /*
     * Project Title
     */
    the_title( '<h1 ' . timber_get_post_title_class_attr( 'site-sidebar__text' ) . '>', '</h1>' );
    echo '<div class="divider"></div>';
    timber_the_project_types();
    ?>

    </div>
</header>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/*
	 * Project film strip
	 */
	timber_the_film_strip();
	?>

</article><!-- #post-<?php the_ID(); ?> .entry-content -->

<div class="js-last"></div>
<div class="js-reference"></div>
<div class="js-current"></div>

<div class="site-content__mask  mask--project"></div>