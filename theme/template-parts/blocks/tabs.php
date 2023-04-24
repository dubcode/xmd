<?php

/**
 * Tabs Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'tabs-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'tabs';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}
?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> relative mt-20 tabs h-full">
    <div class="tabs">
        <ul id="tabs-nav">
            <?php if (have_rows('tab_repeater')) : ?>

                <?php while (have_rows('tab_repeater')) : the_row();

                    $title = get_sub_field('title');
                    $title = str_replace(' ', '_', strtolower($title) );
                    $index = get_row_index();

                    //if first tab, set aradio as checked
                    if ($index == 1) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                ?>
                    <li class="w-auto min-w-[280px] text-center font-bold text-grey-900 md:text-xl p-8 flex-grow"><a href="#<?php echo $title; ?>"><?php the_sub_field('title') ?></a></li>
                <?php endwhile; ?>

            <?php endif; ?>
        </ul>

        <div id="tabs-content" class="tabs-content-container min-h-[150px]">

            <InnerBlocks />

        </div>
</section>