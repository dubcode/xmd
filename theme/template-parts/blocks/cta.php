<?php if($cta) : ?>
    <?php $bg = ( isset( $cta['background'] ) && is_string( $cta['background'] ) ? $cta['background'] : ( isset( $cta['background']) && is_array( $cta['background'] ) ? $cta['background']['sizes']['medium'] : '' ) ); ?>
    
    <div class="custom-call-to-action-outer <?= $bg ? 'has-background-image' : '' ?>" style="<?= $bg ? 'background-image: url('. $bg .')' : '' ?>">
    
        <div class="custom-call-to-action" >
            <?php if($cta['heading']) { ?>
                <h3 class="cta-heading"><?= $cta['heading']; ?></h3>
            <?php }
            if($cta['description']) { ?>
                <p class="cta-text"><?= $cta['description']; ?></p>
            <?php }
            if($cta['button']) { ?>
                <a class="cta-button" href="<?= $cta['button']['url']; ?>"><?= $cta['button']['title']; ?></a>
            <?php } ?>
        </div>

    </div>
<?php endif ?>