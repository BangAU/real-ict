<?php
/**
 * Block Name: text and image
 *
 * This is the template that displays the feature module.
 */

// create id attribute for specific styling
$heading = get_field('heading');
$blurb = get_field('blurb');
$text = get_field('text');
$image = get_field('image');

?>

<section class="page-element default-width enterprise-ethernet">
    <div class="inner-section">
        <div class="grid-container">
            <div class="text-center max-width--750 mx-auto">
                <h3 class="heading color-theme font-weight-light max-width--550 mx-auto"><?php echo $heading; ?>
                </h3>
                <p><?php echo $blurb; ?></p>
                <h4 class="heading-xs color-theme "><?php echo $text; ?></h4>
            </div>
            <div class="max-width--1150 mx-auto">
                <img src="<?php echo $image['url'] ?>" alt="" class="w-100">
            </div>
        </div>
    </div>
</section>