/**
 * The JavaScript code you place here will be processed by esbuild, and the
 * output file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

 import 'tw-elements';
 import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';
 import {tabs} from './components/tabs';

 //import our nav JS
 require('./nav.js');
 
 jQuery(document).ready(function ($) {

    // Run imported components to initialise them
    tabs();


    if($('body').hasClass('woocommerce-checkout')) {
        const autocompleteBillingInput = new GeocoderAutocomplete(
            document.getElementById("billing_address_lookup"), 
            '045354817cad4f64837a4965ad5abe19', 
            { /* Geocoder options */ }
        );
        
        const autocompleteShippingInput = new GeocoderAutocomplete(
            document.getElementById("shipping_address_lookup"), 
            '045354817cad4f64837a4965ad5abe19', 
            { /* Geocoder options */ }
        );

        $('#billing_country_field').hide();
        $('#billing_address_1_field').hide();
        $('#billing_address_2_field').hide();
        $('#billing_city_field').hide();
        $('#billing_state_field').hide();
        $('#billing_postcode_field').hide();

        $('#shipping_country_field').hide();
        $('#shipping_address_1_field').hide();
        $('#shipping_address_2_field').hide();
        $('#shipping_city_field').hide();
        $('#shipping_state_field').hide();
        $('#shipping_postcode_field').hide();
    
        autocompleteBillingInput.on('select', (location) => {
            if (location) {
                let details = location.properties;
                let street = details.street;
                let city = details.city;
                let country = details.country;
                let postcode = details.postcode;
                let state = details.state;
                
                //now update our address fields
                $('#billing_address_1').val(street);
                $('#billing_city').val(city);
                $('#billing_state').val(state);
        
                //set our select by text value
                $("#billing_country option").filter(function() {
                    //may want to use $.trim in here
                    return $(this).text().toLowerCase() == country.toLowerCase();
                }).prop('selected', true);
        
                $('#billing_postcode').val(postcode);

                //show our fields
                $('#billing_country_field').show();
                $('#billing_address_1_field').show();
                $('#billing_address_2_field').show();
                $('#billing_city_field').show();
                $('#billing_state_field').show();
                $('#billing_postcode_field').show();

                //hide the manual entry link
                $('.manual-billing-address-entry').hide();
            }
        });

        autocompleteShippingInput.on('select', (location) => {
            if (location) {
                let details = location.properties;
                let street = details.street;
                let city = details.city;
                let country = details.country;
                let postcode = details.postcode;
                let state = details.state;
                
                //now update our address fields
                $('#shipping_address_1').val(street);
                $('#shipping_city').val(city);
                $('#shipping_state').val(state);
        
                //set our select by text value
                $("#shipping_country option").filter(function() {
                    //may want to use $.trim in here
                    return $(this).text().toLowerCase() == country.toLowerCase();
                }).prop('selected', true);
        
                $('#shipping_postcode').val(postcode);

                //show our fields
                $('#shipping_country_field').show();
                $('#shipping_address_1_field').show();
                $('#shipping_address_2_field').show();
                $('#shipping_city_field').show();
                $('#shipping_state_field').show();
                $('#shipping_postcode_field').show();

                //hide the manual entry link
                $('.manual-shipping-address-entry').hide();
            }
        });

        $('.manual-billing-address-entry').on('click', function (event) {
            event.preventDefault();

            //show our fields
            $('#billing_country_field').show();
            $('#billing_address_1_field').show();
            $('#billing_address_2_field').show();
            $('#billing_city_field').show();
            $('#billing_state_field').show();
            $('#billing_postcode_field').show();

            //hide the address lookup field
            $('#billing_address_lookup').hide();

            $(this).hide();
            $('.manual-billing-address-cancel').show();
        });

        $('.manual-billing-address-cancel').on('click', function (event) {
            event.preventDefault();

            //hide our fields
            $('#billing_country_field').hide();
            $('#billing_address_1_field').hide();
            $('#billing_address_2_field').hide();
            $('#billing_city_field').hide();
            $('#billing_state_field').hide();
            $('#billing_postcode_field').hide();

            //hide the address lookup field
            $('#billing_address_lookup').show();

            $(this).hide();
            $('.manual-billing-address-entry').show();
        });

        $('.manual-shipping-address-entry').on('click', function (event) {
            event.preventDefault();

            //show our fields
            $('#shipping_country_field').show();
            $('#shipping_address_1_field').show();
            $('#shipping_address_2_field').show();
            $('#shipping_city_field').show();
            $('#shipping_state_field').show();
            $('#shipping_postcode_field').show();

            //hide the address lookup field
            $('#shipping_address_lookup').hide();

            $(this).hide();
            $('.manual-shipping-address-cancel').show();
        });

        $('.manual-shipping-address-cancel').on('click', function (event) {
            event.preventDefault();

            //hide our fields
            $('#shipping_country_field').hide();
            $('#shipping_address_1_field').hide();
            $('#shipping_address_2_field').hide();
            $('#shipping_city_field').hide();
            $('#shipping_state_field').hide();
            $('#shipping_postcode_field').hide();

            //hide the address lookup field
            $('#shipping_address_lookup').show();

            $(this).hide();
            $('.manual-shipping-address-entry').show();
        });

        //hide shipping fields if the checkbox is ticked
        if($('#emc-ship-to-different-address-checkbox').is(":checked")) {
            $('.checkout-shipping-section').hide();
        } else {
            //show shipping details
            $('.checkout-shipping-section').show();
        }

        $('#emc-ship-to-different-address-checkbox').on('change', function () {
            if(this.checked) {
                $('.checkout-shipping-section').hide();
            } else {
                $('.checkout-shipping-section').show();
            }
        });
    }

     // auto Play iframe video on page load
     $('.embed-container iframe').each(function () {
         $(this).attr('src', $(this).attr('src') + '?autoplay=1&muted=1');
     });
 
     $(document).ajaxComplete(function () {
         $(this).find('.subscribe__form i').hide();
     });

     $('.video-play-icon, .video-play-text').on('click', function () {
        if($(this).parent().hasClass('internal-video')) {
            $('video').trigger('play');
        } else {
            const modal = $(this).parents('.one-col-video-container').siblings('.emc-modal');

            const iframe = modal.find('.emc-modal-body').children('iframe');
            
            // play the *iframe video
            iframe.attr('src', $(iframe).attr('src') + '?autoplay=1&muted=1');
        }
     });

     $('.emc-product-edit').on('click', function (event) {
        event.preventDefault();

        $(this).addClass('hidden');
        $(this).siblings('.emc-product-update').removeClass('hidden');

        //unhide our product update options
        let productActions = $(this).parents('.cart-product-item').find('.cart-product-item-actions');
        productActions.removeClass('hidden');
     });

     $('.emc-product-update').on('click', function (event) {
        event.preventDefault();

        $(this).addClass('hidden');
        $(this).siblings('.emc-product-edit').removeClass('hidden');

        //get our div and store it
        let productActions = $(this).parents('.cart-product-item').find('.cart-product-item-actions');

        const quantity = productActions.find('.quantity').find('select').val();
        let productVariable = '';
        
        if($('#product-variations').length){
            productVariable = productActions.find('#product-variations').val();
        }

        var data = {
            action: 'edit-cart-product',
            nonce: emc_loadmore.nonce,
            product_id: $(this).attr('data-product_id'),
            quantity,
            variable : productVariable,
            dataType: 'JSON'     
        };

        $.ajax({
            url: emc_loadmore.ajaxurl,
            data: data,
            type: 'POST',
            success: function (response) {
                //hide our product update options
                productActions.addClass('hidden');

                if(response.success) {
                    if(response.data == 'refresh') {
                        //we have updates, refresh page
                        location.reload();
                    }
                }
            },
            error: function (response)
            { 
                console.log(response); 
            }
        });
    });
 
     $('.product-slider .products').slick({
         dots: true,
         infinite: true,
         slidesToShow: 4,
         slidesToScroll: 4,
         speed: 500,
         autoplay: true,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
         responsive: [
             {
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 3,
                     infinite: true,
                     dots: true
                 }
             },
             {
                 breakpoint: 600,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             }
         ]
     });
 
     $('.news-slider').slick({
         dots: true,
         infinite: true,
         slidesToShow: 3,
         slidesToScroll: 3,
         speed: 500,
         autoplay: true,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
         responsive: [
             {
                 breakpoint: 900,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 600,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             }
         ]
     });
 
     $('.slider').slick({
         dots: true,
         infinite: true,
         slidesToShow: 1,
         speed: 500,
         autoplay: true,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
     });

     $('.testimonials-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        speed: 500,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false,
        rows: 1,
    });
 
     $('.twocol_slider').slick({
         dots: true,
         infinite: true,
         slidesToShow: 1,
         speed: 500,
         autoplay: true,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
     });
 
     $('.testimonial_slider').slick({
         dots: true,
         infinite: true,
         slidesToShow: 1,
         speed: 500,
         autoplay: false,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
         fade: true,
     });

     $('.two-col-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        speed: 500,
        autoplay: false,
        autoplaySpeed: 5000,
        arrows: false,
        rows: 1,
        fade: true,
    });
 
     $('.product_slider').slick({
         dots: true,
         infinite: false,
         slidesToShow: 4,
         slidesToScroll: 4,
         speed: 500,
         autoplay: false,
         autoplaySpeed: 5000,
         arrows: false,
         rows: 1,
         responsive: [
             {
                 breakpoint: 1280,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 3,
                     infinite: true,
                     dots: true
                 }
             },
             {
                 breakpoint: 840,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2
                 }
             },
             {
                 breakpoint: 650,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             }
         ]
     });
 
     // add active to the current page
     var url = window.location.href;
 
     $('.hoverable a').each(function () {
         if (this.href == url) {
             $(this).addClass('active');
         }
     });
 
     // if mega-menu page is active add active to the parent
    //  TODO: move this to PHP
     $('.mega-menu a').each(function () {
         if (this.href == url) {
             $(this).addClass('active');
             $(this).closest('.hoverable').addClass('active');
         }
     });
 
     $('#tabs-nav li:first-child').addClass('active');
     $('.tab-content').css('display', 'none');
     $('.tab-content:first').css('display', 'block');
 
     // Click function
     $('#tabs-nav li').click(function () {
         $('#tabs-nav li').removeClass('active');
         $(this).addClass('active');
         $('.tab-content').css('display', 'none');
         // hide siblings
         $('.tab-content').siblings('.inner-block').css('display', 'none');
 
         var activeTab = $(this).find('a').attr('href');
         $(activeTab).fadeIn();
         return false;
     });
 
     // Ajax to filter products
     $('.woocommerce-widget-layered-nav-dropdown').on('change', function () {
 
         var form = $(this).closest('form');
 
         var data = {
             action: 'filter',
             filter: form.serializeArray(),
             category: form.attr('data-product-Category'),
             dataType: 'JSON'        
         };
 
         $.ajax({
             url: emc_loadmore.ajaxurl,
             data: data,
             type: 'POST',
             success: function (response) {
                 const data = JSON.parse(response);
 
                 $('.products').html(data.products);
 
                 var found_posts = parseInt(data.found_posts);
                 var total_posts = parseInt(data.total_posts);
  
                 if ($('.clear-all-container').find('.clear-filter').length == 0) {
                     $('.clear-all-container').append('<button class="clear-filter text-base filter-button border border-grey-300 rounded px-5 py-3 mr-2 hover:bg-grey-700 hover:text-grey-400"><i class="fas fa-times w-3 h-3 mr-2.5"></i> Clear All</button>');
                 }
 
                 if(found_posts == 0) {
                     $('.woocommerce-pagination').hide();
                 } else {
                     $('.woocommerce-pagination').show();
 
                     if(found_posts < 12) {
                         //we dont need the pagination button
                         $('.woocommerce-pagination').find('button').hide();
                     }
 
                     $('.lm-post-count').html(total_posts);
                     $('.lm-found-posts').html(found_posts);
                 }
 
                 //update our counter
                 $('.post-count').find('span').html(found_posts);
             },
             error: function (response) { console.log(response); }
         });
 
     });
 
     $('.filter-form').on('submit', function (e) {
         e.preventDefault();
         var form = $(this);
 
         var data = {
             action: 'filter',
             filter: form.serializeArray(),
             category: form.attr('data-product-Category'),
             dataType: 'json'
         };
 
         $.ajax({
             url: emc_loadmore.ajaxurl,
             data: data,
             type: 'POST',
             success: function (response) {
                 const data = JSON.parse(response);
 
                 $('.products').html(data.products);
 
                 var found_posts = parseInt(data.found_posts);
                 var total_posts = parseInt(data.total_posts);
  
                 if ($('.clear-all-container').find('.clear-filter').length == 0) {
                     $('.clear-all-container').append('<button class="clear-filter text-base filter-button border border-grey-300 rounded px-5 py-3 mr-2 hover:bg-grey-700 hover:text-grey-400"><i class="fas fa-times w-3 h-3 mr-2.5"></i> Clear All</button>');
                 }
 
                 if(found_posts == 0) {
                     $('.woocommerce-pagination').hide();
                 } else {
                     $('.woocommerce-pagination').show();
 
                     if(found_posts < 12) {
                         //we dont need the pagination button
                         $('.woocommerce-pagination').find('button').hide();
                     }
 
                     $('.lm-post-count').html(total_posts);
                     $('.lm-found-posts').html(found_posts);
                 }
 
                 //update our counter
                 $('.post-count').find('span').html(found_posts);
             },
             error: function (response) { console.log(response); }
         });
 
     });
 
     // Ajax to filter posts by clickiing the button class filter-button 
     $('.filter-button').on('click', function (e) {
         e.preventDefault();
         var form = $(this).closest('form');
         // Add active class to the button was clicked , remove from others
         $('.filter-button').removeClass('active');
         $(this).addClass('active');
         //get the valuve from the attribute data-filter
         var filter = $(this).attr('data-filter');
         var data = {
             action: 'filter_posts',
             filter: filter,
             dataType: 'JSON',        
         };
 
         $.ajax({
             url: emc_loadmore.ajaxurl,
             data: data,
             type: 'POST',
             success: function (response) {
                 const data = JSON.parse(response);
 
                 $('.emc-archive').html(data.posts);
 
                 var found_posts = data.found_posts;
                 var total_posts = data.total_posts;
 
                 if ($('.clear-all-container').find('.clear-filter').length == 0) {
                     $('.clear-all-container').append('<button class="clear-filter text-base filter-button border border-grey-300 rounded px-5 py-3 mr-2 hover:bg-grey-700 hover:text-grey-400"><i class="fas fa-times w-3 h-3 mr-2.5"></i> Clear All</button>');
                 }
 
                 if(found_posts == 0) {
                     $('.woocommerce-pagination').hide();
                 } else {
                     if(found_posts < 6) {
                         //we dont need the pagination button
                         $('.woocommerce-pagination').find('button').hide();
                     }
 
                     $('.published-posts').html(total_posts);
                     $('.found-posts').html(found_posts);
                 }
 
                 //update our counter
                 $('.post-count').find('span').html(found_posts);
             },
             error: function (response) { console.log(response); }
         });
 
 
 
         //after ajax has run add a class to loadmore button
         $('.loadmore').addClass('ajax-loaded');
 
     });
 
     // Ajax for sort-form 
     $('.sort-by').on('change', function (e) {
         e.preventDefault();
         var sort = $(this).val();
         var order = $(this).find(':selected').attr('data-order');
         var data = {
             action: 'sort_posts',
             sort: sort,
             order: order,
             dataType: 'json'
         };
 
         console.log(data);
 
         $.ajax({
             url: emc_loadmore.ajaxurl,
             data: data,
             type: 'POST',
             success: function (response) {
                 $('.emc-archive').html(response);
             },
             error: function (response) { console.log(response); }
         });
 
     });
 
     // clear the forms by clicking the clear button
     $(document).on('click', '.clear-filter', function (e) {
         e.preventDefault();
         //remove the clear button
         setTimeout(function () {
             $('.clear-filter').remove();
         }, 1000);
 
         //reset all our inputs
         $(".filter-form").each(function(){
             $(this).find(':input').val('');
         });
 
         //trigger form submit
         $(".filter-form").submit();
     }
     );
 


    /**
     * Menu specific JS
     */

     // Toggle class for each emc-parent-item clicked
     $('.emc-parent-item i').on('click', function () {
         $(this).toggleClass('active');
         //find next emc-child-item and slide toggle it
         $(this).next('.emc-child-item').slideToggle();
     }
     );
 
     // when menu item has hover state add class to the #masthead and remove it when hover is over
     $('.has-children').hover(function () {
         $('#top-nav').addClass('hovered');
     }, function () {
         $('#top-nav').removeClass('hovered');
     });

    $('.basket-icon').on('mouseover', function () {
        $('.floating-basket-container').removeClass('hidden');
    });

    $('.floating-basket-icon-close').on('click', function () {
        $('.floating-basket-container').addClass('hidden');
    });
 
     $('.emc-mobile-filter').on('click', function () {
         $(this).toggleClass('active');
         $('.filter-form').slideToggle();
     });

     $('.search-toggle-container').on('click', function () {
        if($( document ).width() > 640) {
            //only run this after the Sm breakpoint
            let leftContainerWidth = $(this).parents('.container').css("margin-left");
            $(this).siblings('.mobile-search-container').css( { "margin-left" : "-" + leftContainerWidth,});

            let rightContainerWidth = $(this).parents('.container').css("margin-right");
            $(this).siblings('.mobile-search-container').css( { "margin-right" : "-" + rightContainerWidth,});
        }

        $('.mobile-search-container').toggleClass('hidden');
        $('.search-icon').toggleClass('hidden');
        $('.search-icon-open').toggleClass('hidden');

        if($('.mobile-search-container').hasClass('hidden')) {
            $('.search-text').html('Search');
        } else {
            $('.search-text').html('Close');
        }
    });

    // Archive filter options using checkboxes for form fields
    $('.filter-post-category').on( 'change', postFilterSubmitHandler );
    $('.filter-post-orderby').on( 'change', postFilterSubmitHandler );

    /**
     * Filter the posts using the form data
     * 
     */
    function postFilterSubmitHandler( e ) {

        const $form = $(this).closest('form');
        const data = $form.serialize();

        if( e.currentTarget.classList.contains('filter-post-orderby') ) {
            window.emc_loadmore.orderby = e.currentTarget.value;
        }

        window.emc_loadmore.current_page = 1;

        $.ajax({
            url: emc_loadmore.ajaxurl,
            data: data,
            type: $form.attr('method').toUpperCase(),
            dataType: 'JSON',
            success: function (response) {

                // console.log(response.posts);
                $('.post-list-grid').empty().append( response.posts );

                // Update the counters
                $('.post-counter').empty().append( response.found_posts )
                $('.post-counter-displayed').empty().append( response.total_posts );

                if( response.total_posts < response.found_posts ) {
                    // Show the load more button
                    $('button.load-more').removeClass('hidden');
                } else {
                    // Hide the load more button
                    $('button.load-more').addClass('hidden');
                }

            },
            error: function (response) { console.log(response); }
        });
    }

    if( window.emc_loadmore !== undefined ) {
        const loadMoreBtn = document.querySelector('button.load-more');

        window.emc_loadmore.current_page = 1;
        window.emc_loadmore.max_num_pages = loadMoreBtn.dataset.maxNumPages; 

        loadMoreBtn.addEventListener( 'click', function(e) {
            let data = {
                action: loadMoreBtn.dataset.action,
                paged: window.emc_loadmore.current_page,
            }

            if( window.emc_loadmore.orderby ) {
                data.orderby = window.emc_loadmore.orderby
            }

            $.ajax({
                url: emc_loadmore.ajaxurl,
                data: data,
                method: 'POST',
                // beforeSend: function( xhr ) {
                //     // let the user know the site is at work
                //     loadMoreBtn.innerHTML = loadMoreBtn.dataset.textLoading
                // },
                success: function( response ) {
                    const data = JSON.parse(response);

                    console.log(data);

                    // reset the button text
                    loadMoreBtn.innerHTML = loadMoreBtn.dataset.textDefault
                    
                    // we've moved on a page
                    window.emc_loadmore.current_page++;
                    window.emc_loadmore.found_posts = data.found_posts;

                    // update post count
                    // self.updatePostCountInfo();

                    // remove Show More button if max pages achieved
                    if( window.emc_loadmore.max_num_pages == window.emc_loadmore.current_page ) {
                        loadMoreBtn.classList.add('hidden');
                    }

                    $('.post-counter-displayed').empty().append(data.total_posts);

                    // append returned HTML data to resources lists
                    $('.post-list-grid').append( data.html );
                }                
            })
        })
    }

 });
 
 //product filter arrows
 jQuery('.child-filter-toggle').on('click', function () {
     jQuery(this).siblings('.emc-child-item').toggleClass('hidden');
     jQuery(this).children('.filter-child-close').toggleClass('hidden');
     jQuery(this).children('.filter-child-open').toggleClass('hidden');
 });