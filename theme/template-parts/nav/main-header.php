<?php
$navStyle = get_field('main_nav_style','option');
$logo = get_field('company_logo', 'option');
?>

<div class="container main-header">
    <?php if($navStyle == 'style-1') { ?>
        <div class="style-one-banner-logo flex">
            <?php if( $logo ) : ?>
                <a href="<?= get_home_url() ?>" class="inline-block transition-all transform hover:scale-110"><img class="site-logo" src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" /></a>
            <?php endif ?>
        </div>

        <div class="banner-nav style-one">
            <nav>
                <div class="banner-nav-inner">
                    <?php 
                    get_template_part('template-parts/nav/nav-main', 'one'); 
                    ?>
                </div>
            </nav>
        </div>
    <?php } else if($navStyle == 'style-2') { ?>
        <div class="style-two-banner-logo">
            <?php 
            if(get_field('company_logo', 'option')) {
                $logo = get_field('company_logo', 'option'); ?>

                <a href="<?= get_home_url() ?>"><img class="site-logo" src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" /></a>
            <?php } ?>
        </div>

        <div class="banner-nav style-two">
            <nav>
                <div class="banner-nav-inner">
                    <?php 
                    get_template_part('template-parts/nav/nav-main', 'two'); 
                    ?>
                </div>
            </nav>
        </div>
    <?php } ?>
</div>