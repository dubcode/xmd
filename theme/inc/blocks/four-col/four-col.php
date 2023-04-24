<?php

// ========================================
// Block Name
//    > Three col
// ========================================

$blockName = 'four-col';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$columnType = get_field('column_type');
$fullWidth = get_field('enable_full_screen');
$blockHeader = get_field('enable_block_header');
$bgColourClass = extramile_get_background_colour( get_field( 'background_colour' ) );
$textColourClasses = extramile_get_block_text_colours( get_field( 'background_colour' ) );
$blockSpacingClass = extramile_get_block_spacing_classes( get_field( 'block_spacing' ) );
$blockColumnSpacing = get_field( 'enable_column_spacing' );
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $blockSpacingClass ?> <?= $bgColourClass ?> <?php if($columnType =='download') { echo 'download-bg'; } ?>">
    <?php
    if( $blockHeader ) {
        get_template_part( 'template-parts/blocks/block', 'header' ); 
    }
    ?>

    <div class="four-col-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <?php if($columnType =='image') {
            //we need to add our instagram itle and link if client wants, before the grid
            $title = get_field('images_title');
            $instagramLink = get_field('show_instagram_link');
            ?>
        
            <?php if( $title || $instagramLink ) : ?>
                <div class="container grid grid-cols-2 gap-5 mb-5 md:mb-10">
                    <?php if( $title ) : ?>
                        <h4 class="heading-4"><?= $title; ?></h4>
                    <?php endif ?>

                    <?php if( $instagramLink ) : ?>
                        <div class="image-call-to-action-instagram-container flex justify-end">
                            <a class="four-col-image-call-to-action-instagram-text" href="<?= get_field('instagram_link'); ?>">Visit Instagram</a>
                            <i class="four-col-image-call-to-action-instagram-icon fab fa-instagram"></i>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        <?php } ?>

        <div class="four-col-grid <?= $blockColumnSpacing ? 'gap-10' : 'gap-0' ?> <?= $columnType ?>-grid">
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

            if($columnType =='download') {
                $downloads = get_field('downloads');

                foreach($downloads as $download) {
                    include __DIR__ . '/../../../template-parts/blocks/download-cta.php';
                }
            }

            if($columnType =='image') {
                $imageCTAType = get_field('image_cta_type');

                if($imageCTAType == 'images') {
                    $images = get_field('four_col_images');
                    include __DIR__ . '/../../../template-parts/blocks/four-col-image.php';
                } else {
                    $instagramFeed = get_field('instagram_feed');
                    echo do_shortcode($instagramFeed);
                }
            }

            if($columnType == 'form') {
                $form = get_field('form');
                echo do_shortcode($form);
            }

            if($columnType == 'tabs') {
                $tabs = get_field('tabs');

                include __DIR__ . '/../../../template-parts/blocks/tabs.php';
            }
            ?>
        </div>
    </div>
</section>