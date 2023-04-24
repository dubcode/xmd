<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ExtraMile_Theme_2023
 */

get_header();
?>

	<section id="primary">
		<main id="main">
		<div class="container">
				<?php if ( have_posts() ) {
					// Load posts loop. ?>

						<?php get_template_part( 'template-parts/layout/archive', 'filter' ); ?>

						<div class="post-list-grid pb-12 lg:pb-24 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
							<?php while ( have_posts() ) {
								the_post();
								// get_template_part( 'template-parts/content/content' );
								get_template_part( 'partials/card', 'news', array( 'post_id' => get_the_ID() ) );
							} ?>
						</div>
					
					
					<?php
					// Previous/next page navigation.
					// extramile_theme_2023_the_posts_navigation();
					get_template_part( 'template-parts/layout/load', 'more' );
				} else {
					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/content/content', 'none' );
				}
				?>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
