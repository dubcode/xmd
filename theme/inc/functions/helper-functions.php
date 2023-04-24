<?php
/**
 * Easily log string | array to the wp log file
 *
 */
if (!function_exists('write_log')) {

    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}


//check to see if certain plugins are activated, needed for the theme
if( ! function_exists('is_acf_activated') ) {
    function is_acf_activated() {
        if ( class_exists( 'ACF' ) ) { 
            return true; 
        } else { 
            return false; 
        }
    }
}

if( ! function_exists('is_woocommerce_activated') ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { 
            return true; 
        } else { 
            return false; 
        }
    }
}

//add our block functions
if ( ! function_exists( 'get_first_block_id' ) ) {
	function get_first_block_id() {
		$post = get_post(); 

        if(has_blocks($post->post_content)) {
            $blocks = parse_blocks($post->post_content);
            $first_block_attrs = $blocks[0]['attrs'];

            if(array_key_exists('id', $first_block_attrs)) {
                return $first_block_attrs['id'];
            }
        }
	}
}

//create our Blockm ID
if( ! function_exists('get_block_id') ) {
    function get_block_id($blockName, $block) {
        $id = $blockName . '-' . $block['id'];
        
        if (!empty($block['anchor'])) {
            $id = $block['anchor'];
        }

        return $id;
    }
}

//create our block classes
if( ! function_exists('get_block_classes') ) {
    function get_block_classes($classes, $block) {
        if (!empty($block['className'])) {
            $classes .= ' ' . $block['className'];
        }

        if (!empty($block['align'])) {
            $classes .= ' align' . $block['align'];
        }

        return $classes;
    }
}

/**
 * Debug Admin Menu Items, provides slug etc, good for using parent page to have sub menu items
 */
//add_action( 'admin_init', 'emc_debug_admin_menu' );

if ( ! function_exists( 'emc_debug_admin_menu' ) ) {
    function emc_debug_admin_menu() {

        echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
    }
}

//add our function used for the mobile menu
if ( ! function_exists( 'has_sub_menu' ) ) {
    function has_sub_menu($id)
    {
        $menu_name = 'mobile';
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

        //Go through and see if this is a parent
        foreach ($menuitems as $menu_item) {
            if ((int)$menu_item->menu_item_parent === (int)$id) {
                return true;
            }
        }
        return false;
    }
}

//add our menus to the footer menu dropdown
if(!function_exists('footer_menu_options')) {
    function footer_menu_options($field) {
        // reset choices
        $field['choices'] = [];

        $menus = wp_get_nav_menus();

        foreach($menus as $menu) {
            $field['choices'][ $menu->slug ] = $menu->name;
        }

        // return the field
        return $field;
    }
}

add_filter('acf/load_field/name=column_2_menu', 'footer_menu_options');
add_filter('acf/load_field/name=column_3_menu', 'footer_menu_options');
add_filter('acf/load_field/name=column_4_menu', 'footer_menu_options');

//tell ninja forms to use our custom template
add_filter( 'ninja_forms_field_template_file_paths', 'custom_field_file_path' );
if(!function_exists('custom_field_file_path')) {
    function custom_field_file_path( $paths ){

        $paths[] =  get_stylesheet_directory() . '/ninja-forms/templates/';
        
        return $paths;
    }
}

//deactivate all gutenberg blocks apart from registered ACf blocks
if(!function_exists('deactivate_gutenberg_blocks')) {
    function deactivate_gutenberg_blocks() {
        $acfBlocks = acf_get_block_types($allowed_blocks, $editor_context);

        foreach($acfBlocks as $acfBlock) {
            $registeredBlocks[] = $acfBlock['name'];
        }

        return $registeredBlocks;
    }
}

//add_filter( 'allowed_block_types_all', 'deactivate_gutenberg_blocks', 25, 2 );

