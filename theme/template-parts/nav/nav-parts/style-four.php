<?php

$sub_menu = get_sub_field('sub_menu');

// Check rows exists.
if (have_rows('sub_menu')) : ?>

    <div class="mega-menu style-four">
        <div class="style-four-container">
            <ul class="style-four-ul">
                <?php    // Loop through rows.
                while (have_rows('sub_menu')) : the_row(); ?>
                    <?php $sub_menu_item = get_sub_field('sub_menu_item'); ?>

                    <li class="style-four-item ">

                        <span class="style-four-li">
                            <a class="inline-block menu-item-transition" href="<?php echo $sub_menu_item['url']; ?>"><?php echo $sub_menu_item['title']; ?></a>
                        </span>

                    </li>

                <?php  // End loop.
                endwhile;
                ?>
            </ul>
        </div>
    </div>
<?php endif; ?>