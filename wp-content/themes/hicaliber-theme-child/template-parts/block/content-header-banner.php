<?php
/**
 * Block Name: accordion-module
 *
 * This is the template that displays the feature module.
 */

// create id attribute for specific styling
$heading = get_field('heading');
$blurb = get_field('blurb');
$sub_heading = get_field('sub_heading');
$booking_text = get_field('booking_text');
$button_link = get_field('button_link');
$image = get_field('image');

?>
<section class="hero gallery-background-banner default-height text-left">
    <div class="inner-hero">
        <div class="hero-main hero-carousel-type">
            <div class="hero-slider">
                <div class="bg-image"
                    style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/./images/woman-working-on-computer-in-office-2021-08-28-23-38-30-utc.svg)">

                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="cell">
                                <div class="hero-banner-message">
                                    <div class="grid-x">
                                        <div class="cell medium-6">
                                            <h2 class="heading">
                                                <?php echo $heading; ?>
                                            </h2>
                                            <h3 class="heading-xs color-theme">
                                                <h3 class="heading-xs color-theme"><?php echo $sub_heading; ?></h3>
                                            </h3>
                                            <p><?php echo $blurb; ?></p>
                                            <div class="hic-button-wrap">
                                                <a style="background: #00aeef; color: #fff;"
                                                    href="<?php echo $button_link['url'] ?>" class="button"
                                                    tabindex="0"><?php echo $button_link['title'] ?></a>

                                            </div>
                                        </div>
                                        <div class="cell medium-6"><img loading="lazy"
                                                class="alignnone size-full wp-image-3556"
                                                src="<?php echo $image['url'] ?>" alt="" width="1378" height="1162">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="hero-form">
            </div>

        </div>

    </div>
</section>