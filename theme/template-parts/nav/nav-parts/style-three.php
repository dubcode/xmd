<?php
$heading = get_sub_field('heading');
?>

<div class="mega-menu style-three">
    <div class="style-three-container">
        <div class="style-three-container-inner">
            <div class="style-three-col">
                <div class="style-three-header-container">
                    <h3 class="style-three-header"><?php echo $heading; ?></h3>

                    <div class="menu-item">
                        <ul>
                            <?php if (have_rows('sub_menu')) : ?>
                                <?php while (have_rows('sub_menu')) : the_row();
                                    $link = get_sub_field('sub_menu_item');
                                ?>
                                    <li class="style-three-list-item"><a class="inline-block menu-item-transition" href="<?php echo esc_url($link['url']); ?>"><?php echo esc_attr($link['title']); ?></a></li>

                                <?php endwhile; ?>
                            <?php endif; ?>

                        </ul>

                    </div>


                </div>
            </div>

            <div class="col-span-1">
                <?php if (have_rows('cta')) : ?>
                    <?php while (have_rows('cta')) : the_row();

                        // Get sub field values.
                        $heading = get_sub_field('heading');
                        $link = get_sub_field('link');
                        $bgimage = get_sub_field('image');
                        $size = 'medium';
                        $image = isset( $bgimage['sizes'] ) ? $bgimage['sizes'][$size] : '';

                    ?>
                        <div id="heror" class="style-three-cta" style="background-image: url(<?php echo $image; ?>)">
                            <div class="overlay"></div>
                            <div class="cta">
                                <div class="cta-content">
                                    <h3 class="cta-text"><?php echo $heading; ?></h3>

                                    <?php if ($link) : ?>
                                        <a class="cta-button" href="<?php echo esc_url($link['url']); ?>"><?php echo esc_attr($link['title']); ?></a>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>