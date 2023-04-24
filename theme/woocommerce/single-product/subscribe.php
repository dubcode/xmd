<?php
global $product;
?>
<?php if( get_field( 'enable_subscribe_form', 'option' ) ) : ?>
	
	<section class="subscribe-block single-product-subscribe">

		<?php get_template_part( 'template-parts/blocks/subscribe', 'form' ); ?>

	</div>

<?php endif ?>