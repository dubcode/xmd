<?php
// Get team member custom field data
$job_title   = get_field( 'tm_job_title' );
$department  = get_field( 'tm_department' );
$intro_text  = get_field( 'tm_intro_text' );
$cta         = get_field( 'tm_call_to_action' );
$featured_image = get_the_post_thumbnail( get_the_ID(), 'medium',  array( 'style' => 'width: 100%'));
?>

<div class="container team-hero-container">

    <div class="grid gap-10 lg:grid-cols-2">

        <div class="team-hero-left text-center md:text-left">

            <?php if( function_exists('yoast_breadcrumb') ) : ?>
                <div class="breadcrumb-container mb-8 text-white"><?php yoast_breadcrumb('<p id="breadcrumbs" class="">', '</p>'); ?></div>
            <?php endif ?>

            <h1 class="heading-2 text-white mb-5"><?= get_the_title() ?></h1>

            <?php if( $job_title || $department ) : ?>
                <div class="team-member-details mb-8 md:flex md:items-center">
                    <?php if( $job_title ) : ?>
                        <strong class="block heading-6 text-white"><?= $job_title ?></strong>
                    <?php endif ?>

                    <?php if( $job_title && $department ) : ?>
                        <span class="mx-3 text-white">•</span>
                    <?php endif ?>

                    <?php if( $department ) : ?>
                        <strong class="block heading-6 text-white"><?= $department ?></strong>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if( $intro_text ) : ?>
                <div class="written mb-8 text-grey-400"><?= $intro_text ?></div>
            <?php endif ?>

            <?php if( $cta ) : ?>
                <div class="team-cta-container">
                    <a href="<?= esc_attr( $cta['url'] ) ?>" class="button-primary button-col-primary"><?= $cta['title'] ?></a>
                </div>
            <?php endif ?>

        </div>

        <div class="team-hero-right flex justify-center">

            <?php if( $featured_image ) : ?>
                <figure class="max-h-[33rem] w-4/5 mx-auto -mb-20 lg:mb-0"><?= $featured_image ?></figure>
            <?php endif ?>
        
        </div>

    </div>


</div>