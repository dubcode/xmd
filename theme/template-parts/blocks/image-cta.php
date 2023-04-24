<?php if($cta) : ?>
    <?php if($cta['link']) : ?><a href="<?= $cta['link']; ?>"><?php endif ?>

    <?php if($cta['heading']) : ?>
      <div class="image-call-to-action">

          <?php
          $imageType = $cta['image_type'];

          if($imageType == 'font-awesome') { ?>
              <?= $cta['font_awesome_class']; ?>
          <?php } else if ($imageType == 'image') { ?>
              <img class="image-cta-image" src="<?= $cta['image']['sizes']['thumbnail']; ?>" alt="<?= $cta['image']['alt']; ?>" width="<?= $cta['image']['sizes']['thumbnail']; ?>" height="<?= $cta['image']['sizes']['thumbnail']; ?>" />
          <?php } else if ($imageType == 'team') { ?>
              <img class="image-cta-image" src="<?= $cta['image']['sizes']['medium']; ?>" alt="<?= $cta['image']['alt']; ?>" width="<?= $cta['image']['sizes']['medium']; ?>" height="<?= $cta['image']['sizes']['medium']; ?>" />
          <?php } else if ($imageType == 'fs-image') { ?>
              <img class="image-cta-image" src="<?= $cta['image']['sizes']['medium']; ?>" alt="<?= $cta['image']['alt']; ?>" width="<?= $cta['image']['sizes']['medium']; ?>" height="<?= $cta['image']['sizes']['medium']; ?>" />
          <?php } else { ?>
               <div class="image-cta-number">
                <span>
                  <?= $cta['number_label']; ?>
                </span>
              </div>
          <?php } ?>

          <h3 class="heading-5 text-center"><?= $cta['heading']; ?></h3>
          <?php
          $imageExcerpt = $cta['excerpt'];
          if($imageExcerpt):
          ?>
            <p class="text-center"><?= $cta['excerpt']; ?></p>
          <?php endif ?>

          <?php
          $imageContact = $cta['contact_details'];
          if($imageContact):
          ?>
            <div class="three-col-contact-details"><?= $cta['contact_details']; ?></div>
          <?php endif ?>

          <?php
          $imageCtaLinkText = $cta['link_text'];
          if($imageCtaLinkText):
          ?>
            <span class="image-cta-button"><?= $cta['link_text']; ?></span>
          <?php endif ?>

      </div>
    <?php endif ?>

    <?php if( ! empty( $cta['link'] ) ) : ?></a><?php endif ?>
<?php endif ?>