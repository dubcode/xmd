<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ExtraMile_Theme_2023
 */

get_header();
?>

	<section id="primary">

		<main id="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
					get_template_part( 'template-parts/content/content', get_post_type() );

				// if ( is_singular( 'post' ) ) {
				// 	// Previous/next post navigation.
				// 	the_post_navigation(
				// 		array(
				// 			'next_text' => '<span aria-hidden="true">' . __( 'Next Post', 'extramile-theme-2023' ) . '</span> ' .
				// 				'<span class="sr-only">' . __( 'Next post:', 'extramile-theme-2023' ) . '</span> <br/>' .
				// 				'<span>%title</span>',
				// 			'prev_text' => '<span aria-hidden="true">' . __( 'Previous Post', 'extramile-theme-2023' ) . '</span> ' .
				// 				'<span class="sr-only">' . __( 'Previous post:', 'extramile-theme-2023' ) . '</span> <br/>' .
				// 				'<span>%title</span>',
				// 		)
				// 	);
				// }

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				// End the loop.
			endwhile;
			?>

			<?php wp_reset_postdata(); ?>

			<?php $enable_subscribe = get_field( 'enable_subscribe_form', 'option' ); ?>

			<?php if( $enable_subscribe ) : ?>

				<section class="subscribe-block border-t border-grey-400"><?php get_template_part( 'template-parts/blocks/subscribe', 'form' ); ?></section>

			<?php endif ?>


		</main><!-- #main -->

	</section><!-- #primary -->

<?php
get_footer();
