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
                <h3 class="heading color-theme font-weight-light max-width--550 mx-auto" data-aos="fade-up"
                    data-aos-easing="linear" data-aos-duration="600"><?php echo $heading; ?>
                </h3>
                <div data-aos="fade-up" data-aos-easing="linear" data-aos-duration="800"><?php echo $blurb; ?></div>
                <h4 class="heading-xs color-theme " data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="1000"><?php echo $text; ?></h4>
            </div>
            <div class="max-width--1150 mx-auto" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1200">
                <img src="<?php echo $image['url'] ?>" alt="" class="w-100">
            </div>
        </div>
    </div>
</section>