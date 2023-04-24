<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ExtraMile_Theme_2023
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function extramile_theme_2023_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'extramile_theme_2023_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function extramile_theme_2023_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'extramile_theme_2023_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function extramile_theme_2023_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'extramile-theme-2023' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'extramile-theme-2023' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'extramile-theme-2023' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'extramile-theme-2023' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'extramile-theme-2023' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'extramile-theme-2023' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'extramile-theme-2023' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'extramile-theme-2023' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'extramile-theme-2023' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'extramile-theme-2023' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'extramile-theme-2023' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'extramile_theme_2023_get_the_archive_title' );

/**
 * Determines if post thumbnail can be displayed.
 */
function extramile_theme_2023_can_show_post_thumbnail() {
	return apply_filters( 'extramile_theme_2023_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function extramile_theme_2023_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 */
function extramile_theme_2023_continue_reading_link() {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'extramile-theme-2023' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		return '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'extramile_theme_2023_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'extramile_theme_2023_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5 format,
 * adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function extramile_theme_2023_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'extramile-theme-2023' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'extramile-theme-2023' );
	}
	?>
	<<?= esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'extramile-theme-2023' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'extramile-theme-2023' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'extramile-theme-2023' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?= esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content prose">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}
