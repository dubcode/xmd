<?php
/**
 * Load More Button Template File
 * 
 */

global $wp_query;
?>

<nav class="load-more-container flex flex-col items-center justify-center mb-12 lg:mb-24">
    <?php if( $wp_query->found_posts > $wp_query->post_count ) : ?>
        <button class="load-more button-primary button-col-primary" data-action="loadmore_basic" data-text-default="<?= __('Load More Articles','extramile'); ?>" data-text-loading="<?= __('Loading','lf'); ?>..." data-max-num-pages="<?= $wp_query->max_num_pages ?>"><?= __('Load More Articles','extramile'); ?></button>
    <?php endif ?>

    <p class="mt-5"><?= sprintf( __('Viewing <span class="post-counter-displayed">%d</span> of <span class="post-counter">%d</span> articles'), $wp_query->post_count, $wp_query->found_posts ) ?></p>
</nav>