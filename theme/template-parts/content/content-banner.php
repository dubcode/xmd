<?php if( get_post_type() == 'team' && is_single() ) :  ?>

    <?php get_template_part( 'template-parts/content/banner/banner', 'team', array() ); ?>

<?php else : ?>

    <div class="content-banner-container">
        <?php
        // Get the text colours for the banner
        $textColours = isset( $textColours ) ? $textColours : extramile_get_block_text_colours( get_field( 'background_colour' ) );
        
        //the carousel and background colour don't need an overlay
        if ($headerBackground && $headerType !== 'colour' && $headerBackground && $headerType !== 'carousel') : ?>
            <div class="page-header-overlay"></div>
        <?php
        endif;
        
        //output our video
        if ($headerBackground && $headerType == 'video') : ?>
            <video autoplay muted loop>
                <source src="<?= $headerBackground['url']; ?>" type="video/mp4" />
            </video>
        <?php endif;
        
        //output our carousel
        if ($headerType == 'slider') : ?>
            <div class="slider">
                <?php
                if(is_tag()) {
                    $id = $tag_id;
                } if(is_category()) {
                    $id = $category_id;
                } else if(is_woocommerce_activated() && is_product_category()) {
                    $id = 'product_cat_'.$productCat;
                } elseif(is_woocommerce_activated() && is_shop()) {
                    $id = $shopId;
                }  else if(is_404()) {
                    $id = $notFoundPage;
                } elseif( is_home() ) {
                    $id = get_queried_object_id();
                } else {
                    global $post;
                    $id = $post->ID;
                }
        
                if (have_rows('carousel', $id)) :
        
                    while (have_rows('carousel', $id)) : the_row();
                        $carouselType = get_sub_field('carousel_type');
        
                        if($carouselType == 'image') {
                            $background = get_sub_field('image');
                        } elseif($carouselType == 'video') {
                            $background = get_sub_field('video');
                        }
        
                        $title = get_sub_field('title');
                        $text = get_sub_field('text');
                        $button = get_sub_field('link');
        
                        //generate our carousel styles
                        if($carouselType == 'image') {
                            $carouselStyle = 'background-image: url(' . $background['url'] . ');';
                        }
                        ?>
        
                        <div class="emc-inner-slider <?php if($carouselType == 'colour') { echo 'slider-gradient'; } ?>" <?php if( $background && $carouselType == 'image' ) : ?>style="<?= $carouselStyle; ?>" <?php endif;?>>
                            <?php if( $background && $carouselType !== 'colour' ) { ?>
                                <div class="slider_overlay"></div>
                            <?php
                            }
        
                            if($background && $carouselType == 'video' ) : ?>
                                <video autoplay muted loop>
                                    <source src="<?= $background['url']; ?>" type="video/mp4" />
                                </video>
                            <?php endif; ?>
                            <div class="emc-slider-content">
                                <h2 class="slider-title"><?php echo $title; ?></h2>
                                <div class="slider-text"><?php echo $text; ?></div>
                                <?php if ($button) : ?>
                                    <a class="button-primary button-col-secondary" href="<?php echo $button['url']; ?>"><?php echo $button['title']; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    endwhile;
                endif; ?>
            </div>
        <?php
        else : ?>
            <div class="emc-page-header-content container">
                <div>
                <?php
        
                //get our header information depending on page type
                if(is_tag()) {
                    $headerInformation = get_field('header_information', $tag_id);
                } if(is_category()) {
                    $headerInformation = get_field('header_information', $category_id);
                } else if(is_woocommerce_activated() && is_product_category()) {
                    $headerInformation = get_field('header_information', 'product_cat_'.$productCat);
                } elseif(is_woocommerce_activated() && is_shop()) {
                    $headerInformation = get_field('header_information', $shopId);
                }  else if(is_404()) {
                    $headerInformation = get_field('header_information', $notFoundPage);
                } elseif( is_home() ) {
                    $id = get_queried_object_id();
                    $headerInformation = get_field('header_information', $id );
                } else {
                    $headerInformation = get_field('header_information');
                }
        
                if( isset( $headerInformation ) && !empty( $headerInformation ) ) {
                    //now get our header information
                    $hero_title = $headerInformation['page_title'];
                    $hero_description = $headerInformation['description'];
                    $hero_button = $headerInformation['button'];
                }
        
                if( isset( $hero_title ) && !empty( $hero_title ) && !is_search() ) {
                    //custom title entered, lets use that instead of the WP ones
                    ?>
                    <h1 class="banner-heading"><?= $hero_title; ?></h1>
                <?php } else {
                    //use the WP default titles
                    if (is_archive() || is_tag() ) :
                        $term = get_queried_object();
        
                        if(get_field('archive_title', $term)) {?>
                            <h1 class="banner-heading <?= $textColours['headings'] ?>"><?= ucfirst(get_field('archive_title', $term)); ?></h1>
                        <?php } else { ?>
                            <h1 class="banner-heading <?= $textColours['headings'] ?>"><?= ucfirst(single_term_title()); ?></h1>
                        <?php }
                    elseif( is_home() ) :  ?>
                        <?php $page = get_queried_object(); ?>
                        <h1 class="banner-heading <?= $textColours['headings'] ?>"><?= ucfirst( get_the_title( $page->ID ) ); ?></h1>
                    <?php elseif (is_search()) : ?>
                        <h1 class="banner-heading <?= $textColours['headings'] ?>">
                            <?php
                            /* translators: %s: search query. */
                            printf(esc_html__('Search Results for: %s', EXTRAMILE_THEME_SLUG), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h1>
                    <?php elseif (is_404()) : ?>
                        <h1 class="banner-heading <?= $textColours['headings'] ?>">Whoops, 404!</h1>
                    <?php elseif( is_single() ) :  ?>
                        <h1 class="banner-heading heading-2 text-grey-100"><?= ucfirst(get_the_title()); ?></h1>
                    <?php else : ?>
                        <h1 class="banner-heading <?= $textColours['headings'] ?>"><?= ucfirst(get_the_title()); ?></h1>
                    <?php endif;
                }
        
                if( isset( $hero_description ) ) {
                    //custom description has been entered
                    $sub_text = $hero_description;
                } else {
                    $term = get_queried_object();
        
                    if($term) {
                        $sub_text = get_field('header_sub_text', $term);
                    } else {
                        $sub_text = get_field('header_sub_text');
                    }
                }
        
                if (!empty($sub_text) && ! is_search() ) {
                    echo '<p class="subheading text-center text-grey-400 ">' . $sub_text . '</p>';
                } else if (is_tag() || is_category()) {
                    echo '<p class="subheading text-center ' . $textColours['body'] . '">' . $term->description . '</p>';
                }
        
                // Display tag list for single posts
                if( is_single() ) {
                    get_template_part( 'partials/post-tags', 'grid', array( 'post_id' => get_the_ID() ) );
                }

                if(!empty($hero_button)) { ?>
                    <a class="button-primary <?= $buttonColourClass ?> banner-button" href="<?php echo $hero_button['url']; ?>"><?php echo $hero_button['title']; ?></a>
                <?php } ?>
            </div>
            <?php 
        endif;
        ?>
    </div>

    <?php endif ?>
