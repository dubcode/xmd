<?php

/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
 * @package ExtraMile_Theme_2023
 */

$tags = get_the_tags();
$featured_image = get_the_post_thumbnail_url();
?>

<article class="single-post-outer container" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="single-post-inner border-b border-grey-400">
		
		<?php if( $featured_image ) : ?>
			<div class="featured-image-layer mb-10 lg:mb-24">
				<figure class="featured-overlay">
					<?= get_the_post_thumbnail() ?>
				</figure>
			</div>
		<?php endif ?>

		<div class="entry-content prose grid grid-cols-1 gap-8 lg:grid-cols-10 lg:gap-3">

			<div class="social-share order-last w-full flex flex-col items-center lg:col-span-1 lg:order-first">
				<?php get_template_part( 'partials/share-app' ); ?>
			</div>

			<div class="entry-content-main written lg:col-span-9">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers. */
							__('Continue reading<span class="sr-only"> "%s"</span>', 'extramile-theme-2023'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				// wp_link_pages(
				// 	array(
				// 		'before' => '<div>' . __('Pages:', 'extramile-theme-2023'),
				// 		'after'  => '</div>',
				// 	)
				// );
				?>
			</div>

		</div><!-- .entry-content -->

	</div>

</article><!-- #post-${ID} -->