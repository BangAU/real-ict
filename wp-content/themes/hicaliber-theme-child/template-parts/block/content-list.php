<?php
/**
 * Block Name: accordion-module
 *
 * This is the template that displays the feature module.
 */

// create id attribute for specific styling
$id = 'accordion-module-' . $block['id'];
$heading = get_field('heading');
$sub_heading = get_field('sub_heading');

?>
<section class="page-element default-width page-section ethernet-feat">
    <div class="inner-section">
        <div class="grid-container">
            <div class="max-width--750">
                <h2 class="heading font-weight-normal" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="400"><?php echo $heading; ?></h2>
                <p data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600"><?php echo $sub_heading; ?></p>
            </div>
            <div class="row">
                <?php 
                $time = 100;
                if(have_rows('list_repeater')):
                    while(have_rows('list_repeater')): the_row(); 
                    $icon = get_sub_field('icon');
                    $blurb = get_sub_field('blurb');
                    $time = $time + 300;
                    ?>
                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="<?php echo $time; ?>">
                    <div class="ethernet-feat__card">
                        <div class="ethernet-feat__card-icon">
                            <img src="<?php echo $icon['url'] ?>" alt="">
                        </div>
                        <p><?php echo $blurb; ?></p>
                    </div>
                </div>
                <?php 
                    endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</section>