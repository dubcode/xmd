<ul class="mega-menu-nav">
    <?php
    // Check rows exists.
    if (have_rows('menu', 'option')) :
        //work out our halves
        $count = count(get_field('menu','option'));
        $firstHalf = ceil($count / 2);
        $secondHalf = $count-$firstHalf;

        //implement a counter for our mega menus
        $menu = 1;

        //create an integer to count our loop, used for wrapping our list items
        $i = 0;

        // Loop through rows.
        while (have_rows('menu', 'option')) : the_row();
            $menu_item = get_sub_field('menu_item');
            $emc_button = get_sub_field('emc_button');

            if($i == 0) {
                //start our first div
                echo '<div class="menu-first-half">';
            }

            if($i == $secondHalf) {
                //start our second containing div
                echo '<div class="menu-second-half">';
            }
            ?>      

            <li class="hoverable <?php if ($dropdown_style == 'style4') : ?>singlecolumn<?php endif; ?> <?php if ($dropdown_style) : ?>has-children carrot<?php endif; ?><?php if ($emc_button) : ?> show-button<?php endif; ?>">
                <a class="mega-menu-item first-level mega-menu-item-<?= $menu; ?> <?php if ($emc_button) : ?>emc-menu-button<?php endif; ?>" href="<?php echo $menu_item['url']; ?>" menu-item="mega-menu-menu-<?= $menu; ?>"><?php echo $menu_item['title']; ?></a>
                
                    <?php
                    if (!empty($dropdown_style)) {
                        switch ($dropdown_style) {
                            //output style 4 under the hyperlink due to it being a dropdown
                            case 'style4':
                                get_template_part('template-parts/nav/nav', 'parts/style-four');
                                break;

                            default:
                                '';
                                break;
                        }
                    }
                    ?>
            </li>
            <?php

            if($i == $secondHalf-1) {
                // we need to close our container div
                echo '</div>';

                //add our logo
                $logo = get_field('company_logo', 'option'); ?>

                <a href="/"><img class="site-logo" src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" /></a>
            <?php
            }

            $i++; //increase our integer by 1
            $menu++;
        endwhile;

        //while record has now finished, close our second container div
        echo '</div>';
    endif;
    ?>
</ul>