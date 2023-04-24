<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

//global woocommerce query object
global $wp_query;

$posts_per_page = get_option('posts_per_page');

if(is_shop()) {
    $count_posts = wp_count_posts( 'product' );
    $productNumber = $count_posts->publish;

	if($productNumber > $posts_per_page) {
		$foundPosts = $posts_per_page;
	} else {
		$foundPosts = $productNumber;
	}
} else {
    $cat = get_queried_object();
    $productNumber = $cat->count;

	$foundPosts = (int)$wp_query->found_posts;

	if($foundPosts > $posts_per_page) {
		$foundPosts = $posts_per_page; //this is the max per page
	}
}

$paged = (int)$wp_query->paged;

$currentPage = $paged + 1; // Add one to our paged parameter as WP stores 0 as 1
$nextPage = $currentPage + 1;
?>
<nav class="woocommerce-pagination pt-12">
	<form class="form-load-more" id="form-load-more" name="form-load-more" method="post"> 
		<button class="load-more button-primary button-col-primary mb-5" data-text-default="<?= __('Load More Products', EXTRAMILE_THEME_SLUG); ?>"  data-text-loading="<?= __('Loading', EXTRAMILE_THEME_SLUG); ?>..."><?= __('Load More Products', EXTRAMILE_THEME_SLUG ); ?></button>
		<p class="pb-24"><?= wp_sprintf( __('Viewing %s of %s products', EXTRAMILE_THEME_SLUG), '<span id="lm-post-count" class="inline-block font-bold">'.$foundPosts.'</span>',  '<span id="lm-found-posts" class="inline-block text-bold">'.$productNumber.'</span>' ) ?></p>
		<input type="hidden" name="action" value="loadmore">
		<input type="hidden" name="post_type" value="product">
		<input type="hidden" name="max_num_pages" value="<?= $wp_query->max_num_pages ?>">
		<input type="hidden" name="current_page" value="<?= $currentPage; ?>">
		<?php if( is_object( $cat ) ) : ?>
			<input type="hidden" name="<?= $cat->taxonomy ?>" value="<?= $cat->term_id ?>">
		<?php endif ?>
</form>
</nav>
