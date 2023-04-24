<?php

// remove comma from category list in archive loop
add_filter('woocommerce_product_categories', function ($html) {
    return str_replace(', ', ' ', $html);
});

// remove comma from tag list in archive loop
add_filter('woocommerce_product_tags', function ($html) {
    return str_replace(', ', ' ', $html);
});


// Woocommerce change add to cart button for a read more button
add_filter('woocommerce_loop_add_to_cart_link', 'custom_woocommerce_loop_add_to_cart_link', 10, 2);
function custom_woocommerce_loop_add_to_cart_link($html, $product)
{
    $html = '<a href="' . get_permalink($product->get_id()) . '" class="button">' . __('View Product', 'woocommerce') . '</a>';
    return $html;
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 3; // 3 products per row
    }
}


/**
 * Cart Shortcode
 */

//code for cart addon
add_shortcode('woo_cart_but', 'woo_cart_but');
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but()
{
    ob_start();

    $cart_count = WC()
        ->cart->cart_contents_count; // Set variable for cart item count
    $cart_url = wc_get_cart_url(); // Set Cart URL

?>
    <a class="menu-item cart-contents" href="<?= $cart_url; ?>" title="My Basket">
        <?php
        if ($cart_count > 0) {
        ?>
            <span class="cart-contents-count text-white">Basket (<?= $cart_count; ?>)</span>
        <?php
        }
        ?>
    </a>
<?php
    return ob_get_clean();
}

