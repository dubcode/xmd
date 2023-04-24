<div class="grid <?= $grid; ?>">
    <?php for( $i=1; $i < $gridCount+1; $i++ ) : ?>
        <div class="flexible-grid-inner">
            <?php
            //get our column info
            $column = get_field('column_' . $i);
            //get our grid items
            $grids = $column['flexible_grid'];

            foreach($grids as $grid) : ?>
                <?php
                $gridSize = $grid['item_size'];
                $heading = $grid['heading'];
                $description = $grid['description'];
                $button = $grid['button'];
                $backgroundImage = !empty($grid['background_image']) ? $grid['background_image']['sizes']['medium'] : '';
                $colSize = 'flexible-grid-small';

                if($gridSize == 'small') {
                    $colSize = count($grids) <= 2 ? 'flexible-grid-small lg:col-span-2' : 'flexible-grid-small';
                    $headerPadding = 'heading-small';
                } else {
                    $colSize = 'flexible-grid-large';
                    $headerPadding = 'heading-large';
                } ?>

                <div class="flexible-grid-item-outer <?= $colSize; ?>" style="<?= 'background-image: url(' . $backgroundImage . ')' ?>">
                    <div class="flexible-grid-item bg-gradient-to-t from-primary">
                        <?php
                        if($heading) {
                            echo '<h3 class="flexible-grid-item-header ' . $headerPadding . '">' . $heading . '</h3>';
                        }
                        if($description) {
                            echo '<p class="flexible-grid-item-text">' . $description . '</p>';
                        }
                        if($button) {
                            echo '<a class="flexible-grid-item-button" href="' . $button['url'] . '">' . $button['title'] . '</a>';
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endfor ?>
</div>