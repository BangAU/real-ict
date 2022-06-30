<?php
/*
Template Name: Page Content Builder
Template Post Type: location , page , project , events , ac-promotions , post , location_post, location_page, ac-properties, team, product, course, room-type
*/
?>

<?php get_header(); ?>
<?php get_template_part('parts/content', 'hero-v2'); ?>

<?php
    
    $classes = '';
 
      if(_get_field_value('page_sidebar')) {
            $classes .= 'has-sidebar';            
            $classes .= ' ' ._get_field_value('page_sidebar_location');            
        }
?>

<section class="body-content <?php echo $classes; ?>">
	<div class="inner-body-content">
		<?php echo child_menu(); ?>	
		<?php get_template_part('page-content-builder/hi', 'pcb'); ?>
	</div><!-- end .inner-body-content -->
</section> <!-- end .body-content -->


<?php get_footer(); ?>