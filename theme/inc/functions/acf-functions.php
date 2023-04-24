<?php

/**
 * Register ACF options pages
*/

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_page(array(
        'page_title'    => __('Mega Menu'),
        'menu_title'    => __('Mega menu'),
        'menu_slug'     => 'theme-mega-menu-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'parent_slug' => 'themes.php',
    ));

    if(is_woocommerce_activated()) {
        acf_add_options_page(array(
            'page_title'    => __('Customisation'),
            'menu_title'    => __('Customisation'),
            'menu_slug'     => 'woocommerce-customisation-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'parent_slug' => 'woocommerce',
        ));
    }
}

add_filter('block_categories_all', function ($categories) {

    // Adding a new category.
    $categories[] = array(
        'slug'  => EXTRAMILE_THEME_SLUG,
        'title' => __('ExtraMile Blocks', EXTRAMILE_THEME_SLUG)
    );

    return $categories;
});

/**
 * Register ACF Blocks
*/
add_action('acf/init', 'emc_init_block_types');
if( !function_exists('emc_init_block_types') ) {
    function emc_init_block_types() {
        // Check function exists.
        if (function_exists('acf_register_block_type')) {
            // Grid Block
            acf_register_block_type(
                [
                    'name'              => 'grid',
                    'title'             => __('Grid', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A Standard / flexible grid template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/grid/grid.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('grid', 'standard', 'flexible'),
                    'mode'              => 'edit'
                ]
            );

            // Tabs Block
            acf_register_block_type(
                [
                    'name'              => 'tabs',
                    'title'             => __('Tabs', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A tabs template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/tabs/tabs.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('tabs'),
                    'supports'          => array(
                        'jsx' => true,
                    ),
                    'mode'              => 'edit'
                ]
            );

            // One Col Block
            acf_register_block_type(
                [
                    'name'              => 'one-col',
                    'title'             => __('One Column', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A one column template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/one-col/one-col.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('one', 'col'),
                    'mode'              => 'edit'
                ]
            );

            // Two Col Block
            acf_register_block_type(
                [
                    'name'              => 'two-col',
                    'title'             => __('Two Columns', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A two column template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/two-col/two-col.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('two', 'col'),
                    'mode'              => 'edit'
                ]
            );

            // Three Col Block
            acf_register_block_type(
                [
                    'name'              => 'three-col',
                    'title'             => __('Three Columns', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A three column template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/three-col/three-col.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('three', 'col'),
                    'mode'              => 'edit'
                ]
            );

            // Four Col Block
            acf_register_block_type(
                [
                    'name'              => 'four-col',
                    'title'             => __('Four Columns', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A four column template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/four-col/four-col.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('four', 'col'),
                    'mode'              => 'edit'
                ]
            );

            // Post Slider Block
            acf_register_block_type(
                [
                    'name'              => 'slider',
                    'title'             => __('Slider', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A product / News Slider template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/slider/slider.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('product', 'news', 'slider'),
                    'mode'              => 'edit'
                ]
            );

            // Banner Block
            acf_register_block_type(
                [
                    'name'              => 'banner',
                    'title'             => __('Banner', EXTRAMILE_THEME_SLUG),
                    'description'       => __('A custom banner template block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/banner/banner.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('banner'),
                    'mode'              => 'edit'
                ]
            );

            //subscribe block
            acf_register_block_type(
                [
                    'name'              => 'subscribe',
                    'title'             => __('Subscribe Form', EXTRAMILE_THEME_SLUG),
                    'description'       => __('Subscribe Form block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/subscribe/subscribe.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('subscribe', 'form'),
                    'mode'              => 'edit'
                ]
            );

            // shortcode block
            acf_register_block_type(
                [
                    'name'              => 'shortcode',
                    'title'             => __('Shortcode', EXTRAMILE_THEME_SLUG),
                    'description'       => __('Shortcode block.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/shortcode/shortcode.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('shortcode'),
                    'mode'              => 'edit'
                ]
            );
            
            // Post List Grid block
            acf_register_block_type(
                [
                    'name'              => 'post_list_grid',
                    'title'             => __('Post List Grid', EXTRAMILE_THEME_SLUG),
                    'description'       => __('Display posts of a specified type in a tile grid.', EXTRAMILE_THEME_SLUG),
                    'render_template'   => 'inc/blocks/post-list-grid/post-list-grid.php',
                    'category'          => EXTRAMILE_THEME_SLUG,
                    'icon'              => 'layout',
                    'keywords'          => array('post', 'grid', 'tile'),
                    'mode'              => 'edit'
                ]
            );
        }
    }
}

/**
 * Dynamically load ACF options
*/

function acf_load_color_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();


    // if has rows
    if( have_rows('approvals_repeater', 'option') ) {
        
        // while has rows
        while( have_rows('approvals_repeater', 'option') ) {
            
            // instantiate row
            the_row();
            
            
            // vars
            $value = get_sub_field('approval_image');
            $label = get_sub_field('label');

            
            // append to choices
            
            $field['choices'][ $value ] = $label;
            
        }
        
    }

    foreach ($field['choices'] as $key => $value) {
        return $field;
    }
    
    
}

add_filter('acf/load_field/name=approvals', 'acf_load_color_field_choices');