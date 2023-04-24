<?php

// ========================================
// Block Name
//    > Banner
// ========================================

$blockName = 'banner';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

//get our variables
$headerType = get_field('header_type');

if($headerType == 'video') {
    $headerBackground = get_field('background_video');
} elseif($headerType == 'image') {
    $headerBackground = get_field('background_image');
} elseif($headerType == 'colour') {
    $headerBackground = get_field('background_colour');
    $bgColourClass = extramile_get_background_colour( get_field( 'background_colour' ) );
    $textColourClasses = extramile_get_block_text_colours( get_field( 'background_colour' ) );
    $buttonColourClass = extramile_get_button_colour( get_field( 'background_colour' ) );
}


//create our Banner CSS
if($headerType == 'image') {
    $headerStyle = 'background-image: url(' . $headerBackground['url'] . ');';
}
?>

<section id="<?= esc_attr($id); ?>" class="<?php echo esc_attr($blockClasses); if( $headerBackground == 'gradient') { echo ' gradient-overlay'; } ?> <?= isset( $bgColourClass ) ? $bgColourClass : '' ?>" <?php if ($headerBackground && $headerType == 'image') : ?> style="<?= $headerStyle; ?>" <?php endif; ?>>
    <?php
    if( isset( $blockHeader ) ) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    }
    
    //use an include statement so it can see all our variables
    include __DIR__ . '/../../../template-parts/content/content-banner.php';
    ?>
</section>