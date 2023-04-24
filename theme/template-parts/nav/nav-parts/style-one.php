<?php

$submenu = get_sub_field('sub_menu');

// Check rows exists.
if (have_rows('sub_menu')) : ?>

    <div class="mega-menu style-one">
        <div class="style-one-container">
            <ul class="style-one-ul">
                <?php    // Loop through rows.
                while (have_rows('sub_menu')) : the_row();

                    $menu_item = get_sub_field('sub_menu_item');
                    $menu_image = get_sub_field('image');
                    $size = 'large';
                    $image = $menu_image['sizes'][$size];
                    $link   = get_sub_field('sub_menu_item');
                ?>

                    <li>
                        <a href="<?php echo $link['url'];?>" class="group">
                            <div class="style-one-bg" style="background-image: url(<?php echo $image; ?>);"></div>
                            <div class="style-one-title-container">
                                <span class="style-one-title-icon">
                                    <svg x="0px" y="0px" viewBox="0 0 62.7 108" style="enable-background:new 0 0 62.7 108;" xml:space="preserve">
                                        <g transform="translate(30.000000, 220.000000)">
                                            <path d="M-27.3-219.1l-1.8,1.7c-1.2,1.1-1.2,3,0,4.1L21.6-166l-50.6,47.3c-1.2,1.1-1.2,3,0,4.1 l1.8,1.7c1.2,1.1,3.2,1.1,4.4,0l54.7-51.1c1.2-1.1,1.2-3,0-4.1l-54.7-51.1C-24.1-220.3-26-220.3-27.3-219.1z"/>
                                        </g>
                                    </svg>
                                </span>
                                <h3 class="style-one-title transform transition-transform group-hover:text-grey-400 group-hover:translate-x-1"><?php echo $menu_item['title']; ?></h3>
                            </div>
                        </a>
                    </li>

                <?php  // End loop.
                endwhile;
                ?>
            </ul>
        </div>
    </div>
<?php endif; ?>