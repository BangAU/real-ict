<?php get_header(); ?>

<?php get_template_part('parts/content', 'hero-v2'); ?>

<?php if(function_exists('bcn_display')) : ?>
<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="cell small-12">
            <div class="breadcrumbs single-project-page" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php bcn_display(); ?>
            </div>
        </div>    
    </div>
</div>
<?php endif; ?>


<main id="main" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php

        $pv = new PROJECT_VIEW();

        $proj_featured_project = _get_field_value('proj_featured_project');
        $image_gallery = _get_field_value('proj_images');
        $video = _get_field_value('proj_video');
        $other_project = _get_field_value('proj_other_project');
        
        $proj_actions_main = _get_field_value('proj_actions_main');

    ?>
    
    <input type="hidden" id="projectName" value="<?php echo get_the_title(); ?>">

    <div class="page-elements">
    <?php
    if(_have_rows('pjgs_page_builder_elements', 'options')) : 

        while ( _have_rows('pjgs_page_builder_elements', 'options') ) : the_row();
            
            /**********************
            Element Builder
            ***********************/
            
            include( locate_template('project-module/views/content-'.get_row_layout().'.php', false, false ) ); 
            
        endwhile;
        
        
    else :
        // include( locate_template('project-module/views/content-description_&_gallery.php', false, false ) );
        // include( locate_template('project-module/views/content-tabbed_content.php', false, false ) );
        // include( locate_template('project-module/views/content-features.php', false, false ) );
        // include( locate_template('project-module/views/content-promotions.php', false, false ) );
        // include( locate_template('project-module/views/content-related.php', false, false ) );
        // include( locate_template('project-module/views/content-faq.php', false, false ) );
        // include( locate_template('project-module/views/content-testimonials.php', false, false ) );
        // include( locate_template('project-module/views/content-call_to_action.php', false, false ) );
    endif;
    ?> 
    </div>
    <?php endwhile; endif; ?>

</main>
                <!-- end #main -->

<!-- end #inner-content -->

<?php get_footer(); ?>
