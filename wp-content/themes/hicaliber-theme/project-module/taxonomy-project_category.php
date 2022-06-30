<?php
/*
This is the custom post type taxonomy template.
If you edit the custom taxonomy name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom taxonomy is called
register_taxonomy( 'shoes',
then your single template should be
taxonomy-shoes.php
*/

$cat_page_options = _get_field_value('pjgs_category_page_options', 'options');
$is_cat_page_enabled = isset($cat_page_options['is_cat_page_enabled']) ? $cat_page_options['is_cat_page_enabled'] : true;

if( !$is_cat_page_enabled && is_tax('project_cat') ){
	wp_redirect( home_url(), 301 ); exit;
}

$term = get_queried_object();

$cat_featured_project = _get_field_value('cat_featured_project' , $term);
$cat_other_project = _get_field_value('cat_other_project', $term );            


$f = new PROJECT_HELPER();
$h = new PROJECT_VIEW();

$featured = $f::get_project( 'featured' , $term->slug , $cat_featured_project );

$other = $f::get_project( 'other' , $term->slug , $cat_other_project );

$banner_options = _get_field_value('pct_banner_option','options');


?>


<?php get_header(); ?>

<?php get_template_part('project-module/parts/content', 'cat-hero'); ?>


    <?php if(function_exists('bcn_display')) : ?>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell small-12">
                <div class="breadcrumbs single-product-page" typeof="BreadcrumbList" vocab="https://schema.org/">
                    <?php bcn_display(); ?>
                </div>
            </div>    
        </div>
    </div>
    <?php endif; ?>


    <?php if(!$banner_options['show_page_banner']) : ?>

        <div class="page-banner">
        <div class="grid-container">
             <div class="grid-x grid-padding-x">
                <div class="cell">
                    <h1 class="product-name"><?php echo $term->name; ?></h1>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php 
        $show_cp_sidebar = false;
        $show_project_sidebar = _get_field_value('show_project_sidebar','options');
        $sidebar_location = _get_field_value('project_sidebar_location','options');
        if( is_array($sidebar_location) ) extract( $sidebar_location );
        if( $show_project_sidebar && $show_cp_sidebar ) :
            $class = 'has-sidebar';
        else : $class = '';
        endif;

     ?>
 

    <div class="<?php echo $show_project_sidebar && $show_cp_sidebar ? "grid-x grid-padding-x" : "page-elements"; ?> <?php echo $class; ?>">
      
    <?php    
        if( $show_project_sidebar && $show_cp_sidebar ) : 
    ?>
    <div class="cell sidebar">
        <div class="page-element">
                <div class="inner-sidebar">
                    <?php //get_product_sidebar(); ?>    
                </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if( $show_project_sidebar && $show_cp_sidebar ) : ?>
    <div class="cell page-elements">
    <?php endif; ?>
   

    <?php
        if(_have_rows('project_cat_element_builder', 'options')) :  ?>

            <?php


            while ( _have_rows('project_cat_element_builder', 'options') ) : the_row();
                /**********************
                Element Builder
                ***********************/
                if(get_row_layout() == 'global_element') {
                    include( locate_template('project-module/views/content-cat-'.get_row_layout().'.php', false, false ) ); 
                } else {
                    include( locate_template('project-module/views/content-cat-'.get_row_layout().'.php', false, false ) );  
                }
                
            endwhile;
            
            

        endif;
    ?> 
    <?php if( $show_project_sidebar && $show_cp_sidebar ) : ?>
     </div>
    <?php endif; ?>
    </div>



<?php get_footer(); ?>