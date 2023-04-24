<?php
/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ExtraMile_Theme_2023
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php emc_post_thumbnail(); ?>

	<div class="">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div>' . __( 'Pages:', 'extramile-theme-2023' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->