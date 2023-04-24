<?php
if (have_rows('social_media', 'option')) : ?>
    <div class="social-links">
        <ul>
            <?php while (have_rows('social_media', 'option')) : the_row(); 
                $socialType = get_sub_field('social_type');
                $link = get_sub_field('url');

                if($socialType == 'facebook') {
                    $icon = '<i class="fab fa-facebook"></i>';
                } elseif($socialType == 'twitter') {
                    $icon = '<i class="fab fa-twitter"></i>';
                } elseif($socialType == 'linkedin') {
                    $icon = '<i class="fab fa-linkedin-in"></i>';
                } elseif($socialType == 'instagram') {
                    $icon = '<i class="fab fa-instagram"></i>';
                }
                ?>
                <li class="social-icon"><a href="<?= $link; ?>" target="_blank"><?= $icon; ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif; 