<?php
$post_id = isset( $args['post_id'] ) ? $args['post_id'] : null;
$tags = get_the_tags( $post_id );
?>

<?php if( $tags ) : ?>
    <div class="post-tag-container">
        <ul class="post-tags flex flex-wrap justify-center gap-x-3 gap-y-2">
            <?php foreach( $tags as $tag ) : ?>
                <li class="post-tag">
                    <a class="category-label min-w-[5.75rem] text-center bg-white text-grey-700 hover:text-white" href="<?= get_term_link( $tag ) ?>"><?= $tag->name ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>