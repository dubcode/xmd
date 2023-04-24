<div class="container top-nav-search">
    <div class="grid grid-cols-2">
        <div class="search-container">
            <?php if($showSearch) { ?>
                <div class="flex items-center justify-center w-full lg:w-[494px]">
                    <form method="GET" class="m-0 w-full" action="<?= get_home_url() ?>">
                        <div class="flex items-center justify-start relative text-white px-4" style="background: #0E2345">
                            <label for="s" class="block bg-secondary p-1 mr-4 rounded-full">
                                <span class="sr-only">Search our website</span>
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="p-1 w-8 h-8 text-primary"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </label>
                            <input
                                type="search" name="s" placeholder="" autocomplete="off"
                                class="h-[54px] py-2 text-lg text-grey-400 rounded-md w-full bg-transparent"
                            />
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>

        <div class="quick-links-container flex justify-end">
            <!--<a href="/contact-us/" class="quick-links-contact hidden md:block h-[32px] w-[106px] leading-[30px] mt-[8px] border border-solid border-white rounded normal-case font-medium text-white text-base text-center hover:border-secondary hover:bg-secondary hover:text-white transition-all duration-300">Contact Us</a>-->
            <?php
            get_template_part('partials/social', 'icons');

            if($showLogin && is_woocommerce_activated() ) : ?>
                <a class="login-icon" href="<?= wc_get_page_permalink( 'myaccount' ) ?>"><i class="fas fa-user-circle"></i> <span class="login-text"><?= __('Login', EXTRAMILE_THEME_SLUG) ?></span></a>
            <?php endif;

            if($showBasket && !$showLanguage && is_woocommerce_activated() ) {

                $cartCount = WC()->cart->get_cart_contents_count();
                ?>
                <a class="basket-icon" href="<?= wc_get_cart_url() ?>">
                    <i class="fas fa-shopping-basket"></i> <span class="basket-text"><?= __('Basket', EXTRAMILE_THEME_SLUG) ?></span> <?php if($cartCount > 0) { echo '<span class="basket-icon-count">(' . $cartCount .  ')</span>'; } ?>
                </a>
                <?php
            } elseif($showLanguage) {
                //output the WPML language selector, needs styled in WPML
                echo do_shortcode( '[wpml_language_selector_widget]' );
            }
            ?>

            <div class="mobile-menu-container">
                <span class="menu-text">Menu</span>

                <a href="#" class="js-nav-toggle">
                    <img class="header-nav-toggle" src="<?= get_template_directory_uri() . '/assets/img/hamburger-icon.svg'; ?>" alt="tHamburger Icon">
                    <img class="header-nav-toggle-open hidden" src="<?= get_template_directory_uri() . '/assets/img/hamburger-icon-open.svg'; ?>" alt="tHamburger Icon">
                </a>
            </div>
        </div>

        <?php if( $floatingBasket && is_woocommerce_activated() ) : ?>

            <?php get_template_part( 'partials/cart', 'minicart', array('top_bar_settings' => $topBarSettings) ); ?>

        <?php endif ?>
    </div>
</div>
