<?php

if( is_woocommerce_activated() && is_product() ) {
    global $product;

    $sfGroup = get_field('subscription_form', 'option');

    $title = $sfGroup['title'];
    $description = $sfGroup['content'];
    $form = $sfGroup['form_shortcode'];
} else {
    $title = get_field('title');
    $description = get_field('description');
    $form = get_field('form');
}

// Add support for plugin:articles
// TODO: this template file shouldn't have to process things like this, it prevents it getting called from other places
if(get_post_type() == 'news-articles' || ( get_post_type() == 'post' || get_post_type() == 'team' ) || is_home() ) {
    
    $subOptions = get_field('subscription_form', 'option');

    $title = $subOptions['title'];
    $description = $subOptions['content'];
    $form = $subOptions['form_shortcode'];
}
?>

<div class="container">
    <div class="subscribe-container xl:grid xl:grid-cols-12 xl:gap-3">
        <div class="subscribe-text-container xl:col-span-7">
            <h2 class="subscribe-title"><?php echo $title; ?></h2>
            <p class="subscribe-description"><?php echo $description; ?></p>
        </div>
        <div class="subscribe-form-container xl:col-span-5">
            <div class="subscribe-form">
                <?php echo do_shortcode($form); ?>
            </div>
        </div>
    </div>
</div>
