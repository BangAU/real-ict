<?php
    $hs = new hicaliber_theme_helpers;
    $pcb = new hcContentBuilder(); 
    
    $content = $elements['social_feeds_content'];
    
    $show_feed = $content['show_feed'];
    if($show_feed == 'all' || $show_feed == 'instagram'){
        $instagram = $content['instagram'];
    }
    if($show_feed == 'all' || $show_feed == 'facebook') {
        $facebook = $content['facebook'];
    }
    
    $arrangement = $content['arrangement'];
        
    $layout_flow = $content['layout_flow'];


    if($show_feed == 'all') {
         $container_size = $content['container_size'];
     } else {
         $container_size = '';
     }

   
    
    if($show_feed == 'all'){
        if($arrangement == "ig_fb"){
            $feed_type1 = 'instagram';
            $feed_type2 = 'facebook';
        } else {
            $feed_type1 = 'facebook';
            $feed_type2 = 'instagram';
        }
        
        if($layout_flow == 'column') {
            switch($container_size){
                case 'half':
                    $feeds = array(
                                array("type"=>$feed_type1, "size"=>"medium-6"),
                                array("type"=>$feed_type2, "size"=>"medium-6")
                            );
                    break;
                case '8x4':
                    $feeds = array(
                                array("type"=>$feed_type1, "size"=>"medium-8"),
                                array("type"=>$feed_type2, "size"=>"medium-4")
                            );
                    break;
                case '4x8':
                    $feeds = array(
                                array("type"=>$feed_type1, "size"=>"medium-4"),
                                array("type"=>$feed_type2, "size"=>"medium-8")
                            );
                    break;
            }
        } else{
            $feeds = array(
                            array("type"=>$feed_type1, "size"=>""),
                            array("type"=>$feed_type2, "size"=>"")
                        );
        }
    } else {
        if($show_feed == 'instagram'){
            $feeds = array(
                        array("type"=>'instagram', "size"=>"")
                    );
        }
        if($show_feed == 'facebook') {
            $feeds = array(
                        array("type"=>'facebook', "size"=>"")
                    );
        }
    }
    
    $design = $elements['social_feeds_design'];

    $section_css = "";

    $section_css = $hs::css_class_helper(
       [ 'page-element', 'social-feed-element', $container_size, $design['section_classes'], $design['theme'], $design['element_width'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
    );
?>

<section <?php hi_set_pageid($design['section_id']); ?> class="<?php echo $section_css; ?>">

    <?php echo $hs::design_background_image( $design['background_image'] ); ?>

	<div class="inner-section">
        <div class="grid-container">
            <?php $pcb->printHeader($elements['social_feeds_header']); ?>

            <div class="grid-x grid-padding-x section-body">
                    
                <?php
                    if ($feeds) :
                        foreach($feeds as $feed):
                ?>
                <div class="cell <?php echo $feed['size']?>">
                    <div class="social-feed-wrap <?php echo $feed['type']; ?>-feed">
                        <?php
                            if($feed['type']=='instagram') : 
                                if($instagram['title']) : 
                        ?>
                        <h4><?php echo $instagram['title']; ?></h4>
                        <?php 
                                endif; 
                            
                                if($instagram['blurb']) echo $instagram['blurb'];
                                
                                $feed_option = '';
                                if(!$instagram['use_default_access_token'] && $instagram['access_token']){
                                    $feed_option = ' accesstoken=' . $instagram['access_token'];
                                    
                                    if($instagram['display_by_user_id'] && $instagram['user_id'])
                                    $feed_option = ' id=' . $instagram['user_id'];
                                }
                                echo do_shortcode('[instagram-feed' . $feed_option . ']') ; 
                            endif;
                        ?>
                        
                        <?php
                            if($feed['type']=='facebook') : 
                                if($facebook['title']) : 
                        ?>
                        <h4><?php echo $facebook['title']; ?></h4>
                        <?php 
                                endif; 
                            
                                if($facebook['blurb']) echo $facebook['blurb'];
                                
                                $feed_option = '';
                                if(!$facebook['use_default_access_token'] && $facebook['access_token'])
                                    $feed_option = ' accesstoken=' . $facebook['access_token'];
                                
                                if(!$facebook['use_default_id'] && $facebook['user_id'])
                                    $feed_option = ' id=' . $facebook['user_id'];
                            
                                echo do_shortcode('[custom-facebook-feed' . $feed_option . ']') ; 
                            endif;
                        ?>
                    </div>
                </div>
                
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
	</div>
</section>