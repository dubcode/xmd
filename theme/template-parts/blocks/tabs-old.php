<?php
if($tabs) { ?>
    <ul class="nav emc-tabs" id="emc-tabs" role="tablist">
        <?php
        $i = 1;
        foreach($tabs as $tab) { ?>
            <li class="emc-tab-item" role="presentation">
                <a href="#emc-tab-<?= $i; ?>-content" class="emc-tab-link <?php if($i == 1) { echo 'active'; } ?>" id="emc-tab-<?= $i; ?>" data-bs-toggle="pill" data-bs-target="#emc-tab-<?= $i; ?>-content" role="tab"
                    aria-controls="tabs-tab<?= $i; ?>Justify" aria-selected="<?php if($i == 1) { echo 'true'; } else { echo 'false'; } ?>">
                    <?= $tab->post_title; ?>
                </a>
            </li>
        <?php 
        $i++;
        } ?>
    </ul>

    <div class="emc-tab-content tab-content" id="tabs-tabContentJustify">
        <?php
        $i = 1;
        foreach($tabs as $tab) { ?>
            <div class="tab-pane fade <?php if($i == 1) { echo 'show active'; } ?>" id="emc-tab-<?= $i; ?>-content" role="tabpanel"
                aria-labelledby="emc-tab-<?= $i; ?>-content">
                    <?php
                    $blocks = parse_blocks( $tab->post_content );

                    foreach( $blocks as $block ) {
                        echo render_block( $block );
                    }
                    ?>
            </div>
        <?php 
        $i++;
        } ?>
    </div>
<?php
}
