<?php
$email = get_field('main_email', 'options');
$phone_number = get_field('phone_number', 'options');
$margin_top = is_search() ? '' : 'mt-20';
$footerMenus = get_field('footer_information', 'option');
?>
<div class="top-footer bg-primary py-12">
    <div class="container">
        <div class="emc-footer-left">
            <div class="mb-5">
                <?php
                $companyLogo = get_field('company_logo', 'option');
                ?>
                <a href="/"><img class="site-logo mb-7" src="<?= $companyLogo['url']; ?>" alt="<?= $companyLogo['name']; ?>" /></a>

                <p class="text-white text-lg mb-2">
                    <b>Registered Address:</b> <?= get_field('registered_address', 'options'); ?>
                </p>

                <p class="text-white text-lg mb-4">
                    <b>Company Number:</b> 04005599
                </p>

                <?php if( $phone_number ) : ?>
                    <div class="flex items-center justify-start text-white text-lg mb-2">
                        <img class="w-4 mr-2" src="<?= get_template_directory_uri() . '/assets/img/phone-icon.svg'; ?>" alt="Phone Icon">
                        <a class="font-bold hover:text-secondary transition-all" href="tel:<?= str_replace( ' ', '', $phone_number ) ?>"><?= esc_html( $phone_number ) ?></a>
                    </div>
                <?php endif ?>

                <?php if( $email ) : ?>
                    <div class="flex items-center justify-start text-white text-lg">
                        <img class="w-4 mr-2" src="<?= get_template_directory_uri() . '/assets/img/email-icon.svg'; ?>" alt="Email Icon">
                        <a class="font-bold hover:text-secondary transition-all" href="mailto:<?= $email ?>"><?= esc_html( $email ) ?></a>
                    </div>
                <?php endif ?>

            </div>
            <div class="emc-footer-right-wrapper">
                <div class="emc-footer-right-certs flex items-center justify-between sm:pr-[33.33%] lg:pr-0 lg:pl-[33.33%] mb-8">
                    <img class="h-[40px] w-auto" src="<?= get_template_directory_uri() . '/assets/img/mmta.png'; ?>" alt="MMTA">
                    <img class="h-[60px] w-auto" src="<?= get_template_directory_uri() . '/assets/img/reach-logo.png'; ?>" alt="Reach">
                    <img class="h-[60px] w-auto" src="<?= get_template_directory_uri() . '/assets/img/iso.jpg'; ?>" alt="ISO">
                </div>
                <div class="emc-footer-right grid lg:grid-cols-3 lg:gap-4">
                    <div class="footer-right-menu"></div>
                    <?php for ($i = 2; $i <= 3; $i++) { ?>
                        <div class="footer-right-menu">
                            <h5 class="footer-menu-title"><?= $footerMenus['column_' . $i . '_title']; ?></h5>
                            <?php
                            $menu_items = wp_get_nav_menu_items($footerMenus['column_' . $i . '_menu']);
                            ?>
                            <ul class="footer-menu">
                                <?php foreach ($menu_items as $menu_item) { ?>
                                    <li class="footer-menu-item">
                                        <a class="menu-item-transition" href="<?= esc_html( $menu_item->url ); ?>">
                                            <?= $menu_item->title; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="accordion accordion-flush lg:hidden" id="emc-accordion">
                        <?php for ($i = 2; $i <= 3; $i++) {
                            $menu_items = wp_get_nav_menu_items($footerMenus['column_' . $i . '_menu']);
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="emc-accordion-heading<?= $i; ?>">
                                    <button class="accordion-button collapsed flex items-center justify-between font-normal" type="button" data-bs-toggle="collapse" data-bs-target="#emc-accordion-collapse-footer-<?= $i; ?>"
                                        aria-expanded="false" aria-controls="emc-accordion-collapse-footer-<?= $i; ?>">
                                        <?= $footerMenus['column_' . $i . '_title']; ?>

                                        <img class="w-4" src="<?= get_template_directory_uri() . '/assets/img/chevron-down.svg'; ?>" alt="Toggle Content">
                                    </button>
                                </h2>
                                <div id="emc-accordion-collapse-footer-<?= $i; ?>" class="accordion-collapse"
                                aria-labelledby="flush-heading<?= $i; ?>" data-bs-parent="#emc-accordion">
                                    <div class="accordion-body">
                                        <ul class="footer-menu">
                                            <?php foreach ($menu_items as $menu_item) { ?>
                                                <li class="footer-menu-item">
                                                    <a href="<?= esc_html( $menu_item->url ); ?>">
                                                        <?= $menu_item->title ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
