<?php

// ========================================
// Block Name
//    > Three col
// ========================================

$blockName = 'three-col';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$columnType = get_field('column_type');
$fullWidth = get_field('enable_full_screen');
$blockHeader = get_field('enable_block_header');
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?>">
    <?php
    if($blockHeader) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    }
    ?>

    <div class="three-col-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <div class="grid grid-cols-1 md:grid-cols-3">
            <?php
            if($columnType =='image-cta') {
                $ctas = get_field('image_call_to_actions');

                foreach($ctas as $cta) {
                    include __DIR__ . '/../../../template-parts/blocks/image-cta.php';
                }
            }

            if($columnType =='cta') {
                $ctas = get_field('call_to_actions');

                foreach($ctas as $cta) {
                    include __DIR__ . '/../../../template-parts/blocks/cta.php';
                }
            }
            ?>
        </div>
    </div>
</section>