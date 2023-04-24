<?php

// ========================================
// Block Name
//    > Grid - Flexible
// ========================================

$blockName = 'grid-flexible';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$fullWidth = get_field('enable_full_screen');
$blockHeader = get_field('enable_block_header');
$blockSpacingClass = extramile_get_block_spacing_classes( get_field( 'block_spacing' ) );
$gridType = get_field('grid_type');
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $blockSpacingClass ?>">
    <?php
    if($blockHeader) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    }
    ?>

    <div class="<?= $gridType; ?>-grid-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <?php
        if($gridType == 'flexible') {
            //flexible grid
            //how many grid columns do we need
            $numberOfColumns = get_field('number_of_grid_columns');
        
            if($numberOfColumns == '1-grid') {
                //1 column grid
                $grid = 'flexible-grid-1';
                $gridCount = 1;
            } elseif($numberOfColumns == '2-grid') {
                //2 column grid
                $grid = 'flexible-grid-2';
                $gridCount = 2;
            } elseif($numberOfColumns == '3-grid') {
                //3 column grid
                $grid = 'flexible-grid-3';
                $gridCount = 3;
            } else {
                //4 column grid
                $grid = 'flexible-grid-4';
                $gridCount = 4;
            }

            include __DIR__ . '/../../../template-parts/blocks/grid-flexible.php';
        } else {
            $grid = 'standard-grid-3';
            $gridCount = 3;

            //standard grid
            include __DIR__ . '/../../../template-parts/blocks/grid-standard.php';
        }
        ?>
    </div>
</section>