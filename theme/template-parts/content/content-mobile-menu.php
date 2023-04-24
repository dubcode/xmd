<?php
$menu_name = 'mobile';
// Get the mega menu repeater data
$mega_menu_items = get_field( 'menu', 'option' );
?>

<?php if( is_countable( $mega_menu_items ) && count( $mega_menu_items ) ) : ?>

    <div class="emc-push-menu hidden">
        <div class="nav-wrapper">
            <nav role="navigation">
                <ul class="mobile-nav-container">
                    <?php foreach( $mega_menu_items as $item ) : ?>
                        <?php
                        $link = isset( $item['menu_item']['url'] ) ? $item['menu_item']['url'] : '';
                        $title = isset( $item['menu_item']['title'] ) ? $item['menu_item']['title'] : '';
                        $title = str_replace( "&amp;", "And", $title );
                        $sub_menu = isset( $item['sub_menu'] ) && !empty( $item['sub_menu'] ) ? $item['sub_menu'] : [];
                        $is_parent = count( $sub_menu ) ? 1 : 0;
                        ?>

                        <li class="<?php if( $is_parent ) { echo 'has-dropdown'; } ?> container nav-list-item bg-grey-light mb-1">
                            <a href="<?= esc_attr( $link ); ?>" class="mobile-nav-title">
                                <?= esc_html( $title ); ?>
                            </a>

                            <?php if( $is_parent ) : ?>
                                <img class="arrow-icon" src="<?= get_template_directory_uri() . '/assets/img/arrow-right.svg'; ?>" alt="Nav Arrow Right">  
                            <?php endif ?>

                            <?php // Check if we have a submenu and display it
                            if( $sub_menu ) : ?>
                                <ul class="submenu-container">
                                    <div class="nav-toggle hidden">
                                        <img class="arrow-icon" src="<?= get_template_directory_uri() . '/assets/img/arrow-left.svg'; ?>" alt="Nav Arrow Left"> 
                                        <span class="nav-back"><?= __('Back to Main Menu', EXTRAMILE_THEME_SLUG ) ?></span>
                                    </div>

                                    <?php foreach( $sub_menu as $sub_menu_item ) : ?>
                                        <?php
                                        $link = isset( $sub_menu_item['sub_menu_item']['url'] ) ? $sub_menu_item['sub_menu_item']['url'] : '';
                                        $title = isset( $sub_menu_item['sub_menu_item']['title'] ) ? $sub_menu_item['sub_menu_item']['title'] : '';
                                        ?>
                                        <li class="submenu-list-item">
                                            <a href="<?= esc_attr( $link ); ?>" class="mobile-nav-title text-base"><?= esc_attr( $title ) ?></a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if( is_woocommerce_activated() ) : ?>
                    <!-- Add Our Footer -->
                    <div class="mobile-menu-footer">
                        <a class="login-icon" href="<?= wc_get_page_permalink( 'myaccount' ) ?>"><i class="fas fa-user-circle"></i> <span class="login-text">Login</span></a>
                    </div>
                <?php endif ?>
            </nav>
        </div>
    </div>

<?php endif ?>