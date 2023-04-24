<div class="grid <?= $grid; ?>">
    <?php
    for($i=1; $i < $gridCount+1; $i++) { ?>
        <div class="standard-grid-inner">
            <?php
            //get our column info
            $column = get_field('column_' . $i);

            //get our grid items
            $grids = $column['standard_grid'];

            foreach($grids as $grid) {
                $imageType = $grid['image_type'];

                if($imageType == 'fa') {
                    $faIcon = $grid['font_awesome'];
                } else {
                    $image = $grid['image'];
                }

                $heading = $grid['heading'];
                $description = $grid['description'];
                ?>

                <div class="standard-grid-item <?php if($i==2) { echo 'standard-grid-large'; } else { echo 'standard-grid-small'; } ?>">
                    <?php
                    if($image || $faIcon) {
                        if($imageType == 'fa') { ?>
                            <div class="standard-grid-item-icon">
                                <?= $faIcon; ?>
                            </div>
                        <?php } else { ?>
                            <?php if(is_array($image)) { ?>
                                <img class="standard-grid-item-image" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                            <?php } else { ?>
                                <img class="standard-grid-item-image" src="<?= wp_get_attachment_url($image); ?>" alt="" />
                            <?php } ?>
                            
                        <?php }
                    }
                    ?>

                    <?php if( $heading ) : ?>
                        <h3 class="standard-grid-item-header text-center <?= isset( $headerPadding ) ? esc_attr( $headerPadding ) : '' ?>"><?= esc_html($heading) ?></h3>
                    <?php endif ?>
                    
                    <?php if( $description ) : ?>
                        <p class="standard-grid-item-text"><?= esc_html( $description ) ?></p>
                    <?php endif ?>
                </div>
            <?php } ?>
        </div>
    <?php 
    } ?>
</div>