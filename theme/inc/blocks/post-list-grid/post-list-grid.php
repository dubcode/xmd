<?php

// ========================================
// Block Name
//    > One col
// ========================================

$blockName = 'post-list-grid';

// Set up our block values.
$id = get_block_id($blockName, $block);

//get our block classes
$blockClasses = get_block_classes($blockName . '-block', $block);

//get the name ACF assigns to the block
$acfBlockName = $block['name'];

$blockHeader = get_field('enable_block_header');
$fullWidth = get_field('enable_full_screen');

$bgColour = get_field('enable_background-colour');
$selectedBgColour = get_field('bg_colour');
$bgColourClass = extramile_get_background_colour( $selectedBgColour );
$buttonColourClass = extramile_get_button_colour( $selectedBgColour );
$textColourClasses = extramile_get_block_text_colours( $selectedBgColour );
$blockSpacingClass = extramile_get_block_spacing_classes( get_field( 'block_spacing' ) );
$postType = get_field( 'post_type' );
?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($blockClasses); ?> <?= $bgColourClass ?> <?= $blockSpacingClass ?>">
    <?php
    if( $blockHeader ) {
        get_template_part( 'template-parts/blocks/block', 'header', array( 'bg_colour' => $bgColour ) );
    }
    ?>

    <?php 
    $args = array(
        'post_type' => $postType,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $posts = new WP_Query( $args );
    ?>

    <?php if( $posts->have_posts() ) : ?>
        
        <div class="post-list-grid four-col-grid <?php if(!$fullWidth) { echo 'container'; } ?>">

            <?php while( $posts->have_posts() ) : $posts->the_post(); ?>

                <?php
					// Setup $cta variable with required data
					// Then call the template partial
					$cta = array(
						// 'background'  => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
						'heading'     => get_the_title(),
						'description' => get_field( 'tm_job_title' ),
						'button' 	=> array(
							'url' 	=> get_post_permalink(),
							'title' => sprintf( __('Meet %s', EXTRAMILE_THEME_SLUG ), get_the_title() ),
						)
					);
					include __DIR__ . "../../../../template-parts/blocks/cta.php";
                ?>

            <?php endwhile ?>

        </div>

        <?php wp_reset_query(); ?>

    <?php else : ?>

        <div class="container pb-12 lg:pb-24">
            <h2 class="heading-4 text-center"><?php esc_html_e( 'No content matched your request.', 'extramile-theme-2023' ); ?></h2>
        </div>

    <?php endif ?>

</section>