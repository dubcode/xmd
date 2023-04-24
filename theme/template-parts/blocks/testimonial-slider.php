<?php
$classes = isset( $args ) ? $args : [];
$testimonials = get_field('testimonials');
?>

<div class="testimonials-slider">
    <?php
    foreach($testimonials as $testimonial) { 
        $title = $testimonial->post_title;
        $content = get_field('testimonial_text', $testimonial->ID);
        $author = get_field('testimonial_author', $testimonial->ID);
        $company = get_field('testimonial_author_company', $testimonial->ID);
        $image = get_field('testimonial_author_image', $testimonial->ID);
        ?>   
        <div class="emc-inner-slider">
            <div class="emc-slider-content">
                <h2 class="slider-title <?= isset( $classes['text'] ) ? $classes['text']['headings'] : '' ?>"><?php echo $title; ?></h2>
                <div class="slider-text <?= isset( $classes['text'] ) ? $classes['text']['body'] : '' ?>"><?php echo $content; ?></div>
                <div class="author <?= isset( $classes['text'] ) ? $classes['text']['body'] : '' ?>">
                    <?= $author; ?> 
                    <?php 
                    if($company) {
                        echo ', ' . $company;
                    } ?>
                </div>

                <div class="testimonial-image">
                    <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" />
                </div>
            </div>
        </div>
    <?php
    } ?>  
</div>