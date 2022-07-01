<?php
/**
 * Block Name: accordion-module
 *
 * This is the template that displays the feature module.
 */

// create id attribute for specific styling
$id = 'accordion-module-' . $block['id'];
$heading = get_field('heading');
$blurb = get_field('blurb');
$sub_heading = get_field('sub_heading');
$image = get_field('image');
$shortcode = get_field('shortcode');
//test
?>

<section id="book-now" class="page-element default-width contact-eligibility">
    <div class="inner-section">
        <div class="grid-container">
            <div class="text-center max-width--750 mx-auto">
                <h3 class="heading-sm color-theme" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">
                    <?php echo $sub_heading; ?></h3>
                <h2 class="heading font-weight-normal" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="800"><?php echo $heading; ?></h2>
                <div data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000"><?php echo $blurb; ?></div>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1200">
                    <img src="<?php echo $image['url'] ?>" alt="" class="w-100">
                </div>
                <div class="col-lg-6">
                    <?php echo $shortcode; ?>
                </div>
            </div>
        </div>
    </div>
</section>