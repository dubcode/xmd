<?php

/**
 * WooCommerce product Filter Ajax.
 *
 * Added check to only run if WooCommerce is activated
 */

if(is_woocommerce_activated()) {
    add_action('wp_ajax_filter', 'filter'); // wp_ajax_{action}
    add_action('wp_ajax_nopriv_filter', 'filter'); // wp_ajax_nopriv_{action}

    function filter() {

        $action = isset( $_POST['action'] ) ? $_POST['action'] : '';
        $filters = isset( $_POST['filter'] ) ? $_POST['filter'] : '';
        
        // If no filter data, we can't filter
        if( !$filters ) return;

        parse_str( $filters, $filters_arr );

        // Get the nonce
        $nonce = isset( $filters_arr['nonce'] ) ? $filters_arr['nonce'] : '';
    
        // Check the nonce
        if( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, $action ) ) {
            exit;
        }

        $posts_per_page = isset( $_POST['posts_per_page']) ? $_POST['posts_per_page'] : get_option( 'posts_per_page' );        

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'paged' => isset( $filters_arr['paged'] ) ? $filters_arr['paged'] : 1,
            'posts_per_page' => $posts_per_page,
            'orderby' => ['menu_order','title']
        );

        // Default filter is menu_order title
        // Ordering dropdown uses menu_order only so we ignore this orderby value
        if( isset( $filters_arr['orderby'] ) && $filters_arr['orderby'] != 'menu_order' ) {
            $orderby_arr = explode( '-', $filters_arr['orderby'] );
            
            $args['orderby'] = $orderby_arr[0];

            if( count( $orderby_arr ) > 1 ) {
                $args['order'] = strtoupper( $orderby_arr[1] );
            }
        }

        $tax_query  = ['relation' => 'AND'];

        if( isset( $filters_arr['product_cat'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => array( $filters_arr['product_cat'] )
            );
        }

        // Remove no longer required filter elements
        // Makes the loop easier below
        unset( $filters_arr['product_cat'] );
        unset( $filters_arr['paged'] );
        unset( $filters_arr['orderby'] );
        unset( $filters_arr['nonce'] );

        if ( !empty( $filters_arr ) ) {

            foreach ($filters_arr as $tax_slug => $term_id) {       
                if( !empty($term_id ) ) {
                    $tax_query[] = array(
                        'taxonomy' => $tax_slug,
                        'field' => 'term_id',
                        'terms' => $term_id,
                    );
                }
            }

        }

        if( count( $tax_query) > 1 ) {
            $args['tax_query'] = $tax_query;
        }

        $products = new WP_Query($args);

        // We already have the first page of products
        // Increase this by 1
        $page = (int)$products->paged + 1;

        ob_start();

        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
        } else {
            // Make the below a template part ?>
            <p class="text-center"><?= __('Sorry, we coudln\'t find any products that match', EXTRAMILE_THEME_SLUG ); ?></p>
            <?php
        }

        $result['products'] = ob_get_clean();
        $result['found_posts'] = $products->found_posts;

        if($page == 1) {
            $result['total_posts'] = $products->post_count;
        } else {
            //get previous pages and multiply by products per page
            $page -=1;
            $result['total_posts'] = ($posts_per_page * $page) + $products->post_count;
        }

        echo json_encode($result);

        wp_reset_postdata();

        die();
    }
}

/**
 * WooCommerce posts Filter Ajax.
 */

add_action('wp_ajax_filter_posts', 'filter_posts'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts'); // wp_ajax_nopriv_{action}

function filter_posts()
{
    // new products query based on the selected filters
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'fields' => 'ids',
    );

    if (isset($_POST['filter']) && $_POST['filter'] != '') {
        $args['tax_query'] = array(
            'relation' => 'AND'
        );

        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $_POST['filter'],
        );
        
    }
    //sort by and order without reseting the filters
    if (isset($_POST['sort']) && $_POST['sort'] != '') {
        $args['orderby'] = $_POST['sort'];
        $args['order'] = $_POST['order'];
    }

    $query = new WP_Query($args);

    $page = (int)$query->paged+1;

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('partials/archive-loop', 'content');
        }
    } else {
        echo '<p class="text-center">No posts found</p>';
    }

    if($page == 1) {
        $total_posts = $query->post_count;
    } else {
        //get previous pages and multiply by products per page
        $page -=1;
        $total_posts = (6 * $page) + $query->post_count;
    }

    $result = [
        'posts' => ob_get_clean(),
        'found_posts' => $query->found_posts,
        'total_posts' => $total_posts
    ];

    echo json_encode($result);

    // reset the query

    wp_reset_postdata();
    die();
}

/**
 * Load More functionality
 */

add_action('wp_ajax_loadmore', 'extramile_load_more_posts');
add_action('wp_ajax_nopriv_loadmore', 'extramile_load_more_posts');

