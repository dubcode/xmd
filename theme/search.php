<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package extramile-template-2022
 */

get_header();

$search_results_after = get_field( 'after_search_results', 'option' );
?>

<main id="primary">


	<?php

	// dont show on home page, single product and account pages
	if( !is_front_page() && !is_singular('product') && !is_preview() && ( is_woocommerce_activated() && !is_account_page() ) ) {
		get_template_part('layout/header', 'content');
	}
	?>

	<section class="search-results-container pt-5 pb-12 lg:pt-14 lg:pb-24">

		<?php if (have_posts()) { ?>

			<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part('template-parts/content/content', 'search');

			endwhile;

			// ajax load more to go here

		} else { ?>
			<div class="emc-no-result-found">
				<div class="max-w-3xl m-auto py-12 px-5 lg:py-24">
					<p class="heading-3 text-center font-bold"><?= __('Sorry, no results were found matching the search term.') ?></p>
				</div>
				<?php
				/**
				 * Get the variables for the no results found message
				 */

				$search_title = get_field('search_title', 'option');
				$search_description = get_field('search_description', 'option');
				$blocks_page_obj = get_field('blocks_page', 'option');

				if ($search_title) : ?>
					<div class="mb-10">
						<h2 class="text-3xl text-center has-text-align-center"><?php echo $search_title; ?></h2>
					</div>
				<?php endif;
				if ($search_description) : ?>
					<div class="max-w-3xl m-auto">
						<p class="text-center has-text-align-center"><?php echo $search_description; ?></p>
					</div>
				<?php endif;

				// $blocks = parse_blocks($blocks_page_obj->post_content);

				// if ($blocks) {
				// 	foreach ($blocks as $key => $block) {

				// 		// show only the block in the index 0


				// 		if ('acf/flexible-grid' === $block['name']) {

				// 			echo '<div class="container  pb-5">';
				// 			echo render_block($block);
				// 			echo '</div>';
				// 		}
				// 	}
				// }

				?>
			</div>
		<?php } ?>

	</section>

</main><!-- #main -->

<?php
get_footer();
