<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Timber
 */

if ( ! function_exists( 'timber_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 */
	function timber_paging_nav( $max_num_pages = '' ) {
		// Get max_num_pages if not provided
		if ( '' == $max_num_pages ) {
			$max_num_pages = $GLOBALS['wp_query']->max_num_pages;
		}
		// Don't print empty markup if there's only one page.
		if ( $max_num_pages < 2 ) {
			return;
		} ?>
		<nav class="navigation posts-navigation clearfix" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'timber' ); ?></h2>
			<div class="nav-links">

				<?php if ( get_next_posts_link( '', $max_num_pages ) ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'timber' ), $max_num_pages ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link( '', $max_num_pages ) ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'timber' ), $max_num_pages ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'timber' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'timber_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function timber_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'timber' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'timber' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'timber_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function timber_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'timber' ) );
		if ( $categories_list && timber_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'timber' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'timber' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'timber' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'timber' ), esc_html__( '1 Comment', 'timber' ), esc_html__( '% Comments', 'timber' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'timber' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'timber' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'timber' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'timber' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'timber' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'timber' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'timber' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'timber' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'timber' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'timber' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'timber' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'timber' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'timber' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'timber' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'timber' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function timber_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'timber_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'timber_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so timber_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so timber_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in timber_categorized_blog.
 */
function timber_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'timber_categories' );
}
add_action( 'edit_category', 'timber_category_transient_flusher' );
add_action( 'save_post',     'timber_category_transient_flusher' );


if ( ! function_exists( 'timber_get_custom_excerpt' ) ) :
	/**
	 * Generate a custom post excerpt suited to both latin alphabet languages and multibyte ones, like Chinese of Japanese
	 */
	function timber_get_custom_excerpt( $post_id = null ) {
		$post = get_post( $post_id );

		if ( empty( $post ) ) {
			return '';
		}

		//so we need to generate a custom excerpt
		//
		//the problem arises when we are dealing with multibyte characters
		//in this case we need to do a multibyte character length excerpt not the regular, number of words excerpt
		//but first we need to detect such a case

		//the excerpt returned by WordPress
		$excerpt = get_the_excerpt();
		//now we try to truncate the default excerpt with the length = number of words * 6 - the average word length in English
		$mb_excerpt = timber_truncate( $excerpt, ( apply_filters( 'excerpt_length', 55 ) * 6 ) );

		//if the multibyte excerpt's length is smaller then the regular excerpt's length divided by 1.8 (this is a conservative number)
		//then it's quite clear that the default one is no good
		//else leave things like they used to work
		if ( mb_strlen( $mb_excerpt ) < mb_strlen( $excerpt ) / 1.8 ) {
			$excerpt = $mb_excerpt;
		}
		return $excerpt;
	}
endif;

if ( ! function_exists( 'timber_post_excerpt' ) ) :
	/**
	 * Display the post excerpt, either with the <!--more--> tag or regular excerpt
	 *
	 * @param int|WP_Post $id Optional. Post ID or post object.
	 * @return string The custom excerpt
	 */
	function timber_post_excerpt( $post_id = null ) {
		$post = get_post( $post_id );

		if ( empty( $post ) ) {
			return '';
		}

		// Check the content for the more text
		$has_more = strpos( $post->post_content, '<!--more' );

		//when we encounter a read more tag, we respect that and forget about doing anything automatic
		if ( $has_more ) {
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'timber' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
		} elseif ( has_excerpt( $post ) ) {
			//in case of a manual excerpt we will go forth as planned - no processing
			the_excerpt();
		} else {
			//need custom generated excerpt
			echo apply_filters('the_excerpt', timber_get_custom_excerpt( $post ) );
		}
	} #function
endif;

if ( ! function_exists( 'timber_get_option' ) ) :
	/**
	 * Get option from the database
	 *
	 * @param string
	 * @return mixed
	 */
	function timber_get_option( $option, $default = null ) {
		// @TODO Need logic here - mix of Customify and the rest of the options
		// @TODO also decide if this function will get theme options as well or we go for another function
		global $pixcustomify_plugin;

		// if there is set an key in url force that value
		if ( isset( $_GET[ $option ] ) && ! empty( $option ) ) {

			return $_GET[ $option ];

		} elseif ( $pixcustomify_plugin !== null ) {

			$cutomify_value = $pixcustomify_plugin::get_option( $option, $default );

			return $cutomify_value;

			// in the future get theme options if this is null
//			if ( $cutomify_value !== null ) {
//				return $cutomify_value;
//			} else {
//			}
		}

		return $default;
	} #function