if(!function_exists('acf_map_helper_code')) {
    function acf_map_helper_code() {
        ob_start();
        ?>
        <style type="text/css">
            .acf-map {
                width: 100%;
                height: 400px;
                border: #ccc solid 1px;
                margin: 20px 0;
            }

            // Fixes potential theme css conflict.
            .acf-map img {
                max-width: inherit !important;
            }
        </style>

        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
        <script type="text/javascript">
            (function( $ ) {

            /**
             * initMap
             *
             * Renders a Google Map onto the selected jQuery element
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   jQuery $el The jQuery element.
             * @return  object The map instance.
             */
            function initMap( $el ) {

                // Find marker elements within map.
                var $markers = $el.find('.marker');

                // Create gerenic map.
                var mapArgs = {
                    zoom        : $el.data('zoom') || 16,
                    mapTypeId   : google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map( $el[0], mapArgs );

                // Add markers.
                map.markers = [];
                $markers.each(function(){
                    initMarker( $(this), map );
                });

                // Center map based on markers.
                centerMap( map );

                // Return map instance.
                return map;
            }

            /**
             * initMarker
             *
             * Creates a marker for the given jQuery element and map.
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   jQuery $el The jQuery element.
             * @param   object The map instance.
             * @return  object The marker instance.
             */
            function initMarker( $marker, map ) {

                // Get position from marker.
                var lat = $marker.data('lat');
                var lng = $marker.data('lng');
                var latLng = {
                    lat: parseFloat( lat ),
                    lng: parseFloat( lng )
                };

                // Create marker instance.
                var marker = new google.maps.Marker({
                    position : latLng,
                    map: map
                });

                // Append to reference for later use.
                map.markers.push( marker );

                // If marker contains HTML, add it to an infoWindow.
                if( $marker.html() ){

                    // Create info window.
                    var infowindow = new google.maps.InfoWindow({
                        content: $marker.html()
                    });

                    // Show info window when marker is clicked.
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open( map, marker );
                    });
                }
            }

            /**
             * centerMap
             *
             * Centers the map showing all markers in view.
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   object The map instance.
             * @return  void
             */
            function centerMap( map ) {

                // Create map boundaries from all map markers.
                var bounds = new google.maps.LatLngBounds();
                map.markers.forEach(function( marker ){
                    bounds.extend({
                        lat: marker.position.lat(),
                        lng: marker.position.lng()
                    });
                });

                // Case: Single marker.
                if( map.markers.length == 1 ){
                    map.setCenter( bounds.getCenter() );

                // Case: Multiple markers.
                } else{
                    map.fitBounds( bounds );
                }
            }

            // Render maps on page load.
            $(document).ready(function(){
                $('.acf-map').each(function(){
                    var map = initMap( $(this) );
                });
            });

            })(jQuery);
        </script>
        <?php
        return ob_get_clean();
    }
}

//make 404 private
add_action('init', 'set_404_page_private');

if(!function_exists('set_404_page_private')) {
    function set_404_page_private() {
        $notFoundPage = get_field('404_page', 'option');

        if($notFoundPage) {
                $post = [ 'ID' => $notFoundPage, 'post_status' => 'private' ];
            wp_update_post($post);
        }
    }
}

// Now let everyone know this is our 404 page
add_filter('display_post_states', 'emc_404_state');

if(!function_exists('emc_404_state')) {
    function emc_404_state($states) {

        if( is_admin() ) return;

        global $post;
        $notFoundPage = get_field('404_page', 'option');

        if( ('page'==get_post_type($post->ID)) && ($post->ID == $notFoundPage ) ) {
            $states[] = __('404 Page');
        }

        return $states;
    }
}

if( !function_exists( 'extramile_get_background_colour' ) ) {
    /**
     * Get the tailwind compatible background colour class
     *
     * @param string $colour
     * @return string
     */
    function extramile_get_background_colour( $colour ) {
        
        if( !$colour ) return 'bg-transparent';

        switch( $colour ) {
            case 'primary':
                return 'bg-primary';
                break;
            case 'secondary':
                return 'bg-secondary';
                break;
            case 'grey':
                return 'bg-grey-100';
                break;
            case 'grey-dark':
                return 'bg-grey-700';
                break;
            case 'gradient':
                return 'gradient-overlay';
                break;
            default:
                return 'bg-transparent';
                break;
        }
    }
}

if( !function_exists( 'extramile_get_block_text_colours' ) ) {
    /**
     * Get the tailwind text colour classes for the block text
     *
     * @param string $colour
     * @return array
     */
    function extramile_get_block_text_colours( $bg_colour ) {

        if( !$bg_colour ) {
            return array(
                'headings' => 'text-primary',
                'body' => 'text-grey'
            );
        }

        switch( $bg_colour ) {
            case 'primary':
            case 'gradient':
            case 'grey-dark':
                return array(
                    'headings' => 'text-white',
                    'body' => 'text-grey-400'
                );
                break;
            case 'grey':
            case 'secondary':
            default:
                return array(
                    'headings' => 'text-primary',
                    'body' => 'text-grey'
                );
                break;
        }
    }
}

