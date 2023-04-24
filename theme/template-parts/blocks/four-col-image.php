<?php if($images) : ?>
    
    <div class="image-grid col-span-full grid grid-cols-2 lg:grid-cols-4">
        <?php foreach($images as $image) : ?>
            <?php $ctaImage = $image['image']; ?>
            <div class="four-col-image-call-to-action">
                <img class="four-col-image-call-to-action-image" src="<?= $ctaImage['url']; ?>" alt="<?= $ctaImage['alt']; ?>" />
            </div>
        
        <?php endforeach ?>
    </div>

<?php endif ?>