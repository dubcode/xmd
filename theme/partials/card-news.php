<?php
$news_id = $args['post_id'];
$news = get_post( $news_id );
?>
<article class="featured-news-item bg-grey-200">
    <?php $featured_image = extramile_get_post_thumbnail( $news->ID, 'medium'); ?>

    <div class="featured-image" style="background-image: url(<?php echo $featured_image; ?>);"></div>

    <div class="content-container p-5 flex flex-col items-center">
        <div class="item-category">
            <?php
            $categories = get_the_terms( $news->ID, 'category' );
            if( $categories ) {
                echo '<a href="' . get_category_link($categories[0]->term_id)  . '" class="category-label" title="' . esc_attr(sprintf(__("View all posts in %s", 'textdomain'), $categories[0]->name)) . '">'  . $categories[0]->name . '</a>';
            }
            ?>
        </div>
        <div class="excerpt">
            <p class="news-slider-excerpt"><?php echo substr($news->post_title, 0, 55); ?></p>
        </div>
        <a class="button-secondary button-col-primary text-white" href="<?php echo get_the_permalink($news->ID) ?>">
            <?= __('Read More', 'extramile' ); ?>
        </a>
    </div>

</article>