<div class="emc-inner text-center bg-grey-100 pb-6 px-5 md:px-0">
    <?php $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>
    <div class="emc-background-image" style="background-image: url(<?= $featured_image; ?>);">

    </div>
    <div class="archive-content px-7 py-5">
        <?php

        //get post category
        $categories = get_the_category();
        $separator = ' ';
        $output = '';
        if ($categories) {
            $output .= '<a class="border border-grey-700 bg-grey-700 hover:bg-transparent text-white hover:text-grey-700 text-sm px-2 py-1 leading-7 no-underline" href="' . get_category_link($categories[0]->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'textdomain'), $categories[0]->name)) . '">' . $categories[0]->cat_name . '</a>' . $separator;
        }
        echo trim($output, $separator);

        $excerpt = get_the_title();
        $excerpt = substr($excerpt, 0, 50)
        ?>
        <h2 class="text-xl mt-4"><a href="<?php the_permalink(); ?>"><?= $excerpt; ?></a></h2>
        <div class="mt-10">
            <a class="text-center border border-grey-800  bg-grey-800  hover:bg-transparent px-5 py-2 uppercase text-white hover:text-grey-800  no-underline max-w-xs" href="<?php the_permalink(); ?>">Read More</a>
        </div>


    </div>
</div>