<?php

// ========================================
// Block Name
//    > Tabs
// ========================================

$blockName = 'tabs';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$blockHeader = get_field('enable_block_header');
$fullWidth = get_field('enable_full_screen');
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?>">
    <?php
    if($blockHeader) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    }
    ?>

    <div class="tabs-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <?php
        $tabs = get_field('tabs');

        include __DIR__ . '/../../../template-parts/blocks/tabs.php';
        ?>
    </div>
</section>