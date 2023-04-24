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

$after_post_list = get_field( 'after_post_list', 'option' );
$page = get_post( get_queried_object_id() );
$display_subscribe_form = get_field( 'display_subscribe_form', $page->ID );
$block_header = get_field('enable_block_header', $page->ID );
?>

	<section id="primary">

		<main id="main">

			<?php if( $display_subscribe_form ) : ?>
				<section class="subscribe-block py-8 border-b border-grey-400">
					<?php get_template_part( 'template-parts/blocks/subscribe', 'form' ); ?>
				</section>
			<?php endif ?>

			<?php if( $block_header ) : ?>
				<?php 
				// Get the values from the ACF fields.
				// Because the data is not passed through to the block
				$heading = get_field( 'block_header', $page->ID ); 
				$text = get_field( 'block_heading_text', $page->ID );
				$button = get_field( 'block_heading_button', $page->ID );
				?>

    			<?php get_template_part( 'template-parts/blocks/block', 'header', array( 'header' => $heading, 'text' => $text, 'button' => $button ) ) ?>
			<?php endif ?>

			<div class="container <?= !$block_header ? 'pt-12 lg:ppt-24' : '' ?>">
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

	
			<?php
			// Output the gutenberg blocks after the post list
			$page = get_post( get_queried_object_id() );
			$content =  apply_filters('the_content', $page->post_content); 
			echo $content;
			?>

		</main><!-- #main -->

	</section><!-- #primary -->

<?php
get_footer();
