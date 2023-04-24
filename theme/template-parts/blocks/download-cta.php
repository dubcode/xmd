<?php
if($download) { ?>
    <div class="download-call-to-action">
        <?php
        $imageType = $download['image_type'];

        if($imageType == 'font-awesome') { ?>
            <?= $download['font_awesome_icon']; ?>
        <?php } elseif($download['image']) { ?>
            <img class="download-cta-image" src="<?= $download['image']['url']; ?>" alt="<?= $download['image']['alt']; ?>" />
        <?php } 
        
        if($download['download_title']) {
        ?>
            <h5 class="download-cta-heading"><?= $download['download_title']; ?></h5>
        <?php
        }

        if($download['download_description']) { ?>
            <p class="download-cta-description"><?= $download['download_description']; ?></p>
        <?php }

        if($download['download_file']) { ?>
            <a class="download-cta-button" href="<?= $download['download_file']['url']; ?>">Download</a>
        <?php } ?>
    </div>
<?php }