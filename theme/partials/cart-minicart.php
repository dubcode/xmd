<?php
$top_bar_settings = isset( $args['top_bar_settings']) ? $args['top_bar_settings'] : '' ;
$show_payment_icons = isset( $top_bar_settings['enable_basket_payment_icons'] ) ? $top_bar_settings['enable_basket_payment_icons'] : '';
$payment_icons = isset( $top_bar_settings['accepted_payments_icons'] ) ? $top_bar_settings['accepted_payments_icons'] : '';
?>

<div class="floating-basket-container hidden">
    <div class="basket-floating-widget">
        <div class="floating-basket-header">
            <h5><?= __('Your bag', EXTRAMILE_THEME_SLUG) ?> (<?= WC()->cart->get_cart_contents_count(); ?>)</h5>

            <img class="floating-basket-icon-close" src="<?= get_template_directory_uri() . '/assets/img/basket-close.svg'; ?>" alt="Basket Close Icon">
        </div>

        <div class="floating-basket-content">
            <?php
            if(WC()->cart->is_empty()) { ?>
                <div class="floating-empty-cart-message">
                    <p><?= __('Your cart is currently empty', EXTRAMILE_THEME_SLUG) ?></p>

                    <a class="floating-basket-cart-empty-button" href="<?= get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?= __('Go Shopping', EXTRAMILE_THEME_SLUG) ?></a>
                </div>
            <?php
            } else {
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    $item_name = $cart_item['data']->get_title();
                    $price = wc_price( wc_get_price_including_tax( $_product ) );
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
                    ?>

                    <div class="floating-basket-product">
                        <img class="floating-product-image" src="<?= $image[0]; ?>" alt="Floating Product Image"/>
                        <div class="floating-product-details">
                            <p class="floating-product-name"><?= $item_name; ?></p>
                            <p class="floating-product-price"><?= $price . ' inc. VAT'; ?></p>

                            <?php
                            $product_parent = $_product->get_parent_id();

                            if ( $product_parent !== 0 ) { 
                                $parent = wc_get_product($product_parent);
                        
                                $variations = $parent->get_children();

                                if($variations) { ?>
                                    <div class="floating-product-variations">
                                        <ul class="cart-product-variations">
                                            <?php
                                            foreach($variations as $variation_id) { 
                                                $variation = new WC_Product_Variation($variation_id);
                                                $variableName = $variation->get_name();
                                                $nameSplit = explode(' - ', $variableName);
                                                $name = $nameSplit[1];
                                            ?>
                                                <li class="cart-product-variation"><?= $name; ?></li>
                                            <?php 
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                <?php
                }
            }
            ?>
        </div>

        <?php
        if(!WC()->cart->is_empty()) { ?>
            <div class="floating-basket-widget-footer">
                <div class="floating-subtotal">
                    <p class="floating-subtotal-text">Subtotal</p>
                    <p class="floating-subtotal-cost"><?= wc_price( WC()->cart->subtotal ); ?></p>
                </div>

                <div class="floating-wc-buttons">
                    <a class="floating-basket-bag-button" href="<?= wc_get_cart_url() ?>">View Bag</a>
                    <a class="floating-basket-checkout-button" href="<?= wc_get_checkout_url() ?>">Checkout</a>
                </div>

                <?php
                if($show_payment_icons) { ?>
                    <div class="floating-payment-info">
                        <p class="floating-payment-accept-text">We Accept</p>

                        <ul class="floating-payment-accept-icons">
                            <?php
                            foreach($payment_icons as $payment_icon) { 
                                $image = $payment_icon['payment_accepted_icon'];
                                ?>
                                <li class="floating-payment-icon">
                                    <img class="floating-payment-icon-image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>