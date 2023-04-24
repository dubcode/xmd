<?php

/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;

if(is_shop()) {
    $count_posts = wp_count_posts( 'product' );
    $productNumber = $count_posts->publish;
} else {
    $cat = get_queried_object();
    $productNumber = $cat->count;
}

?>
<!-- remove -->
<div class="container clear-all-container mb-[17px] mt-8 md:mt-[57px]"></div>

<div class="container relative md:mb-8 mb-6">
    <div class="filter-orderby-container">
        
        <button class="px-5 py-3 emc-mobile-filter cursor-pointer">
            <?= __('Filters', EXTRAMILE_THEME_SLUG) ?> <i class="fas fa-sliders-h"></i>
        </button>

        <form action="<?php admin_url('admin-ajax.php') ?>" method="get" class="filter-form hidden items-start flex-wrap absolute left-0 p-8 bg-grey-400 md:static">
            <fieldset class="filter-container flex flex-wrap gap-3">
                <?php
                // create a dropdown for each product attribute and categories (if any)
                // $attributes = get_field('product_category_filters', 'option');
                
                if( isset($cat) && $filters = extramile_get_product_category_filters( $cat ) ) {

                    foreach( $filters as $attr_slug => $attr_terms ) {
                        $field = [];

                        // Get taxonomy object for attribute
                        $attribute = get_taxonomy( $attr_slug );
                        if( !$attribute ) continue;
                        if( !empty($attr_terms['options']) ) : 

                            $field['name'] = $attr_slug;
                            $field['id'] = 'filter-' . $attr_slug;
                            $field['class'] = 'woocommerce-widget-layered-nav-dropdown dropdown !min-w-[188px] w-full sm:w-auto';
                            $field['options'][] = array(
                                'value' => '',
                                'label' =>  wp_sprintf( __('Select %s', EXTRAMILE_THEME_SLUG), $attribute->label )
                            );

                            foreach( $attr_terms['options'] as $term_id ) : 
                                $term = get_term( $term_id, $attr_slug );

                                $field['options'][] = array(
                                    'value' => $term_id,
                                    'label' => $term->name
                                );
                            
                            endforeach; ?>

                            <?php get_template_part(
                                'template-parts/forms/select',
                                null,
                                $field
                            ) ?>
                        <?php endif ?>
                    <?php }
                }
                ?>
            </fieldset>

            <?php
            echo apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) )
            ?>
            <fieldset class="orderby-container">
                <span class="product-count pr-2.5 hidden md:block post-count"><span class="product-count-value"><?= $productNumber . '</span> Products'; ?></span>
                <div class="emc-custom-select">
                    <select name="orderby" class="orderby sm:!min-w-[188px] bg-white" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
                        <?php foreach ($catalog_orderby_options as $id => $name) : ?>
                            <option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="paged" value="1" />
                <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
            </fieldset>

            <?php if( isset( $cat ) ) : ?>
                <input type="hidden" name="<?= $cat->taxonomy ?>" value="<?= esc_attr( $cat->term_id ) ?>" />
            <?php endif ?>

            <input type="hidden" name="nonce" value="<?= wp_create_nonce('filter') ?>">
        </form>

    </div>
</div>