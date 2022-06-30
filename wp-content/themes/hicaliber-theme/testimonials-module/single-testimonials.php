<?php get_header(); ?>
<?php
    $helper = new HI_TESTI_FUNCTIONS();
    $is_page_builder = get_field('testi_pcb', 'options');
    
?>

	
                <?php if($is_page_builder) : ?>

                	<div class="page-elements">

                    <div class="main-content">
                
                    <?php
                   
                   if(have_rows('testi_pcb', 'options')) : 
                    
                        echo '<div class="page-elements">';

                        while ( have_rows('testi_pcb', 'options'  ) ) : the_row();
                            
                            $get_row_layout = get_row_layout();


                            if($get_row_layout != 'global_element') :                            	
                                                                                
                                include(  'views/' . $get_row_layout .'.php');
                                                              
                            endif;
                            
                            
                        endwhile;
                        
                        echo '</div>';

                    endif; ?> 

                    </div>
                    </div>
                <?php else: ?> 
                    <?php $helper->single_default_template(); ?>


                <?php endif; ?>	

<?php
    if( have_rows('testi_pcb', 'options') ) : 
    
        echo '<div class="global-elements">';

        while ( have_rows('testi_pcb', 'options') ) : the_row();
            
            $get_row_layout = get_row_layout();


            if($get_row_layout == 'global_element') :
                
                include( locate_template('testimonials-module/views/content-'.get_row_layout().'.php', false, false ) ); 
            
            endif;
            
            
        endwhile;
        
        echo '</div>';

    endif;
    ?> 
<?php get_footer(); ?>