<?php
// Data passed through via get_template_partial();
$bgColour = isset( $args['bg_colour'] ) ? $args['bg_colour'] : 'transparent';
$classes = isset( $args['classes'] ) ? $args['classes'] : '';

// If our variables are not set, get them from ACF.
// These should ideally be passed in via $args using get_template_part()
if( !isset($header) ) {
    $header = isset( $args['header'] ) && !empty( $args['header'] ) ? $args['header'] : get_field( 'block_header' );
}

if( !isset($text) ) {
    $text = isset( $args['text'] ) && !empty( $args['text'] ) ? $args['text'] : get_field( 'block_heading_text' );
}

if( !isset($button) ) {
    $button = isset( $args['button'] ) && !empty( $args['button'] ) ? $args['button'] : get_field( 'block_heading_button' );
}

// Get the heading size class from ACF.
// This field returns a valid heading component class.
$headingSizeClass = extramile_get_heading_size_class( get_field( 'block_header_title_size' ) );
$buttonColourClass = extramile_get_button_colour( $bgColour );
?>

<div class="block-header-container <?= $classes ?>">
    <?php if( $header ) { ?>
        <h2 class="block-header text-center <?= !empty($headingSizeClass) ? $headingSizeClass : '' ?>"><?= $header; ?></h2>
    <?php } ?>

    <?php if( $text ) { ?>
        <div class="written block-text lg:text-lg"><?= $text; ?></div>
    <?php } ?>

    <?php if($button) { ?>
        <a class="block-button <?= !empty( $buttonColourClass ) ? $buttonColourClass : '' ?>" url="<?= $button['url']; ?>"><?= $button['title']; ?></a>
    <?php } ?>
</div>