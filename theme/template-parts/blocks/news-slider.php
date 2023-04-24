<?php
$show_latest = get_field( 'show_latest_articles' );
$featured_news = get_field('news');

if( !isset($fullWidth) ) {
    $fullWidth = '';
}
?>

<div class="news-slider <?php if(!$fullWidth) { echo 'container'; } ?>">
    
    <?php if( $show_latest ) : ?>
        <?php
            // Block is set to use the latest articles
            // Perform a query to show the latest three
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $news_posts = new WP_Query( $args );

            if( $news_posts->have_posts() ) {
                while( $news_posts->have_posts() ) {
                    $news_posts->the_post();
                    get_template_part( 'partials/card', 'news', array( 'post_id' => get_the_ID() ) );
                }
            }

            wp_reset_query();
        ?>
    <?php endif ?>

    <?php
    if( !$show_latest && $featured_news ) {
        foreach ($featured_news as $news) { 
            get_template_part( 'partials/card', 'news', array( 'post_id' => $news->ID ) );
        }
    }
    ?>
</div>

<div class="explore-more-container flex justify-center pb-12 lg:pb-24">
    <a class="button-primary button-col-primary" href="<?= get_post_type_archive_link( 'post' ) ?>"><?= __('Explore More News') ?></a>
</div>