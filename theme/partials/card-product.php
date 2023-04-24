<?php
$product_id = isset( $args['product_id'] ) ? $args['product_id'] : '';
if( !$product_id ) return;

$product = wc_get_product( $product_id );

// get the price of the product
$price = get_post_meta($product->get_id(), '_price', true);
//get the currency symbol of the product
$currency = get_woocommerce_currency_symbol();
//get the product title
$title = $product->get_name();
//get the category of the product
$category = get_the_terms($product->get_id(), 'product_cat');
//get the product image
$image = get_the_post_thumbnail_url($product->get_id(), 'medium');
//get the link to the product
$link = get_permalink($product->get_id()); ?>

<div class="card product-card h-full flex">
    <div class="card-container bg-grey-200 flex flex-col">
        <figure class="product-image mb-8 p-4">
            <img src="<?php echo $image; ?>" alt="<?= $product->get_name() ?> thumbnail" />
        </figure>
        <div class="slider-content-container px-6 pb-8 flex flex-col flex-grow">
            <div class="mb-5">
                <?php
                foreach ($category as $cat) {
                    if($cat->parent == 0){
                        echo '<a href="' . esc_attr( get_term_link( $cat, 'product_cat' ) )  . '" class="category-label">'  . $cat->name . '</a>';
                    }
                }
                ?>
            </div>
            <div class="mb-5">
                <strong class="heading-6 my-0 block"><?php echo $title; ?></strong>
            </div>
            <div class="flex gap-3 mt-auto">
                <?php if( $price ) : ?>
                    <span class="product-price text-2xl flex-grow"><?= $currency . $price; ?></span>
                <?php endif ?>
                <a class="button-secondary button-col-primary" href="<?php echo $link; ?>"><?= __('View Product', EXTRAMILE_THEME_SLUG) ?></a>
            </div>
        </div>
    </div>
</div>