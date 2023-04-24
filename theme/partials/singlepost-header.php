<?php $featured_img = get_the_post_thumbnail_url(get_the_ID(), 'full');?>
<header class="pt-40 <?php if(!empty($featured_img)) : ?>pb-60 <?php else: ?>pb-20<?php endif;?> single-post-header flex flex-col items-center text-center text-white">
	<?php
            

			//link back to category
			$category = get_the_category();
			$category_link = get_category_link($category[0]->cat_ID);
			if(!empty($category)) :
			echo '<p class="mt-2 lg:mt-20"><i class="fa fa-arrow-left"></i> <a href="'.$category_link.'" class="text-white hover:text-grey-800"> back to '.$category[0]->cat_name.'</a></p>';
			else :
				if (function_exists('yoast_breadcrumb')) {
					yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
				}
			endif;
        ?>
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="text-white heading-1 mt-8 max-w-2xl mb-8">', '</h1>' );
		else :
			the_title( '<h2 class="text-white heading-1 mt-8 mb-8"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :


			//get the post tags
			$tags = get_the_tags();
			//if the post has tags
			if ($tags) :
				echo '<div class="entry-meta text-white text-sm mt-8 mb-16">';
				foreach ($tags as $tag) :
					echo '<a href="' . get_tag_link($tag->term_id) . '" class="text-grey-700 text-sm bg-white px-5 py-2 m-1 inline-block">' . $tag->name . '</a>';
				endforeach;
				echo '</div>';
			endif;

			?>
			<?php /* 
			<div>
				<?php
				emc_posted_on();
				emc_posted_by();
				?>
			</div>
			*/?>
		<?php endif; ?>
	</header>