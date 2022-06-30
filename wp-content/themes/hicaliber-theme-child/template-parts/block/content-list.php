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
<section class="page-element default-width ethernet-feat">
    <div class="inner-section">
        <div class="grid-container">
            <div class="max-width--750">
                <h2 class="heading font-weight-normal"><?php echo $heading; ?></h2>
                <p><?php echo $sub_heading; ?></p>
            </div>
            <div class="row">
                <?php if(have_rows('list_repeater')):
                    while(have_rows('list_repeater')): the_row(); 
                    $icon = get_sub_field('icon');
                    $blurb = get_sub_field('blurb');

                    ?>
                <div class="col-lg-6">
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