function extramile_load_more_posts() {

    $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
    $post_per_page = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : get_option('posts_per_page');
    $product_cat = isset($_POST['product_cat']) ? $_POST['product_cat'] : '';
    $filters = isset( $_POST['filter'] ) ? $_POST['filter'] : '';
    $query_settings = isset( $_POST['query'] ) ? $_POST['query'] : '';

    // Convert post data string into arrays
    parse_str( $filters, $filters_arr );
    parse_str( $query_settings, $query_arr );

    $args = array(
        'paged' => $paged,
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'post_type' => $query_arr['post_type'],
        'orderby' => ['menu_order', 'title'],
    );

    if( isset($_POST['order']) ) {
        $args['order'] = $_POST['order'];
    }

    if( isset($_POST['orderby']) ) {
        $args['orderby'] = $_POST['orderby'];
    } elseif( isset( $query_arr['orderby'] ) ) {
        $args['orderby'] = $query_arr['orderby'];
    }

    // Removed unwanted values from the filter data
    // This simplifies the creation of the tax query
    unset( $filters_arr['paged'] );
    unset( $filters_arr['orderby'] );
    unset( $filters_arr['nonce'] );

    // If filters are set, we need to configure taxonomy params for the WP_Query
    if ( !empty( $filters_arr ) ) {
        $taxonomies = [];

        // $_POST['filters'] should be in the format of [ ['taxonomy_slug' => ['term_ids] ] ]
        foreach ($filters_arr as $key => $value) {
            if ($value != '') {
                $taxonomies[$key] = $value;
            }
        }

        // Set the relation type of each taxonomy query
        $tax_query = ['relation' => 'AND'];

        // Loop over each taxonomy
        // If an array of terms split into their own tax_query
        foreach ($taxonomies as $taxonomy => $terms) {
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field' => 'id',
                        'terms' => $term
                    );
                }
            } else {
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $terms
                );
            }
        }

        // add the tax query to the main query array
        $args['tax_query'] = $tax_query;
    }

    $posts = new WP_Query($args);

    ob_clean();

    if ($posts->have_posts()) {

        while ($posts->have_posts()) : $posts->the_post();
            $postType = get_post_type();
            if ($postType == 'post') {
                get_template_part('partials/archive-loop', 'content');
            } else {
                wc_get_template_part( 'content', 'product' );
            }

        endwhile;

    } else {

        echo '<p>' . __('No more posts found', 'lf') . '</p>';

    }

    wp_reset_query(); // Lets go back to the main_query() after returning our buffered content

    //get previous pages and multiply by products per page
    $paged -=1;
    $total_posts = ($post_per_page * $paged) + $posts->post_count;

    $html = ob_get_clean();

    $data = array(
        'html' => $html,
        'total_posts' => $total_posts,
        'found_posts' => $posts->found_posts,
        'posts_per_page' => $post_per_page
    );

    echo json_encode($data);

    die;
}

/**
 * Sort posts functionality
 */

add_action('wp_ajax_sort_posts', 'sort_posts'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts'); // wp_ajax_nopriv_{action}

function sort_posts()
{
    // new products query based on the selected filters
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'tax_query' => array(
            'relation' => 'AND',
        ),
        'post_status' => 'publish',
        'order' => 'DESC',
    );

    //sort by and order without reseting the filters
    if (isset($_POST['sort']) && $_POST['sort'] != '') {
        $args['orderby'] = $_POST['sort'];
        $args['order'] = $_POST['order'];
    }

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            get_template_part('partials/archive-loop', 'content');
        }
    } else {
        echo '<p class="text-center">No posts found</p>';
    }

    // reset the query

    wp_reset_postdata();
    die();
}

/**
 * Cart edit product function
 */

