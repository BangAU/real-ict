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
$image_alignment = get_field('image_alignment');
$image = get_field('image');
if( $image_alignment == 'left' ) {
?>
<section class="page-element default-width keep-pace">
    <div class="inner-section">
        <div class="grid-container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="heading" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">
                        <?php echo $heading; ?></h2>
                    <h3 class="heading-xs color-theme" data-aos="fade-up" data-aos-easing="linear"
                        data-aos-duration="800"><?php echo $sub_heading; ?></h3>
                    <div data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000"> <?php echo $blurb; ?>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="600">
                    <img src="<?php echo $image['url'] ?>" alt="" class="w-100">
                </div>
            </div>
        </div>
    </div>
</section>
<?php } elseif ($image_alignment == 'right') {  ?>

<section class="page-element default-width">
    <div class="inner-section">
        <div class="grid-container">
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="600">
                    <img src="<?php echo $image['url'] ?>" alt="" class="w-100">
                </div>
                <div class="col-lg-6">
                    <h2 class="heading" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="800">
                        <?php echo $heading; ?></h2>
                    <h3 class="heading-xs color-theme" data-aos="fade-up" data-aos-easing="linear"
                        data-aos-duration="1000"><?php echo $sub_heading; ?></h3>
                    <div data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1200"> <?php echo $blurb; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>