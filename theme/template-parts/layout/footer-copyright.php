<div class="footer-copyright bg-secondary py-5">
    <div class="container">
        <div class="lg:grid lg:grid-cols-2 lg:gap-5">
            <div class="text-primary text-sm">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?= __('All rights reserved') ?>.
            </div>

            <div class="sitemap lg:text-right">
                <span class="text-primary text-sm">
                    <?= __('Website by', EXTRAMILE_THEME_SLUG ) ?> <?= is_front_page() ? '<a class="hover:text-white" href="https://www.extramilecommunications.com/" target="_blank" rel="noopener">Extramile</a>' : 'ExtraMile' ?>
                </span>
                <?php $sitemap_url = get_field('sitemap_link', 'option');
                if ($sitemap_url) { ?>
                    <span class="pipe">|</span>
                    <span class="text-primary text-sm">
                        <a href="<?= $sitemap_url; ?>"><?= __( 'Sitemap', EXTRAMILE_THEME_SLUG ) ?></a>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