endif;

if ( ! function_exists( 'timber_the_film_strip' ) ) :
	/**
	 * Display the film strip
	 *
	 * @param int|WP_Post $id Optional. Post ID or post object.
	 */
	function timber_the_film_strip( $post_id = null ) {
		echo timber_get_film_strip( $post_id );
	}

endif;

if ( ! function_exists( 'timber_get_film_strip' ) ) :
	/**
	 * Return the film strip markup
	 *
	 * @param int|WP_Post $id Optional. Post ID or post object.
	 * @return string The film strip markup
	 */
	function timber_get_film_strip( $post_id = null ) {
		$post = get_post( $post_id );

		if ( empty( $post ) ) {
			return '';
		}

		$output = '';

		//let's get cranking at processing the content and make a film strip out of it
		$content = $post->post_content;

		/* FIRST DEAL WITH GALLERIES - [gallery] shortcode - THIS IS A HARD/TOP LEVEL LIMIT */

		$galleries = timber_get_post_galleries( $post, false );

		if ( ! empty( $galleries ) ) {
			foreach ( $galleries as $gallery ) {
				if ( ! empty( $gallery['ids'] ) ) {
					//we've got a proper gallery on our hands

					//let's get the content before the shortcode
					$pos = strpos( $content, $gallery['original'] );
					$before_content = substr( $content, 0, $pos );

					//now let's process this content and get it in the film strip
					$output .= timber_process_partial_content_into_film_strip( $before_content );

					//delete everything in front of the shortcode including it
					$content = trim( substr( $content, $pos + strlen( $gallery['original'] ) ) );

					//now make a film strip box for each image in the gallery
					$gallery_ids = explode(',', $gallery['ids'] );

					foreach ( $gallery_ids as $key => $attachment_id ) {
						$output .= timber_get_film_strip_image( $attachment_id );
					}
				}
			}
		}

		if ( ! empty( $content ) ) {
			//there is some content left - let's process it
			$output .= timber_process_partial_content_into_film_strip( $content );
		}

		return $output;

	}

endif;

/**
 * Return markup for the film strip given a gallery-free piece of content
 *
 * @param string Partial post content
 * @return string The markup
 */
function timber_process_partial_content_into_film_strip( $content ) {
	$markup = '';

	//a little bit of cleanup
	$content = trim( $content );
	$content = apply_filters( 'the_content', $content );

	//do nothing if we have no content
	if ( empty( $content ) ) {
		return $markup;
	}

	//split this content by images (<img> tag)
	$num_matches = preg_match_all("!(?:<\s*p\s?[^>]*>\s*)?(?:<\s*figure\s?.*>\s*)?(?:<\s*?a\s?.*>\s*)?<\s*img\s?.*src=[\"|']([^\"']*)[\"|'].*alt=[\"|']([^\"']*)[\"|'].*/>(?:\s*</a\s*>)?(?:\s*<\s*figcaption\s?[^>]*>([^>]*)\s*</figcaption\s*>)?(?:\s*</figure>)?(?:\s*</p\s*>)?!i", $content, $matches);

	for ( $idx = 0; $idx < $num_matches; $idx++ ) {
		//first let's see if there is some content before the current match
		$pos = strpos( $content, $matches[0][ $idx ] );
		$before_content = trim( substr( $content, 0, $pos ) );
		if ( ! empty( $before_content ) ) {
			//first a little bit of safety - better safe than sorry
			$before_content = balanceTags( $before_content, true );
			//let's make a text box
			$markup .= '<div class="film-strip--box">' . PHP_EOL;
			$markup .= '<div class="film-strip--text">' . $before_content . '</div>' . PHP_EOL;
			$markup .= '</div><!-- .film-strip--box -->' . PHP_EOL;
		}

		//delete everything in front of the current match including it
		$content = trim( substr( $content, $pos + strlen( $matches[0][ $idx ] ) ) );

		//now let's handle the current match
		//let's see if we have a caption
		$caption = "";
		if ( ! empty( $matches[3][ $idx ] ) ) {
			$caption = $matches[3][ $idx ];
		}
		//first try and get an attachment ID - we may fail because it is an external image
		$attachment_id = timber_attachment_url_to_postid( $matches[1][ $idx ] );
		if ( $attachment_id ) {
			$markup .= timber_get_film_strip_image( $attachment_id, $caption );
		} else {
			//we have an external image

			//IGNORE IT for now as we can't reliably get dimensions
		}
	}

	if ( ! empty( $content ) ) {
		//we have one last text box

		//first a little bit of safety - better safe than sorry
		$content = balanceTags( $content, true );
		//let's make a text box
		$markup .= '<div class="film-strip--box">' . PHP_EOL;
		$markup .= '<div class="film-strip--text">' . $content . '</div>' . PHP_EOL;
		$markup .= '</div><!-- .film-strip--box -->' . PHP_EOL;
	}

	return $markup;
}

