<?php

// ========================================
// Block Name
//    > Slider
// ========================================

$blockName = 'slider';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$blockHeader = get_field('enable_block_header');

$sliderType = get_field('slider_type');
$sliderSource = get_field('slider_source');

$bgColour = get_field('enable_background_colour');
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $bgColour ? 'bg-grey-100' : '' ?>">
    <?php
    if($blockHeader) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    }

    if( $sliderSource == 'product' ) {
        get_template_part( 'template-parts/blocks/product', 'slider' );
    } else {
        get_template_part( 'template-parts/blocks/news', 'slider' );
    }
    ?>
</section>