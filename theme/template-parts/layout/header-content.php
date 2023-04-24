<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ExtraMile_Theme_2023
 */

 ?>

<div id="top-nav" class="z-[100] relative h-[54px] flex items-center bg-primary-dark">
	<?php
    $topBar = get_field('top_bar', 'option');

    $showTopBar = $topBar['top_bar_enabled'];

	if ($showTopBar) {
        $topBarSettings = $topBar['top_bar_customisations'];
        $showSearch = $topBarSettings['search_enabled'];
        $showLogin = $topBarSettings['enable_login_link'];
        $showBasket = $topBarSettings['enable_basket_link'];
        $showPaymentIcons = $topBarSettings['enable_basket_payment_icons'];
        $paymentIcons = $topBarSettings['accepted_payments_icons'];
        $showBasket = $topBarSettings['enable_basket_link'];
        $floatingBasket = $topBarSettings['enable_floating_basket_widget'];
        $showLanguage = $topBarSettings['enable_language_selector'];

        include __DIR__ . '/../nav/top-nav.php';
	}
	?>
</div>
<?php

//if is a tag page get the header_background_image from the id
$tag = get_queried_object();
$headerBackground = '';
$background = '';

if(is_tag()) {
    $tag_id = $tag->term_id;
    $activateHeader = get_field('header_active', 'post_tag_' . $tag_id);
    $activateHeader = true;
    $headerType = get_field('header_type', 'post_tag_' . $tag_id);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', 'post_tag_' . $tag_id);
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', 'post_tag_' . $tag_id);
    }
} elseif( is_category() ) {
    $category_id = $tag->term_id;
    $activateHeader = get_field('header_active', 'category_' . $category_id);
    $activateHeader = true;
    $headerType = get_field('header_type', 'category_' . $category_id);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', 'category_' . $category_id);
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', 'category_' . $category_id);
    }
} elseif( is_woocommerce_activated() && is_product_category() ) {
    $productCat = get_queried_object_id();

    $activateHeader = get_field('header_active','product_cat_' . $productCat);
    $headerType = get_field('header_type','product_cat_' . $productCat);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', $productCat);
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', $productCat);
    }
} elseif( is_woocommerce_activated() && is_shop()) {
    $shopId = get_option( 'woocommerce_shop_page_id' );

    $activateHeader = get_field('header_active', $shopId);
    $headerType = get_field('header_type', $shopId);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', $shopId);
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', $shopId);
    }
} elseif( is_404() ) {
    //get our 404 page ID
    $notFoundPage = get_field('404_page', 'option');
    $activateHeader = get_field('header_active', $notFoundPage);
    $headerType = get_field('header_type', $notFoundPage);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', $notFoundPage);
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', $notFoundPage);
    } elseif( $headerType == 'colour') {
        $backgroundColour = extramile_get_background_colour( get_field( 'background_colour', $notFoundPage ) );
        $textColours = extramile_get_block_text_colours( get_field( 'background_colour', $notFoundPage ) );
    }
} elseif( is_home() ) {
    $activateHeader = get_field('header_active', $tag->ID );
    $headerType = get_field('header_type', $tag->ID);

    if($headerType == 'video') {
        $headerBackground = get_field('background_video', $tag->ID );
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image', $tag->ID );
    } elseif( $headerType == 'colour') {
        $backgroundColour = extramile_get_background_colour( get_field( 'background_colour', $tag->ID ) );
        $textColours = extramile_get_block_text_colours( get_field( 'background_colour', $tag->ID ) );
    }
} else {
    $activateHeader = get_field('header_active');
    $headerType = get_field('header_type');

    if($headerType == 'video') {
        $headerBackground = get_field('background_video');
    } elseif($headerType == 'image') {
        $headerBackground = get_field('background_image');
    }
}

//create our Header CSS /classes
if($headerType == 'image') {
    $headerStyle = 'background-image: url(' . $headerBackground['url'] . ');';
} elseif($headerType == 'colour') {
    // $headerClass = 'emc-page-header-bg-colour';
    $backgroundColour = isset( $backgroundColour ) ? $backgroundColour : extramile_get_background_colour( get_field( 'background_colour' ) );
}


if( ($activateHeader || is_search() || is_single() ) && !is_product() ) : ?>

    <header class="emc-page-header sticky top-0 z-10 bg-primary">
        <?php //get our main header
        get_template_part('template-parts/nav/main', 'header');
        ?>

        <?php //add our mobile menu under banner content
        include __DIR__ . '/../content/content-mobile-menu.php';
        ?>
    </header>

    <section class="header-hero-banner <?= get_post_type() ?>-hero bg-no-repeat bg-cover bg-center relative -mt-20 md:-mt-[140px] <?php if($headerType !== 'slider') { echo 'normal-slider'; } ?> <?php if( $headerType == 'colour' && !empty( $backgroundColour ) ) { echo $backgroundColour; } ?> <?= is_single() && has_post_thumbnail() ? 'has-featured-image' : '' ?>" <?php if ($headerBackground && $headerType == 'image') : ?> style="<?= $headerStyle; ?>" <?php endif; ?>>
        <?php
        //use an include statement so it can see all our variables
        include __DIR__ . '/../content/content-banner.php';
        ?>
    </section>

    <?php 
    if( function_exists('yoast_breadcrumb') && !isset($block) && !is_front_page() && !is_single() ) {
        yoast_breadcrumb('<p id="breadcrumbs" class="container pt-8 block w-full text-primary' . '">', '</p>');
    }
        
    // Display backlink to news for single post
    if( is_single() ) {
        $posts_page_id = get_option( 'page_for_posts' );
        get_template_part( 'partials/back-to-link', null,  array( 'posts_page_id' => $posts_page_id, 'post_id' => get_the_ID() ) );
    }
    ?>
    

<?php endif ?>
