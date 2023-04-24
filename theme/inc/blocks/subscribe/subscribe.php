<?php

// ========================================
// Block Name
//    > Sbscribe
// ========================================

$blockName = 'subscribe';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];
$blockTopBorder = get_field( 'display_top_border' );
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($blockClasses); ?> <?= $blockTopBorder ? 'border-t border-grey-400' : '' ?>">
    <?php get_template_part( 'template-parts/blocks/subscribe', 'form' ); ?>
</section>