
<?php

/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
 * @package ExtraMile_Theme_2023
 */

$tags = get_the_tags();
?>

<article class="single-post-outer container" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="single-post-inner border-b border-grey-400">
	
		<div class="entry-content prose">

			<div class="entry-content-main written">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers. */
							__('Continue reading<span class="sr-only"> "%s"</span>', 'extramile-theme-2023'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				// wp_link_pages(
				// 	array(
				// 		'before' => '<div>' . __('Pages:', 'extramile-theme-2023'),
				// 		'after'  => '</div>',
				// 	)
				// );
				?>
			</div>

		</div><!-- .entry-content -->

	</div>

</article><!-- #post-${ID} -->

<?php // Display list of related team members 
$auto_relate_team_members = get_field( 'tm_auto_relate' );
if( $auto_relate_team_members ) : ?>

<?php else : ?>
	
	<?php $selected_team_members = get_field( 'tm_related_team_members' ); ?>

	<?php if( $selected_team_members ) : ?>

		<section class="related-team-members">
			
			<div class="four-col-grid">

				<?php foreach( $selected_team_members as $post ) : ?>
					<?php // Setup post for access to wp functions
					setup_postdata( $post ); ?>

					<?php
					// Setup $cta variable with required data
					// Then call the template partial
					$cta = array(
						// 'background'  => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
						'heading'     => get_the_title(),
						'description' => get_field( 'tm_job_title' ),
						'button' 	=> array(
							'url' 	=> get_post_permalink(),
							'title' => sprintf( __('Meet %s', EXTRAMILE_THEME_SLUG ), get_the_title() ),
						)
					);
					include __DIR__ . "../../blocks/cta.php";
					?>
				
				<?php endforeach ?>
			
			</div>

		</section>

	<?php endif ?>

	<?php 
    // Reset the global post object so that the rest of the page works correctly.
    wp_reset_postdata(); ?>

<?php endif ?>