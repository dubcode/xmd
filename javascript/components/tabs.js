export function tabs() {
    // Hide all tabbed content accept first item
    jQuery('#tabs-nav li:first-child').addClass('active');
    jQuery('.tabs-content-container').children().not(':first').css('display', 'none');


    jQuery('#tabs-nav li').click(function (e){
        var $clickedIndex = jQuery(this).index();
        var tabContentContainer = jQuery(this).parent().siblings('.tabs-content-container');

        // Change the active tab button
        jQuery('#tabs-nav li').removeClass('active');
        jQuery(this).addClass('active');
        // Change the active tab content to match the index of the clicked item
        tabContentContainer.children().css('display', 'none');
        tabContentContainer.children(`:nth-child(${$clickedIndex+1})`).fadeIn();
    });
}