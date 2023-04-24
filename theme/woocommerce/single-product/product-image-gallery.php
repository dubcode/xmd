<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'w-full',
	)
);
//  Get the full video URL
$video = get_field( 'youtube__vimeo_video_url' );
$video_url_array = explode( '/', $video);
$youtube_video_id = end( $video_url_array );
// Prepare the attributes required for the modal
$modal_id = $product->get_slug() . '-video-modal';
$modal_title = $product->get_name() . ' VIDEO';
$modal_content = '<div class="relative h-0 w-full pb-[56.25%] overflow-hidden"><iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/' . $youtube_video_id . '"></iframe></div>';

// Merge all product images into a single array
if( ! empty( $post_thumbnail_id ) ) {
    array_unshift($attachment_ids, $post_thumbnail_id);
}
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> " data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
		
        <div class="woocommerce-product-gallery-slider-container relative">
        
            <?php if( count( $attachment_ids ) > 0 ) : ?>
                <div class="woocommerce-product-gallery w-full <?= count( $attachment_ids ) > 1 || $video ? 'init-slider' : '' ?>">
                    <?php foreach( $attachment_ids as $attachment_id ) : ?>
                        <figure class="woocommerce-product-gallery__wrapper flex justify-center items-center flex-wrap">
                            <?php echo wp_get_attachment_image( $attachment_id, 'medium', null, array( 'class' => 'mx-auto w-full' ) ); ?>
                        </figure>
                    <?php endforeach; ?>

                    <?php if( $video ) : ?>
                        <figure class="woocommerce-product-gallery__wrapper flex justify-center items-center flex-wrap">
                            <!-- Button trigger modal -->
                            <button type="button" class="block w-full relative group" data-bs-toggle="modal" data-bs-target="#<?= $modal_id ?>">
                                <img src="https://img.youtube.com/vi/<?= $youtube_video_id ?>/hqdefault.jpg" alt="video thumbnail" class="mx-auto">
                                <div class="flex justify-center items-center text-white absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-7xl group-hover:text-jcpprimary">
                                    <i class="far fa-play-circle"></i>
                                </div>
                            </button>
                        </figure>                        
                    <?php endif ?>
                </div>
                <?php if( count( $attachment_ids ) > 1 || $video ) : ?>
                    <div class="woocommerce-product-gallery-thumbs__container">
                        <ul class="woocommerce-product-gallery-thumbs init-slider">
                            <?php foreach( $attachment_ids as $attachment_id ) : ?>
                                <li class="woocommerce-product-gallery-thumb p-1.5">
                                    <div class="bg-white flex items-center justify-center">
                                        <figure class="">
                                            <?= wp_get_attachment_image( $attachment_id, 'thumbnail' ) ?>
                                        </figure>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <?php if( $video ) : ?>
                                <figure class="woocommerce-product-gallery-thumb p-1.5 h-full">
                                    <!-- Button trigger modal -->
                                    <div class="bg-white flex items-center justify-center relative h-full">
                                        <img src="https://img.youtube.com/vi/<?= $youtube_video_id ?>/hqdefault.jpg" alt="<?= $product->get_name() ?> video thumbnail" class="mx-auto !h-full object-cover">
                                        <div class="flex justify-center items-center text-white absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl">
                                            <i class="far fa-play-circle"></i>
                                        </div>
                                    </div>
                                </figure>                        
                            <?php endif ?>
                        </ul>
                    </div>
                <?php endif ?>

            <?php else : ?>

                <div class="woocommerce-product-gallery__image--placeholder">
                    <?= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) ); ?>
                </div>

            <?php endif ?>

        </div>

	</figure>
</div>
<?php // Load the modal
get_template_part( 'template-parts/partials/modal', null, array( 'id' => $modal_id, 'modal_title' => $modal_title, 'modal_content' => $modal_content ) ); ?>