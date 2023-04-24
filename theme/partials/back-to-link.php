<?php
$posts_page_id = isset( $args['posts_page_id'] ) ? $args['posts_page_id'] : null;
$post_id = isset( $args['post_id'] ) ? $args['post_id'] : null;
?>
<div class="back-to-container flex justify-center">
    <a href="<?= get_post_type_archive_link( get_post_type( $post_id ) ) ?>" class="text-grey-100 hover:text-primary"><?= sprintf( __('Back to %s'), get_the_title( $posts_page_id ) ) ?></a>
</div>