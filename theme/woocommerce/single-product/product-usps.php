<?php 
global $product;
$usps = get_field( 'usps', $product->get_id() );

if($usps) : ?>
    <ul class="product-usps sm:flex sm:flex-wrap sm:gap-5 xl:gap-8">
        <?php foreach($usps as $usp) : ?>
            <?php
            $imageType = $usp['usp_image_type'];
            $uspName = $usp['product_usp'];
            ?>
            <li class="product-usp flex mb-3 text-white uppercase">
                <?php if($imageType == 'fa') { 
                    echo $usp['fa_usp_image'];
                } else { ?>
                    <img class="product-usp-image" src="<?= $usp['usp_image']['url']; ?>" alt="<?= $usp['usp_image']['alt']; ?>" />
                <?php }

                echo '<span class="product-usp-text inline-block ml-5">' . $uspName . '</span>'; ?>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>