//Add a filter to get the cart count
add_filter('woocommerce_add_to_cart_fragments', 'woo_cart_but_count');
/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count($fragments)
{

    ob_start();

    $cart_count = WC()
        ->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();

?>
    <a class="cart-contents menu-item" href="<?= $cart_url; ?>" title="<?php _e('View your shopping cart'); ?>">
        <?php

        if ($cart_count > 0) { ?>
            <span class="cart-contents-count text-white">(<?= $cart_count; ?>)</span>
        <?php } ?> </a>
<?php
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

//Add Cart Icon to an existing menu

add_filter('wp_nav_menu_top-menu_items', 'woo_cart_but_icon', 10, 2); // Change menu to suit - example uses 'top-menu'

/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 */
function woo_cart_but_icon($items, $args)
{
    $items .=  '[woo_cart_but]'; // Adding the created Icon via the shortcode already created

    return $items;
}

add_filter('wp_nav_menu_items', 'emc_dynamic_menu_item_label', 9999, 2);
function emc_dynamic_menu_item_label($items, $args)
{

    $items = trim($items);
    if (!is_user_logged_in()) {
        $items = str_replace("My account", "Login", $items);
    }
    return $items;
}

/**
 * @return add category link and title above the title or below the category
 *
 */
function theme_slug_add_category_above_title()
{
    global $product; ?>
    <p class="product__category">
        <?php
        $categories = get_the_terms( $product->get_id(), 'product_cat' );
        
        foreach ($categories as $category) {
            if($category->parent == 0){
                echo '<a class="category-label" href="' . $category->permalink  . '" rel="tag"> ' . $category->name . '</a>';
            }
        }
        ?>
    </p>
<?php }
// add_action('woocommerce_shop_loop_item_title', 'theme_slug_add_category_above_title', 9);




/**
 * Remove default actions/filters that load the product layout on category page
 * 
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

function woocommerce_template_loop_show_product_card() {
    global $product;

    // Load the product card
    get_template_part(
        'partials/card',
        'product',
        array(
            'product_id' => $product->get_id()
        )
    );
}
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_show_product_card', 10 );


/**
 * @snippet       Add to Cart Quantity drop-down - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 5.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

function woocommerce_quantity_input($args = array(), $product = null, $echo = true)
{

    if (is_null($product)) {
        $product = $GLOBALS['product'];
    }

    $defaults = array(
        'input_id' => uniqid('quantity_'),
        'input_name' => 'quantity',
        'input_value' => '1',
        'classes' => apply_filters('woocommerce_quantity_input_classes', array('input-text', 'qty', 'text'), $product),
        'max_value' => apply_filters('woocommerce_quantity_input_max', -1, $product),
        'min_value' => apply_filters('woocommerce_quantity_input_min', 0, $product),
        'step' => apply_filters('woocommerce_quantity_input_step', 1, $product),
        'pattern' => apply_filters('woocommerce_quantity_input_pattern', has_filter('woocommerce_stock_amount', 'intval') ? '[0-9]*' : ''),
        'inputmode' => apply_filters('woocommerce_quantity_input_inputmode', has_filter('woocommerce_stock_amount', 'intval') ? 'numeric' : ''),
        'product_name' => $product ? $product->get_title() : '',
    );

    $args = apply_filters('woocommerce_quantity_input_args', wp_parse_args($args, $defaults), $product);

    // Apply sanity to min/max args - min cannot be lower than 0.
    $args['min_value'] = max($args['min_value'], 0);
    // Note: change 20 to whatever you like
    $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : 20;

    // Max cannot be lower than min if defined.
    if ('' !== $args['max_value'] && $args['max_value'] < $args['min_value']) {
        $args['max_value'] = $args['min_value'];
    }

    $options = '';
    // set below as primary for the dropdown
    $options .= '<option> -- ' . __('Quantity', EXTRAMILE_THEME_SLUG ) . ' -- </option>';

    for ($count = $args['min_value']; $count <= $args['max_value']; $count = $count + $args['step']) {

        // Cart item quantity defined?
        if ('' !== $args['input_value'] && $args['input_value'] >= 1 && $count == $args['input_value']) {
            $selected = 'selected';
        } else $selected = '';

        $options .= '<option value="' . $count . '"' . $selected . '>' . $count . '</option>';
    }

    $string = '<label class="font-bold leading-[2em]" for="'.$args['input_name'] . '">' . __('Quantity', EXTRAMILE_THEME_SLUG ) . ' </label><div class="quantity emc-custom-select"><select name="' . $args['input_name'] . '">' . $options . '</select></div>';

    if ($echo) {
        echo $string;
    } else {
        return $string;
    }
}

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'emc_filter_dropdown', 10);

//change dropdown to name of variation
function emc_filter_dropdown($args)
{
    $var_tax = get_taxonomy($args['attribute']);

    if ($var_tax) {
        $args['show_option_none'] = apply_filters('the_title', $var_tax->labels->name);
    }

    return $args;
}

/**
 * Woocomerce shortcode to display attributes and values
 */

add_shortcode('emc_wc_product_attributes', 'emc_wc_product_attributes');

function emc_wc_product_attributes()
{
    global $product;
    $attributes = $product->get_attributes();

    // create table from data
    $html = '<table class="emc-attributes-table">';

    foreach ($attributes as $attribute) {
        $html .= '<tr>';
        $html .= '<td class="emc-attributes-table__label">' . $attribute->get_name() . '</td>';
        $html .= '<td class="emc-attributes-table__value">' . $attribute->get_options()[0] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;

}

/**
 * Change number of products that are displayed per page (shop page)
 */
if(!function_exists('emc_shop_pagination')) {
    function emc_shop_pagination( $query ) {
        if ( $query->is_main_query() && !is_admin()  ) {
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            // $query->set( 'posts_per_page', '12' );
            $query->set('paged', $paged);
            $query->set('orderby', ['menu_order', 'title']);
        }
    }
}
add_action( 'pre_get_posts', 'emc_shop_pagination', 10 );

/**
* Product Slug to ID
*/
if( !function_exists('emc_product_slug_to_id') ) {
    function emc_product_slug_to_id($slug) {
        if(get_page_by_path( $slug, OBJECT, 'product')) {
            $id = get_page_by_path( $slug, OBJECT, 'product')->ID;

            return $id;
        }
    }
}

/**
 * Remove WooCommerce breadcrumbs 
 */
add_action( 'init', 'emc_remove_wc_breadcrumbs' );

if(!function_exists('emc_remove_wc_breadcrumbs')) {
    function emc_remove_wc_breadcrumbs() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }
}

//remove the clear variations button
add_filter( 'woocommerce_reset_variations_link', '__return_empty_string', 9999 );
	
/**
 * Remove product page tabs
 */
// add_filter( 'woocommerce_product_tabs', 'emc_remove_all_product_tabs', 98 );

if(!function_exists('emc_remove_all_product_tabs')) {
    function emc_remove_all_product_tabs( $tabs ) {
        unset( $tabs['description'] );  // Remove the description tab
        unset( $tabs['reviews'] );       // Remove the reviews tab
        unset( $tabs['additional_information'] );   // Remove the additional information tab
        
        return $tabs;
    }
}

/**
 * Render WC login form
 */
if(!function_exists('emc_render_wc_login_form')) {
    function emc_render_wc_login_form( $atts ) { 
        if ( ! is_user_logged_in() ) {
            if ( function_exists( 'woocommerce_login_form' ) && function_exists( 'woocommerce_output_all_notices' ) ) {
                //render the WooCommerce login form
                ob_start();
                woocommerce_output_all_notices();
                woocommerce_login_form();
                return ob_get_clean();
            } else { 
                //render the WordPress login form
                return wp_login_form( array( 'echo' => false ));
            }
        } else {
            return "Hello there! Welcome back.";
        }
    }
}

add_shortcode( 'emc_wc_login_form', 'emc_render_wc_login_form' );

/**
 * @snippet   WooCommerce User Registration Shortcode
 */
add_shortcode('emc_wc_reg_form', 'emc_registration_form');

function emc_registration_form()
{
    if (is_admin()) return;
    if (is_user_logged_in()) return;
    ob_start();

    // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
    // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY

    do_action('woocommerce_before_customer_login_form');

?>
    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

        <?php do_action('woocommerce_register_form_start'); ?>

        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?= (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                ?>
            </p>

        <?php endif; ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?= (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                ?>
        </p>

        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>

        <?php else : ?>

            <p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

        <?php endif; ?>

        <?php do_action('woocommerce_register_form'); ?>

        <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
        </p>

        <?php do_action('woocommerce_register_form_end'); ?>

    </form>
<?php

    return ob_get_clean();
}

/**
 * Combine first and last name into one field
 */
add_filter( 'woocommerce_shipping_fields' , 'emc_remove_shipping_fields' );
add_filter( 'woocommerce_billing_fields' , 'emc_remove_billing_fields' );

if(!function_exists('emc_remove_billing_fields')) {
    function emc_remove_billing_fields( $fields ) {
        unset($fields['billing_last_name']);
        unset($fields['billing_company']);
        return $fields;
    }
}

if(!function_exists('emc_remove_shipping_fields')) {
    function emc_remove_shipping_fields( $fields ) {
        unset($fields['shipping_last_name']);
        unset($fields['shipping_company']);
        return $fields;
    }
}

add_filter( 'woocommerce_checkout_fields' , 'emc_rename_checkout_fields' );

/**
 * Rename WC checkout fields
 */
if(!function_exists('emc_rename_checkout_fields')) {
    function emc_rename_checkout_fields( $fields ) {
        $fields['billing']['billing_first_name']['placeholder'] = 'Jane Bloggs';
        $fields['billing']['billing_first_name']['label'] = 'Full name';
        $fields['billing']['billing_first_name']['class'] = 'form-row form-row-wide';

        $fields['shipping']['shipping_first_name']['placeholder'] = 'Jane Bloggs';
        $fields['shipping']['shipping_first_name']['label'] = 'Full name';
        $fields['shipping']['shipping_first_name']['class'] = 'form-row form-row-wide';

        $fields['billing' ]['billing_email' ]['priority'] = 11;
        $fields['billing']['billing_email']['label'] = 'Email Address';
        $fields['billing']['billing_email']['placeholder'] = 'i.e. jane@email.co.uk';
        
        $fields['shipping']['shipping_email' ]['priority'] = 11;
        $fields['shipping']['shipping_email']['label'] = 'Email Address';
        $fields['shipping']['shipping_email']['placeholder'] = 'i.e. jane@email.co.uk';

        $fields['billing']['billing_phone']['priority'] = 12;
        $fields['billing']['billing_phone']['label'] = 'Phone number';
        $fields['billing']['billing_phone']['placeholder'] = 'xxxxxxxxxx';

        $fields['shipping']['shipping_phone']['priority'] = 12;
        $fields['shipping']['shipping_phone']['label'] = 'Phone number';
        $fields['shipping']['shipping_phone']['placeholder'] = 'xxxxxxxxxx';

        return $fields;
    }
}

/**
 * Prevent WC sidebar error
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


if( !function_exists('extramile_woocommerce_show_product_images') ) {
    /**
     * Load custom single product image gallery
     *
     * @return void
     */
    function extramile_woocommerce_show_product_images() {
        wc_get_template( 'single-product/product-image-gallery.php' );
    }
}
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'extramile_woocommerce_show_product_images', 20 );


if( !function_exists( 'extramile_single_product_subscribe' ) ) {
    /**
     * Load the single product subscribe template file
     *
     * @return void
     */
    function extramile_single_product_subscribe() {
        wc_get_template_part( 'single-product/subscribe' );
    }
}
add_action( 'woocommerce_after_single_product_summary', 'extramile_single_product_subscribe', 50 );


if( !function_exists( 'extramile_single_product_video' ) ) {
    /**
     * Load the single product subscribe template file
     *
     * @return void
     */
    function extramile_single_product_video() {
        wc_get_template_part( 'single-product/video' );
    }
}
add_action( 'woocommerce_after_single_product_summary', 'extramile_single_product_video', 17 );


if( !function_exists( 'extramile_dropdown_variation_attribute_options_html' ) ) {
    /**
     * Add custom html wrapper to the variable dropdown fields
     *
     * @param [type] $html
     * @param [type] $args
     * @return void
     */
    function extramile_dropdown_variation_attribute_options_html( $html, $args ) {

        $custom_html = '<div class="emc-custom-select">' . $html .'</div>';
        return $custom_html;
    }
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'extramile_dropdown_variation_attribute_options_html', 10, 2 );



add_filter( 'woocommerce_product_tabs', 'extramile_single_product_tabs' );

if( !function_exists( 'extramile_single_product_tabs' ) ) {
    function extramile_single_product_tabs( $tabs ) {
        global $product;

        $faqs = get_field( 'product_faqs', $product->get_id() );
        $downloads = get_field( 'product_downloads', $product->get_id() );

        if( !empty($faqs) ) {
            $tabs['faqs'] = array(
                'title' => __('FAQs', EXTRAMILE_THEME_SLUG ),
                'priority' => 50,
                'callback' => 'extramile_faqs_tab_content',
            );
        }

        if( !empty($downloads) ) {
            $tabs['downloads'] = array(
                'title' => __( 'Downloads', EXTRAMILE_THEME_SLUG ),
                'priority' => 60,
                'callback' => 'extramile_downloads_tab_content',
            );
        }

        // Rename the default tabs description title
        if( isset( $tabs['description'] ) ) {
            $tabs['description']['title'] = __('Product Overview', EXTRAMILE_THEME_SLUG );
        }
        // Rename the additional info tab title
        if( isset( $tabs['additional_information'] ) ) {
            $tabs['additional_information']['title'] = __('Technical Table', EXTRAMILE_THEME_SLUG );
        }

        // By default this them doesn't show product reviews
        if( isset( $tabs['reviews'] ) ) {
            unset( $tabs['reviews'] );
        }
        
        return $tabs;
    }
}


// Add content to a custom product tab
function extramile_faqs_tab_content() {
    
    global $product;

    $faqs = get_field( 'product_faqs', $product->get_id() );

    if( empty( $faqs ) ) return;

    ?>
    <p class="heading-3 mb-8"><?= __('FAQs', 'extramile'); ?></p>

    <div class="faq-container">
        <div class="accordion accordion-flush accordion-installation-steps mb-5 lg:mb-12" id="faq-accordion">
            <?php
            $i = 1;
            while( have_rows( 'product_faqs' ) ) : the_row(); ?>
                <?php
                $question =  get_sub_field('question');
                $answer =  get_sub_field('answer');
                ?>
                <div class="accordion-item border-b border-grey-400">
                    <h2 class="accordion-header px-5" id="faq-accordion-heading-<?= $i; ?>">
                        <button class="accordion-button collapsed py-5" type="button" data-bs-toggle="collapse" data-bs-target="#product-faq-collapse-accordion-<?= $i; ?>"
                            aria-expanded="false" aria-controls="product-faq-collapse-accordion-<?= $i; ?>">
                            <?= esc_html( $question ) ?></button>
                        </button>
                    </h2>
                    <div id="product-faq-collapse-accordion-<?= $i; ?>" class="accordion-collapse"
                    aria-labelledby="faq-accordion-heading-<?= $i; ?>" data-bs-parent="#faq-accordion">
                        <div class="accordion-body">
                            <div class="accordion-text written text-grey-700">
                            <?=  $answer ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $i++; endwhile; ?>
        </div>
    </div>

    <?php
}

// Add content to a custom product tab
function extramile_downloads_tab_content()
{
    global $product;

    $downloads = get_field('product_downloads', $product->get_id());

    if( empty( $downloads ) ) return;
    ?>
    <p class="heading-3 mb-8"><?= __('Downloads', 'extramile'); ?></p>   

    <?php if( have_rows( 'product_downloads', $product->get_id() ) ) : ?>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4">

            <?php // Loop through rows.
            while( have_rows('product_downloads', $product->get_id() )) : the_row();

                $file = get_sub_field('download', $product->get_id() );

                if( $file ) :
                    $file_url = $file['url'];
                    $file_title = get_sub_field( 'title', $product->get_id() );
                    $file_description = get_sub_field( 'description', $product->get_id() );
                    $file_ext = pathinfo($file_url, PATHINFO_EXTENSION);
                    
                    $custom_file_icon = get_sub_field( 'download_icon', $product->get_id() );
                    $file_icon = $custom_file_icon ? 
                        '<img class="w-[30px] h-[40px] inline-block m-0" src="' . $custom_file_icon['sizes']['thumb'] . '" alt="' . $custom_file_icon['alt'] . '" />' :
                        '<img class="w-[30px] h-[40px] inline-block m-0" src="' . get_template_directory_uri() . '/assets/img/download-icon.svg" alt="' . $file_title . '" />';
                    ?>

                    <div class="download-box p-4 w-full min-h-[298px] flex flex-col items-center justify-center border border-gray-400">
                        <?= $file_icon ?>
                        <strong class="heading-6 block mb-2.5 mt-[26px] text-center"><?= $file_title ?></strong>
                        <a class="button-secondary button-col-primary text-white w-auto px-2 no-underline" href="<?= esc_attr( $file_url ) ?>" target="_blank"><?= __('Download', EXTRAMILE_THEME_SLUG ) ?></a>
                    </div>
                    
                <?php endif;

            endwhile; ?>

        </div>

    <?php endif ?>
    

    <?php
}