if( !function_exists( 'extramile_get_block_spacing_classes' ) ) {
    /**
     * Get the tailwind padding classes to space the block
     *
     * @param string $spacing
     * @return string
     */
    function extramile_get_block_spacing_classes( $spacing ) {

        if( !$spacing ) {
            return '';
        }

        switch( $spacing ) {
            case 'top':
                return 'pt-12 lg:pt-24';
                break;
            case 'bottom':
                return 'pb-12 lg:pb-24';
                break;
            case 'none':
                return 'py-0';
                break;
            case 'top-bottom':
                return 'py-12 lg:py-24';
            default:
                return 'py-0';
                break;
        }
    }
}

if( !function_exists( 'extramile_get_heading_size_class' ) ) {
    /**
     * Get the tailwind heading component class
     *
     * @param string $size
     * @return string
     */
    function extramile_get_heading_size_class( $size ) {

        if( !$size ) {
            return '';
        }

        switch( $size ) {
            case '2':
                return 'heading-2';
                break;
            case '3':
                return 'heading-3';
                break;
            case '4':
                return 'heading-4';
                break;
            case '5':
                return 'heading-5';
                break;
            default:
                return '';
                break;
        }
    }
}

if( !function_exists( 'extramile_get_button_colour' ) ) {
    /**
     * Get the tailwind button colour class from the selected background colour
     *
     * @param string $colour
     * @return string
     */
    function extramile_get_button_colour( $colour ) {

        if( !$colour ) {
            return 'button-col-primary';
        }

        switch( $colour ) {
            case 'transparent':
            case 'secondary':
            case 'grey':
                return 'button-col-primary';
                break;
            case 'primary':
            case 'gradient':
                return 'button-col-secondary';
                break;
            default:
                return 'button-col-primary';
                break;
        }
    }
}

if( !function_exists( 'extramile_get_post_thumbnail') ) {
    /**
     * Return post thumbnail or the placeholder set in theme options
     *
     * @param int $post_id
     * @param string $size
     * @return void
     */
    function extramile_get_post_thumbnail( $post_id, $size = 'medium' ) {
        
        if( has_post_thumbnail( $post_id ) ) {
            return get_the_post_thumbnail_url($post_id, $size);
        }

        // Return the placeholder
        if( $placeholder = get_field( 'image_placeholder', 'option' ) ) {
            return $placeholder['sizes'][$size];
        }

        return null;
    }
}


if( !function_exists( 'extramile_get_related_posts' ) ) {
    function extramile_get_related_posts( $post_id ) {
        $terms = get_the_terms( $post_id, 'category' );

        if( empty( $terms ) ) {
            $terms = array();
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'post__not_in' => array( $post_id ),
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => wp_list_pluck( $terms, 'slug' )
                )
            )
        );

        return new WP_Query( $args );

    }
}


function extramile_get_product_category_filters( $category ) {

    if( ! $category ) return;

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query'=> array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $category->term_id
            )
        ),
    ];
    
    $products = new WP_Query( $args );
    $all_term_attributes = [];

    if( $products->have_posts() ) {
        while( $products->have_posts() ) {
            $products->the_post();
            $product = wc_get_product( get_the_ID() );
            $prod_attributes = $product->get_attributes();

            foreach( $prod_attributes as $attr_key => $attr_obj ) {
                if( isset( $all_term_attributes[$attr_key] ) ) {
                    $all_term_attributes[$attr_key]['options'] = array_merge( $all_term_attributes[$attr_key]['options'], $attr_obj->get_options() );
                } else {
                    $all_term_attributes[$attr_key]['options'] = $attr_obj->get_options();
                }   
            }
        }

        if( !empty( $all_term_attributes ) ) {
            return extramile_get_unique_attribute_terms( $all_term_attributes );
        }
    }

    return;

    wp_reset_postdata();

}


function extramile_get_unique_attribute_terms( $all_term_attributes ) {

    if( ! $all_term_attributes ) return;

    if( !is_array( $all_term_attributes ) ) return $all_term_attributes;

    $all_term_attributes_cleaned = [];
        
    foreach( $all_term_attributes as $attr_key => $options ) {
        $all_term_attributes_cleaned[$attr_key]['options'] = array_unique( $options['options'] );
    }

    return $all_term_attributes_cleaned;
}