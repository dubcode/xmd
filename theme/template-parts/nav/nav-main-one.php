<?php
$showCTA = get_field('enable_nav_cta', 'option');
?>

<ul class="mega-menu-nav">
    <?php
    // Check rows exists.
    if (have_rows('menu', 'option')) :
        //implement a counter
        $menu = 1;

        // Loop through rows.
        while (have_rows('menu', 'option')) : the_row();
            $menu_item = get_sub_field('menu_item');
            $dropdown_style = get_sub_field('dropdown_style');
            $is_button = get_sub_field('emc_button');
            ?>      

            <li class="<?= $is_button ? 'main-nav-cta' : 'hoverable hover:text-grey-400'?> <?php if ($dropdown_style == 'style4') : ?>singlecolumn<?php endif; ?> <?php if ($dropdown_style) : ?>has-children carrot<?php endif; ?>">
                <a class="<?= $is_button ? 'main-nav-cta-button' : 'mega-menu-item first-level mega-menu-item-' . $menu; ?>" href="<?php echo $menu_item['url']; ?>" menu-item="mega-menu-menu-<?= $menu; ?>"><?php echo $menu_item['title']; ?></a>

                    <?php
                     if( !empty($dropdown_style) ) {
                        switch ($dropdown_style) {
                            case 'style1':
                                get_template_part('template-parts/nav/nav', 'parts/style-one');
                                break;
                            case 'style2':
                                get_template_part('template-parts/nav/nav', 'parts/style-two');
                                break;
                            case 'style3':                        
                                get_template_part('template-parts/nav/nav', 'parts/style-three');
                                break;
                            case 'style4':
                                get_template_part('template-parts/nav/nav', 'parts/style-four');
                                break;
                            default:
                                // Fallback to the most basic dropdown
                                get_template_part('template-parts/nav/nav', 'parts/style-four');
                                break;
                        }
                    }
                    ?>
            </li>
            <?php
            $menu++;
        endwhile;
    endif;
    ?>
</ul>