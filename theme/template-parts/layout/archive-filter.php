<?php
/**
 * Template file for the archive filter
 * 
 */

global $wp_query;

if( is_home() ) {
    $categories = get_categories( array(
        'orderby' => 'name',
        'order' => 'ASC'
    ));
}
?>

<form action="<?= admin_url( 'admin-ajax.php' ) ?>" method="post" class="post-filter md:flex md:items-center md:justify-between mb-14">

    <?php if( is_home() && $categories ) : ?>
        
        <fieldset class="post-filter-categories-container flex gap-3 flex-wrap">
        
            <?php foreach( $categories as $cat ) : ?>
                <div class="post-filter-checkbox-container">
                    <label for="cat_<?= $cat->term_id ?>">
                        <input class="filter-post-category" type="checkbox" name="cat" id="cat_<?= $cat->term_id ?>" value="<?= $cat->term_id ?>" data-before="<?= $cat->name ?>">
                        <span class="visually-hidden"><?= $cat->name ?></span>
                    </label>
                </div>
            <?php endforeach ?>

        </fieldset>

    <?php endif ?>

    <fieldset class="orderby-container flex gap-5 items-center">
        <p class="post-count-container"><span class="post-counter"><?= $wp_query->found_posts; ?></span>  <?= 1 == intval( $wp_query->found_posts ) ? __('article') : __('articles') ?></p>

        <div class="custom-select">
            <select class="filter-post-orderby" name="orderby" id="orderby">
                    <option value=""><?= __('Sort by', 'extramile') ?></option>
                    <option value="date_asc"><?= __('Date ASC', 'extramile') ?></option>
                    <option value="date_desc"><?= __('Date DESC', 'extramile') ?></option>
                    <option value="title_asc"><?= __('Title ASC', 'extramile') ?></option>
                    <option value="title_desc"><?= __('Title DESC', 'extramile') ?></option>
            </select>
        </div>

    </fieldset>

    <input type="hidden" name="action" value="post_filter" />
    <?php wp_nonce_field() ?>

</form>