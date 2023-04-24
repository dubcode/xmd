<?php

// ========================================
// Block Name
//    > Two col
// ========================================

$blockName = 'two-col';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$blockHeader = get_field('enable_block_header');
$fullWidth = get_field('enable_full_screen');
$columnType = get_field('column_type');

$isBgColourEnabled = get_field('enable_background-colour');
// Get the tailwind colour classes for text and backgrounds
$bgColourClass = extramile_get_background_colour( get_field( 'background_colour' ) );
$textColourClasses = extramile_get_block_text_colours( get_field( 'background_colour' ) );
$blockSpacingClass = extramile_get_block_spacing_classes( get_field( 'block_spacing' ) );

if($columnType !== 'cta') {
    $column1 = get_field('column_1');
    $column2 = get_field('column_2');

    //get our column layout
    $columnLayout = get_field('column_layout');

    //get our text info
    $heading = $column2['column_heading'];
    $text = $column2['column_text'];
    $button = $column2['column_button'];
}
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $blockSpacingClass ?> <?php if($isBgColourEnabled) { echo 'column-bg '; } ?><?= $bgColourClass ?>">
    <?php
    if( $blockHeader ) {
        get_template_part( 'template-parts/blocks/block', 'header' );
    } ?>

    <div class="two-col-container <?php if(!$fullWidth) { echo 'container'; } ?>">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <?php 
            if($columnType !== 'cta') {
                $column1 = get_field('column_1');
                $column2 = get_field('column_2');
            
                //get our column layout
                $columnLayout = get_field('column_layout');
            
                //get our text info
                $heading = $column2['column_heading'];
                $text = $column2['column_text'];
                $button = $column2['column_button'];
                ?>

                <div class="two-col-column-1 <?php if($columnLayout == 'content-right') { echo 'two-col-order-2'; } else { echo 'two-col-order-1'; } ?>">
                    <?php
                    if($columnType == 'image-text') { 
                        $image = $column1['column_image'];
                        ?>
                        <img class="two-col-image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>"/>
                    <?php } 

                    if($columnType == 'slider-text') { 
                        $sliders = $column1['column_slider'];
                        ?>
                        <div class="two-col-slider">
                            <?php foreach($sliders as $slider) { 
                                $image = $slider['slider_image'];
                                ?>
                                <div class="two-col-grid-block">
                                    <img class="two-col-slider-image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>"/>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }

                    if($columnType == 'grid-text') { 
                        $grids = $column1['column_grid'];
                        ?>

                        <div class="two-col-grid">
                            <?php 
                            $i=1;
                            foreach($grids as $grid) { 
                                $gradientType = $grid['gradient_type'];
                                $gridHeader = $grid['grid_heading'];
                                $gridText = $grid['grid_text'];
                                ?>
                                <div class="two-col-grid-block <?= $gradientType . '-grid-bg'; ?> <?php if($i == 3) { echo 'third-grid'; } else if ($i == 4) { echo 'fourth-grid'; } ?>">
                                    <h5 class="two-col-grid-block-header <?= $textColourClasses['headings'] ?>"><?= $gridHeader; ?></h5>
                                    <p class="two-col-grid-block-text <?= $textColourClasses['body'] ?>"><?= $gridText; ?></p>
                                </div>
                            <?php 
                            $i++;
                            } ?>
                        </div>
                    <?php } 

                    if($columnType == 'video-text') { 
                        $videoType = $column1['video_type'];

                        if($videoType == 'internal') {
                            $video = $column1['internal_video'];
                        } else {
                            $video = $column1['external_video'];
                        }
                        
                        $video_bg = $column1['video_background'];
                        $videoPlayText = $column1['video_play_text']; 

                        if(!$videoPlayText) {
                            $videoPlayText = 'Play Video';
                        }
                        ?>

                        <div class="two-col-video-container">
                            <div class="gradient-overlay" style="background: url('<?= $video_bg; ?>') no-repeat center;"></div>

                            <div class="video-play-container <?php if($videoType == 'internal') { echo 'internal-video'; } ?>" data-bs-toggle="modal" data-bs-target="#<?= $block['id'];?>_videoModal">
                                <img class="video-play-icon" src="<?= get_template_directory_uri() . '/assets/img/play-icon-white.svg'; ?>" alt="Play Icon" />
                                <p class="video-play-text"><?= $videoPlayText; ?></p>
                            </div>
                        </div>

                        <!-- add our modal -->
                        <div class="emc-modal modal" id="<?= $block['id'];?>_videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-modal="true" role="dialog">
                            <div class="emc-modal-container modal-dialog modal-xl">
                                <div class="emc-modal-content modal-content">
                                    <div class="emc-modal-header modal-header">
                                        <button type="button" class="emc-modal-button btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="emc-modal-body modal-body">
                                        <?php
                                        if($videoType == 'internal') { ?>
                                            <video class="two-col-video">
                                                <source src="<?= $video['url']; ?>" type="video/mp4" muted>
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php } else {
                                            echo $video;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } 

                    if($columnType == 'map-text') { 
                        $location = $column1['column_map'];

                        if( $location ) { 
                            echo acf_map_helper_code();
                            ?>
                            <div class="acf-map" data-zoom="16">
                                <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
                            </div>
                        <?php } else {
                            //lets show a map image while we wait for the location
                            ?>
                            <img class="two-col-image" src="<?= get_template_directory_uri() . '/assets/img/twocol-no-locations.PNG'; ?>" alt="No Map Location Image"/>
                        <?php 
                        }
                    }
                    ?>
                </div>

                <div class="two-col-column-2 <?php if($columnLayout == 'content-right') { echo 'two-col-order-1'; } else { echo 'two-col-order-2'; } ?>">
                    <div class="<?php if($columnType == 'image-text' && $columnLayout == 'content-right') { echo 'two-col-padding-left'; } else { echo 'two-col-padding-right'; } ?>">
                        
                        <?php if($heading) { ?>
                            <h2 class="two-col-heading <?= $textColourClasses['headings'] ?>"><?= $heading; ?></h2>
                        <?php } ?>

                        <?php if( $columnType == 'map-text' && get_field( 'show_default_location_info' ) ) : ?>
                            
                            <div class="written">
                                <?php if( $address = get_field('registered_address', 'option' ) ) : ?>
                                    <strong class="heading-5 block mb-5"><?= __('Find us'); ?></strong>
                                    <p class=""><?= $address ?></p>
                                <?php endif ?>
                                
                                <?php if( $email = get_field('main_email', 'option' ) ) : ?>
                                    <strong class="heading-5 block mb-5 mt-8"><?= __('Email us'); ?></strong>
                                    <p><a class="hover:text-secondary transition-all" href="mailto:<?= $email ?>"><?= esc_html( $email ) ?></a></p>
                                <?php endif ?>
                                
                                <?php if( $phone = get_field('phone_number', 'option' ) ) : ?>
                                    <strong class="heading-5 block mb-5 mt-8"><?= __('Call us'); ?></strong>
                                    <p><a class="hover:text-secondary transition-all" href="tel:<?= str_replace( ' ', '', $phone ) ?>"><?= esc_html( $phone ) ?></a></p>
                                <?php endif ?>
                            </div>

                        <?php else : ?>

                            <?php if($text) { ?>
                                <div class="two-col-text written <?= $textColourClasses['body'] ?>"><?= $text; ?></div>
                            <?php } ?>

                            <?php if($button) { ?>
                                <a class="button-primary button-col-primary" href="<?= $button['url']; ?>"><?= $button['title']; ?></a>
                            <?php } ?>

                        <?php endif ?>
                    </div>
                </div>
            <?php } else {
                //we have the call to actions selected
                $ctas = get_field('call_to_actions');

                foreach($ctas as $cta) {
                    include __DIR__ . '/../../../template-parts/blocks/cta.php';
                }
            } ?>
        </div>
    </div>
</section>