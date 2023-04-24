<?php
$name = isset( $args['name'] ) ? $args['name'] : '';
$id = isset( $args['id'] ) ? $args['id'] : '';
$class = isset( $args['class'] ) ? $args['class'] : '';
$options = isset( $args['options'] ) ? $args['options'] : '';
?>

<div class="emc-custom-select">
    <select name="<?= $name ?>" id="<?= $id ?>" class="<?= $class ?>">
        <?php if( !empty( $options ) ) :?>
            <?php foreach( $options as $option ) : ?>
                <option value="<?= $option['value'] ?>" <?= isset( $option['selected'] ) && !empty( $option['selected'] ) ? 'selected="selected"' : '' ?>><?= $option['label'] ?></option>
            <?php endforeach ?>
        <?php endif; ?>
    </select>
    <span class="focus"></span>
    <!-- <i class="far fa-chevron-down text-primary"></i> -->
</div>