if ( ! function_exists( 'timber_get_film_strip_image' ) ) :
	/**
	 * Return markup for a single image in the film strip
	 *
	 * @param int Attachment ID
	 * @return string The image markup
	 */
	function timber_get_film_strip_image( $id = null, $caption = "" ) {
		$markup = '';

		//do nothing if we have no ID
		if ( empty( $id ) ) {
			return $markup;
		}

		$image_full_size = wp_get_attachment_image_src( $id, 'full' );
		$image_small_size = wp_get_attachment_image_src( $id, 'timber-small-images' );
		$image_large_size = wp_get_attachment_image_src( $id, 'timber-large-images' );
		$markup .= '<div class="film-strip--box">' . PHP_EOL;
		$markup .= '<div class="film-strip--image"
	data-srcsmall="' . $image_small_size[0] . '"
	data-srclarge="' . $image_large_size[0] . '"
	data-srcfull="' . $image_full_size[0] . '"
	data-alt="' . esc_attr( timber_get_img_alt( $id ) ) . '"';

		if ( ! empty( $caption ) ) {
			$markup .= '
	data-caption="' . esc_attr( $caption ) . '"';
		}

		$markup .= '
	data-width="' . $image_full_size[1] . '"
	data-height="' . $image_full_size[2] . '"></div>' . PHP_EOL;

		//some accessibility
		$markup .= '<noscript><img itemprop="image" src="' . $image_full_size[0] . '" alt="' . esc_attr( timber_get_img_alt( $id ) ) . '" width="' . $image_full_size[1] . '" height="' . $image_full_size[2] . '"></noscript>' . PHP_EOL;
		$markup .= '</div><!-- .film-strip--box -->' . PHP_EOL;

		return $markup;
	}

endif;

if ( ! function_exists( 'timber_get_post_galleries' ) ) :
	/**
	 * Retrieves galleries from the passed post's content.
	 * Modified version of the core get_post_galleries() because we wanted the matched string also returned
	 *
	 *
	 * @param int|WP_Post $post Post ID or object.
	 * @param bool        $html Optional. Whether to return HTML or data in the array. Default true.
	 * @return array A list of arrays, each containing gallery data and srcs parsed
	 *               from the expanded shortcode.
	 */
	function timber_get_post_galleries( $post, $html = true ) {
		if ( ! $post = get_post( $post ) )
			return array();

		if ( ! has_shortcode( $post->post_content, 'gallery' ) )
			return array();

		$galleries = array();
		if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $shortcode ) {
				if ( 'gallery' === $shortcode[2] ) {
					$srcs = array();

					$gallery = do_shortcode_tag( $shortcode );
					if ( $html ) {
						$galleries[] = $gallery;
					} else {
						preg_match_all( '#src=([\'"])(.+?)\1#is', $gallery, $src, PREG_SET_ORDER );
						if ( ! empty( $src ) ) {
							foreach ( $src as $s )
								$srcs[] = $s[2];
						}

						$data = shortcode_parse_atts( $shortcode[3] );
						$data['src'] = array_values( array_unique( $srcs ) );

						//add the matched string also
						$data['original'] = $shortcode[0];
						$galleries[] = $data;
					}
				}
			}
		}

		/**
		 * Filter the list of all found galleries in the given post.
		 *
		 * @since 3.6.0
		 *
		 * @param array   $galleries Associative array of all found post galleries.
		 * @param WP_Post $post      Post object.
		 */
		return apply_filters( 'get_post_galleries', $galleries, $post );
	}
endif;