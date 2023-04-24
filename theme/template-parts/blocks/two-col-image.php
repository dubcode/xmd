<div class="two-col-container <?php if(!$fullWidth) { echo 'container'; } ?>">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="two-col-column-1 <?php if($columnLayout == 'content-right') { echo 'two-col-order-2'; } else { echo 'two-col-order-1'; } ?>">
            <img class="two-col-image object-cover" src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>"/>
        </div>
    </div>
</div>