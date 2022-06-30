<?php get_header(); ?>

<?php 
    // variable

    $tp_phone_number = _get_field_value('tp_phone_number');
    $tp_alternative_pnumber = _get_field_value('tp_alternate_number');
    $tp_email_address = _get_field_value('tp_email_address');
    $tp_sc_fb = _get_field_value('tp_facebook');
    $tp_sc_in = _get_field_value('tp_linkedin');
 ?>

<div class="s-container">

<section class="hero tall-banner page-banner ">

  
    <div class="inner-content">
        
        <?php 
        
            $bg_img  = (_get_field_value('tp_featured_image' )) ? hi_set_bg_img_raw(_get_field_value('tp_featured_image')) : hi_set_bg_img_raw(_get_field_value('subpage_hero_img', 'options')); 
        
        ?>

        <div class="bg-helper bg-image" <?php echo $bg_img; ?>>
            <div class="hero-bg-overlay" style="background-color:rgba(27,31,42,0.8);"></div>
        </div>
    
        <?php if( isset( $_GET['action'] ) && !empty( $_GET['action'] == 'apply' ) ) : ?>
            <div class="article-header">
                <h1 class="uppercase page-title">Application</h1>
            </div>
        <?php endif; ?>


          <?php if (have_posts()) : ?>

                 <div class="agent-sinlge-header">
            <div class="inner">
                <div class="v-align-container">
                    <div class="t-cell">
                         <div class="ash-container">
                            <div class="grid-container">
                                <div class="grid-x grid-padding-x">

           <?php while (have_posts()) : the_post(); 



                
                
                    $the_id = get_the_ID();
                    $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                
                                        
                    $user_data = get_userdata( $user_id );
                
                    $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                                    
                    $user_details = [];
                    
                    $user_details['manager_primary_phone'] = get_user_meta( $user_id, 'manager_primary_phone' , true );
                    if( isset($user_data->user_email) ){
                        $user_details['email'] = $user_data->user_email;
                    }
                    $user_details['manager_photo'] = get_user_meta( $user_id, 'manager_photo' , true );

                    if($user_details['manager_photo'] == null) {
                        $user_details['manager_photo'] =get_stylesheet_directory_uri() . "/assets/images/avatar_placeholder.jpeg";
                    }

                    $user_details['position'] = get_user_meta( $user_id, 'manager_position' , true );
                    $agent_address = get_post_meta( get_the_ID(), 'agent_address', true );

             
                ?>

                          
                             <div class="cell small-12 medium-5 adaptive">
                                    <div class="agent-avatar bg-helper" style="background-image:url(<?php echo _get_field_value('tp_profile_image'); ?>)">
                                 
                             </div>
                                </div>
                                <div class="cell small-12 medium-7 adaptive agent-details">

                                    <div class="v-align-container">
                                        <div class="t-cell">
                                                <div class="agent-name">
                                                     <?php echo get_the_title(); ?>
                                                 </div>
                                                 <div class="agent-position">
                                                     <?php echo _get_field_value('tp_job_title'); ?>
                                                 </div>
                                                 <div class="agent-address">
                                                     <?php echo _get_field_value('tp_address'); ?>
                                                 </div>
                                        </div>
                                    </div>
                                  
                                </div>

                <?php endwhile; else : ?>
            

                <?php endif; ?>

       
                             
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section> <!-- end .hero -->

    <div class="main-content">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">

                <main id="main" class="cell small-12 medium-8 first agent-bio-col" role="main">
                
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                    
                    
                        $the_id = get_the_ID();
                        $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                    
                                            
                        $user_data = get_userdata( $user_id );
                    
                        $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                    
                                        
                        $user_details = [];
                        $user_details['first_name'] = get_user_meta( $user_id, 'first_name' , true );
                        $user_details['last_name'] = get_user_meta( $user_id, 'last_name' , true );
                        $user_details['position'] = get_user_meta( $user_id, 'manager_position' , true );
                        $user_details['description'] = get_user_meta( $user_id, 'description' , true );
                        $user_details['manager_photo'] = get_user_meta( $user_id, 'manager_photo' , true );
                        
                        $user_details['manager_primary_phone'] = get_user_meta( $user_id, 'manager_primary_phone' , true );
                        if( isset($user_data->user_email) ){
                            $user_details['email'] = $user_data->user_email;
                        }
                        $user_details['manager_photo'] = get_user_meta( $user_id, 'manager_photo' , true );

                        if($user_details['manager_photo'] == null) {
                            $user_details['manager_photo'] =get_stylesheet_directory_uri() . "/assets/images/avatar_placeholder.jpeg";
                        }

                        $agent_address = get_post_meta( get_the_ID(), 'agent_address', true );

                
                    ?>
                    

                            
                            <div class="ob-wrap">
                                
                                <?php the_content(); ?>
                                <?php if($user_details['description']) : ?>
                                    <div class="agent-desc"><?php echo wpautop( $user_details['description']  );?> </div>
                                <?php endif; ?>
                            </div>
                                
                    
                                    
                                        
                    <?php endwhile; else : ?>
                
                        <?php get_template_part( 'parts/content', 'missing' ); ?>

                    <?php endif; ?>

                </main> <!-- end #main -->
                <div class="cell medium-4">
                    <h3 class=" secondary-text uppercase">Contact</h3>
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                    
                    
                        $the_id = get_the_ID();
                        $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                    
                                            
                        $user_data = get_userdata( $user_id );
                    
                        $user_id = get_post_meta( $the_id, 'manager_user_id', true );
                                        
                        $user_details = [];
                        
                        $user_details['manager_primary_phone'] = get_user_meta( $user_id, 'manager_primary_phone' , true );
                        if( isset($user_data->user_email) ){
                            $user_details['email'] = $user_data->user_email;
                        }
                        $user_details['manager_photo'] = get_user_meta( $user_id, 'manager_photo' , true );

                        $agent_address = get_post_meta( get_the_ID(), 'agent_address', true );

                
                    ?>

                            
                            <?php if($tp_phone_number) : ?>
                                <div class="agent-phone">
                                    <a href="tel:<?php echo str_replace(" ", "", $tp_phone_number); ?>"> <i class="accent-text fa fa-phone" aria-hidden="true"></i> <?php echo $tp_phone_number; ?></a>
                                </div>
                                <?php endif; ?>

                                <?php if($tp_alternative_pnumber) : ?>
                                <div class="agent-alternative-number">
                                    <a href="tel:<?php echo str_replace(" ", "", $tp_alternative_pnumber); ?>"> <i class="accent-text fa fa-phone" aria-hidden="true"></i> <?php echo $tp_alternative_pnumber; ?></a>
                                </div>
                                <?php endif; ?>

                                <?php if($tp_email_address) : ?>
                                <div class="agent-email">
                                    <a href="mailto:<?php echo $tp_email_address; ?>"><i class="accent-text fa fa-envelope" aria-hidden="true"></i>  <?php echo $tp_email_address; ?></a> 
                                </div>
                                <?php endif; ?>

                                <?php if($tp_sc_fb || $tp_sc_in) :  ?>
                                    <div class="tp-social-links">
                                        <?php if($tp_sc_fb) : ?>
                                            <a href="<?php echo $tp_sc_fb; ?>" class="tp-social-link" target="_blank"><i class="fab fa-facebook-square"></i></a> 
                                        <?php endif; ?>
                                        <?php if($tp_sc_in) : ?>
                                            <a href="<?php echo $tp_sc_in; ?>" class="tp-social-link" target="_blank"><i class="fab fa-linkedin"></i></a> 
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>


                    <?php endwhile; else : ?>
                

                    <?php endif; ?>

                </div>

          

            </div> <!-- end #inner-content -->

        </div> <!-- end #content -->
    </div>

</div>

     




</section>

<?php 
  
  if( _have_rows('ts_sp_global_elements', 'options') ) :
      while ( _have_rows('ts_sp_global_elements', 'options') ) : the_row();
              $elements['pe_g_select'] = _get_sub_field_value('pe_g_select');
              if($elements['pe_g_select'] || $elements['pe_g_select'] === "0")
                  include( locate_template('page-content-builder/elements/content-global_element.php', false, false ) );
      endwhile;
  endif;
  
?>
            
<?php get_footer(); ?>