<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package extramile-template-2022
 */

?>

<article id="post-<?php the_ID(); ?>" class="emc-search">

	<div class="search-result-item">

		<div class="">
			<header>
				<?php the_title(sprintf('<h2 class="heading-4 mb-5"><a class="text-inherit hover:text-primary transition-colors" href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
			</header>
		</div>

		<div class="label-container flex gap-3">
			<?php
			// Product posts show the product category
			if( get_post_type( get_the_ID() ) == 'product' ) {

				$product_categories = get_the_terms($post->ID, 'product_cat');

				foreach ($product_categories as $product_category) {
					$product_category_name = $product_category->name;
					$product_category_link = get_term_link($product_category);
					$product_category_slug = $product_category->slug;

					echo '<div class="emc-category product_cat-'. $product_category_slug .'"><a class="text-white px-3 py-2 text-sm"  href="' . $product_category_link . '">' . $product_category_name . '</a></div>';
				}

			}

			if( get_post_type( get_the_ID() ) != 'product' ) {

				$categories = get_the_category();

				if( $categories ) {

					foreach ($categories as $category) {

						$category_name = $category->name;
						$category_link = get_term_link($category);
						?>

						<div class="emc-category"><a class="category-label"  href="<?= $category_link ?>"><?= $category_name ?></a></div>

					<?php }

				} else { ?>

					<div class="emc-category">
						<a class="category-label" href="<?= get_the_permalink() ?>"> <?= __('Visit page') ?></a>
					</div>

				<?php }
			}

			?>
		</div>

		<div class="w-full mt-5 text-grey">
			<?php the_excerpt(); ?>
		</div>

	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->