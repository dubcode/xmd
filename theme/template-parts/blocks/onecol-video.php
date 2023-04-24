<?php
// TODO: template files needs simplifying
// All this processing should be done prior to call the files and passed through via $args
if( is_woocommerce_activated() && is_product()) {
    //call our product option
    global $product;

    $id = $product->get_id();

    if( get_field('product_video', $product->get_id() ) ) {
        $videoGroup = get_field('product_video', $product->get_id());
    } else {
        $videoGroup = get_field('product_video', 'option');
    }

    $videoType = $videoGroup['video_type'];

    if($videoType == 'internal') {
        $video = $videoGroup['internal_video'];
    } else {
        $video = $videoGroup['external_video'];
    }

    $videoHeader = $videoGroup['enable_video_header'];
    $videoPlayText = isset( $videoGroup['video_play_text'] ) ? $videoGroup['video_play_text'] : __(' Play Video', EXTRAMILE_THEME_SLUG );
} else {
    $id = $block['id'];
    //this will be a normal block
    $videoType = get_field('video_type');

    if($videoType == 'internal') {
        $video = get_field('internal_video');
    } else {
        $video = get_field('external_video');
    }

    $videoHeader = get_field('enable_video_header');
    $videoPlayText = !empty( get_field( 'video_play_text' ) ) ? get_field( 'video_play_text' ) : __('Play Video');
}

$backgroundImage = get_field( 'bg_image' );
?>

<div class="one-col-video-container gradient-overlay <?= isset( $fullWidth ) && !$fullWidth ? 'is-contained' : '' ?>" style="<?= !empty( $backgroundImage ) ? 'background-image: url(' . $backgroundImage['sizes']['large'] . ')' : '' ?>">

    <div class="video-info-container">
        <?php if($videoHeader) { 
            if( is_woocommerce_activated() && is_product() ) {
                $videoHeaderTitle = $videoGroup['video_header_text'];
                $videoHeaderDescription = $videoGroup['video_header_description'];
            } else {
                $videoHeaderTitle = get_field('video_header_text');
                $videoHeaderDescription = get_field('video_header_description');
            }
            ?>
            <div class="video-header">
                <h2 class="video-play-title heading-2 text-white mb-0"><?= $videoHeaderTitle; ?></h2>
                <div class="video-play-description written text-grey-400 text-center mt-8"><?= $videoHeaderDescription; ?></div>
            </div>
        <?php } ?>

        <button class="video-play-container group mt-8 <?php if($videoType == 'internal') { echo 'internal-video'; } ?>" data-bs-toggle="modal" data-bs-target="#video-modal-<?= $id ?>" >
            <img class="video-play-icon transition-transform transform group-hover:-translate-y-1" src="<?= get_template_directory_uri() . '/assets/img/play-icon-white.svg'; ?>" alt="Play Icon" />
            <span class="video-play-text text-grey-100"><?= $videoPlayText; ?></span>
        </button>
    </div>
</div>

<!-- Add our video modal -->
<div class="emc-modal modal" id="video-modal-<?= $id ?>" tabindex="-1" aria-labelledby="videoModalLabel" aria-modal="true" role="dialog">
    <div class="emc-modal-container modal-dialog modal-xl">
        <div class="emc-modal-content modal-content">
            <div class="emc-modal-header modal-header">
                <button type="button" class="emc-modal-button btn-close"
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="emc-modal-body modal-body">
                <?php if($videoType == 'internal') : ?>
                    <video class="onecol-video">
                        <source src="<?= $video['url']; ?>" type="video/mp4" muted>
                        <?= __('Your browser does not support the video tag.', EXTRAMILE_THEME_SLUG ); ?>
                    </video>
                <?php else : ?>
                    <div class="responsive-video"><?= $video; ?></div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>