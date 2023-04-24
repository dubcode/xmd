<?php

// ========================================
// Block Name
//    > One col
// ========================================

$blockName = 'one-col';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$blockHeader = get_field('enable_block_header');
$fullWidth = get_field('enable_full_screen');
$columnType = get_field('column_type');

$bgImage = get_field( 'bg_image' );
$bgColour = get_field('enable_background-colour');
$selectedBgColour = get_field('bg_colour');
$bgColourClass = extramile_get_background_colour( $selectedBgColour );
$buttonColourClass = extramile_get_button_colour( $selectedBgColour );
$textColourClasses = extramile_get_block_text_colours( $selectedBgColour );
$blockSpacingClass = extramile_get_block_spacing_classes( get_field( 'block_spacing' ) );
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $bgColourClass ?> <?= $blockSpacingClass ?><?= $bgImage ? ' bg-image-active' : '' ?>" style="<?= !empty( $bgImage && $columnType == 'testimonial' ) ? 'background-image: url(' . $bgImage['sizes']['large'] . ')' : '' ?>">
    <?php
    if( $blockHeader ) {
        get_template_part( 'template-parts/blocks/block', 'header', array( 'bg_colour' => $bgColour ) );
    }
    ?>

    <div class="one-col-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <?php
        if($columnType == 'testimonial') {
            //include our testimonial slider
            get_template_part( 
                'template-parts/blocks/testimonial', 
                'slider', 
                array( 'bg' => $bgColourClass, 'button' => $buttonColourClass, 'text' => $textColourClasses ) 
            );
        }

        if($columnType == 'video') {
            //include our video
            include __DIR__ . '/../../../template-parts/blocks/onecol-video.php';
        }

        if($columnType == 'accordion') {
            //include our accordion
            get_template_part( 'template-parts/blocks/onecol', 'accordion' );
        }

        if($columnType == 'form') {
            $form = get_field('form');
            echo do_shortcode( $form );
        }

        if($columnType == 'table') {
            //include our table
            get_template_part( 'template-parts/blocks/onecol', 'table' );
        }
    ?>

    </div>
</section>