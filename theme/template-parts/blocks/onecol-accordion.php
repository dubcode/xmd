<?php
$accordions = get_field('accordions');
?>
<div class="accordion accordion-flush max-w-md-lg mx-auto" id="emc-accordion">
    <?php
    $i = 1;
    foreach($accordions as $accordion) {
        $accordionTitle = $accordion['accordion_title'];
        $accordionText = $accordion['accordion_text'];
    ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="emc-accordion-heading<?= $i; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emc-accordion-collapse-accordion-<?= $i; ?>"
                    aria-expanded="false" aria-controls="emc-accordion-collapse-accordion-<?= $i; ?>">
                    <?= $accordionTitle; ?>
                </button>
            </h2>
            <div id="emc-accordion-collapse-accordion-<?= $i; ?>" class="accordion-collapse"
            aria-labelledby="flush-heading<?= $i; ?>" data-bs-parent="#emc-accordion">
                <div class="accordion-body">
                    <div class="accordion-text written">
                        <?= $accordionText; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    $i++;
    } ?>
</div>