add_action('wp_ajax_edit-cart-product', 'edit_cart_product'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_edit-cart-product', 'edit_cart_product'); // wp_ajax_nopriv_{action}

function edit_cart_product() {
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'emc-nonce' ) ) {
        // This nonce is not valid.
        die( __( 'Security check', EXTRAMILE_THEME_SLUG ) ); 
    } else {
        // The nonce was valid.
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $product = wc_get_product($product_id);
        } else {
            die( __( 'No product ID', EXTRAMILE_THEME_SLUG ) ); 
        }

        if (isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        } else {
            $quantity = 1;
        }

        if ( $product->is_type( 'variable' ) ) { 
            //its a variable product, check the variation is set
            if (isset($_POST['variable'])) {
                $variation_id = $_POST['variable'];
                $variableProduct = true;
            } else {
                die( __( 'No variation', EXTRAMILE_THEME_SLUG ) ); 
            }
        }

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            if(intval($cart_item['product_id']) !== intval($product_id)) {
                continue;
            }

            if($variableProduct) {
                if(intval($cart_item['variation_id']) !== intval($variation_id)) {
                    //we cant amend a variable, so we need to remove old one and add a new one with correct variation
                    WC()->cart->remove_cart_item( $cart_item_key );

                    //add new product with correct variable
                    WC()->cart->add_to_cart( $product_id, $quantity, $variation_id );

                    $productUpdated = true;
                } else {
                    //we arent needing to change variable, check if we need to update quantity
                    if(intval($cart_item['quantity']) !== intval($quantity)) {
                        $updateQuantity = true;
                    }
                }
            }else {
                //not a variable product, do we need to update the quantity
                if($cart_item['quantity'] !== $quantity) {
                    $updateQuantity = true;
                }
            }

            if($updateQuantity) {
                WC()->cart->set_quantity($cart_item_key, $quantity);

                $productUpdated = true;
            }

            if($productUpdated) {
                //send a refresh request to the jQuery response
                wp_send_json_success('refresh');
            } else {
                //no refresh needed
                wp_send_json_success('no updates');
            }
        }

        //if we got here something went wrong

        wp_send_json_error( 'error' );
    }
}

function extramile_post_filter() {

    // Verify our nonce
    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'] ) ) {
       exit( 'We\'ve spotted a  security issue' ); 
    }   

    // new products query based on the selected filters
    $args = array(
        'post_type' => isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'post',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'post_status' => 'publish',
        'orderby' => isset( $_POST['orderby'] ) ? explode( '_', $_POST['orderby'])[0] : 'date',
        'order' => isset( $_POST['orderby'] ) ? explode( '_', $_POST['orderby'])[1] : 'DESC',
    );

    // Filter by post category
    if( isset( $_POST['cat'] ) && ! empty( $_POST['cat'] ) ) {
        $args['cat'] = $_POST['cat'];
    }

    // if (isset($_POST['filter']) && $_POST['filter'] != '') {
    //     $args['tax_query'] = array(
    //         'relation' => 'AND'
    //     );

    //     $args['tax_query'][] = array(
    //         'taxonomy' => 'category',
    //         'field' => 'slug',
    //         'terms' => $_POST['filter'],
    //     );
        
    // }
    // //sort by and order without reseting the filters
    // if (isset($_POST['sort']) && $_POST['sort'] != '') {
    //     $args['orderby'] = $_POST['sort'];
    //     $args['order'] = $_POST['order'];
    // }

    $posts = new WP_Query( $args );

    // $page = (int)$query->paged+1;

    ob_start();

    if( $posts->have_posts()) {
        
        while ($posts->have_posts()) {
            $posts->the_post();
            get_template_part('partials/card', 'news', array( 'post_id' => get_the_ID() ));
        }

    } else {
        
        echo '<p class="text-center">No posts found</p>';

    }

    $result = [
        'posts' => ob_get_clean(),
        'found_posts' => $posts->found_posts,
        'total_posts' => $posts->post_count
    ];

    echo json_encode($result);

    // reset the query
    wp_reset_postdata();

    die();
}
add_action('wp_ajax_post_filter', 'extramile_post_filter'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_post_filter', 'extramile_post_filter'); // wp_ajax_nopriv_{action


function extramile_loadmore_posts()
{
    $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : get_option( 'posts_per_page' );
    $orderby = isset($_POST['orderby']) ? explode( '_', $_POST['orderby'])[0] : 'date';
    $order = isset($_POST['orderby']) ? explode( '_', $_POST['orderby'])[1] : 'DESC' ;

    $args = array(
        'paged' => $paged + 1,
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'post_type' => 'post',
        'orderby' => $orderby,
        'order' => $order,
    );

    $posts = new WP_Query($args);

    ob_start();

    if ($posts->have_posts()) :

        while ($posts->have_posts()) : $posts->the_post();

            $postType = get_post_type();

            if ($postType == 'post') {
                get_template_part('partials/card', 'news', array( 'post_id' => get_the_ID() ));
            } else {
                wc_get_template_part( 'content', 'product' );
            }

        endwhile;

    else :

        echo '<p>' . __('No more posts found', 'lf') . '</p>';

    endif;

    wp_reset_query(); // Lets go back to the main_query() after returning our buffered content

    //get previous pages and multiply by products per page
    $paged = 1;
    $total_posts = ($posts_per_page * $paged) + $posts->post_count;

    $html = ob_get_clean();

    $data = array(
        'html' => $html,
        'total_posts' => $total_posts,
        'found_posts' => $posts->found_posts,
        'posts_per_page' => $posts_per_page
    );

    echo json_encode($data);

    die;
}
add_action('wp_ajax_loadmore_basic', 'extramile_loadmore_posts');
add_action('wp_ajax_nopriv_loadmore_basic', 'extramile_loadmore_posts');