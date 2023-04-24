<?php

$column_repeater = get_sub_field('column_repeater');

// Check rows exists.
if (have_rows('column_repeater')) : ?>

    <div class="mega-menu style-two">
        <div class="style-two-container">
            <div class="style-two-container-inner">
                <?php    // Loop through rows.
                while (have_rows('column_repeater')) : the_row();
                    $heading = get_sub_field('heading');

                ?>

                    <div>
                        <div class="style-two-heading-container">
                            <h3 class="style-two-heading"><?php echo $heading; ?></h3>

                            <div class="menu-item">

                                <ul class="block">
                                    <?php
                                    // Check rows exists.
                                    if (have_rows('links')) :

                                        // Loop through rows.
                                        while (have_rows('links')) : the_row();

                                            $menu_item = get_sub_field('sub_menu_item');

                                    ?>

                                            <li class="style-two-li">
                                                <a class="inline-block menu-item-transition" href="<?php echo $menu_item['url']; ?>"><?php echo $menu_item['title']; ?></a>
                                            </li>

                                    <?php  // End loop.
                                        endwhile;

                                    // No value.
                                    else :
                                    // Do something...
                                    endif;

                                    ?>
                                </ul>

                            </div>


                        </div>
                    </div>



                <?php  // End loop.
                endwhile;
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>