<?php
if( !isset($fullWidth) ) {
    $fullWidth = '';
}
?>
<?php if( is_woocommerce_activated() ) : ?>
    <div class="product_slider <?php if(!$fullWidth) { echo 'container'; } ?>">
        <?php if( is_product() ) : ?>
            <?php
            //single product
            global $product;

            if( get_field('related_products', $product->get_id() ) ) {
                $productGroup = get_field('related_products', $product->get_id());
            } else {
                $productGroup = get_field('related_products', 'option');
            }

            if( $productGroup['dynamically_populated'] ) {

                $product_cats_ids = wc_get_product_term_ids( $product->get_id(), 'product_cat' );

                $query = new WP_Query( 
                    array(
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => 4,
                        'tax_query'      => array( 
                            array(
                                'taxonomy'   => 'product_cat',
                                'field'      => 'term_id',
                                'terms'      => $product_cats_ids,
                            )
                        )
                    )
                );

                $products = $query->posts;
            } else {
                $products = $productGroup['related_products'];
            } ?>
        <?php else : ?>
            
            <?php //slider block
            $products = get_field('products');
            ?>
        
        <?php endif ?>
        
        <?php if ($products) :  ?>
            <?php foreach ($products as $product) : ?>
                <div class="product-card-spacer !flex justify-center h-full px-1.5">
                    <?php
                    //add our product layout
                    get_template_part(
                        'partials/card',
                        'product',
                        array(
                            'product_id' => $product->ID
                        )
                    );
                    ?>
                </div>
            <?php  endforeach ?>
        <?php endif; ?>
    </div>
<?php endif ?>