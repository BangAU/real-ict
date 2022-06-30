<?php
    $pcb = new hcContentBuilder(); 

    $content_boxes_display = $elements['content_boxes_layout'];

    $PCBCB = new hcPCBContent();

    $PCBCB->addDefaultSectionClasses($content_boxes_display['content_boxes_display']);
    $pcb->setContentType($PCBCB);

    if($content_boxes_display['layout_type'] == 'tabs') {
         $pcb->addClassesTo('section', ['tab-layout']);    
    } else {
        $pcb->addClassesTo('section', [$content_boxes_display['layout_type']]);    
    }
    
    if( isset( $content_boxes_display['grid_layout'] ) ) {
        if( $content_boxes_display['layout_type'] == 'grid' ) {
            $pcb->addClassesTo('section', [$content_boxes_display['grid_layout']]);
        }
    }

    $addvideo_class = '';

    if( isset( $value['content_box_video'] ) ) {
        $addvideo_class = 'has-video';
    }

    $pcb->setSettings($elements['content_boxes_design']);

    $pcb->setData('item-col', $content_boxes_display['per_row']);


    if( $content_boxes_display['layout_type'] == 'carousel' && isset( $content_boxes_display['slider_autoplay'] ) ) {
         $pcb->setData('autoplay', 1);
    }
    if( $content_boxes_display['layout_type'] == 'carousel' && isset( $content_boxes_display['slider_autoplay'] ) ) {
         $pcb->setData('autoplay-speed', $content_boxes_display['slider_speed']);
    }

    $pcb->setHeader($elements['content_boxes_header']);
    $pcb->setFooter($elements['content_boxes_footer']); 


      // Check for Overrides 
    global $builder_index;
    $enable_override = false;

    if(!is_null($builder_index)):
        $enable_override = get_field("page_content_builder_{$builder_index}_ge_advance_settings_enable_override");

        if($enable_override):

                //overrides
                $adv_layout = get_field("page_content_builder_{$builder_index}_ge_advance_settings_layout");
                $adv_header = get_field("page_content_builder_{$builder_index}_ge_advance_settings_header");
                $adv_footer = get_field("page_content_builder_{$builder_index}_ge_advance_settings_footer");
                $adv_design = get_field("page_content_builder_{$builder_index}_ge_advance_settings_design");

                $pcb = new hcContentBuilder(); 

                $content_boxes_display = $adv_layout["content_boxes_layout"]; //override

                $PCBCB = new hcPCBContent();

                $PCBCB->addDefaultSectionClasses($content_boxes_display['content_boxes_display']);
                $pcb->setContentType($PCBCB);

                if($content_boxes_display['layout_type'] == 'tabs') {
                     $pcb->addClassesTo('section', ['tab-layout']);    
                } else {
                    $pcb->addClassesTo('section', [$content_boxes_display['layout_type']]);    
                }
                
                if( isset( $content_boxes_display['grid_layout'] ) ) {
                    if( $content_boxes_display['layout_type'] == 'grid' ) {
                        $pcb->addClassesTo('section', [$content_boxes_display['grid_layout']]);
                    }
                }

                $addvideo_class = '';

                if( isset( $value['content_box_video'] ) ) {
                    $addvideo_class = 'has-video';
                }

                $pcb->setSettings($adv_design["content_boxes_design"]); //override

                $pcb->setData('item-col', $content_boxes_display['per_row']);


                if( $content_boxes_display['layout_type'] == 'carousel' && isset( $content_boxes_display['slider_autoplay'] ) ) {
                     $pcb->setData('autoplay', 1);
                }
                if( $content_boxes_display['layout_type'] == 'carousel' && isset( $content_boxes_display['slider_autoplay'] ) ) {
                     $pcb->setData('autoplay-speed', $content_boxes_display['slider_speed']);
                }

                $pcb->setHeader($adv_header['content_boxes_header']);
                $pcb->setFooter($adv_footer['content_boxes_footer']); 

        endif; //End override check
    endif; //End builder index check
    
    
    if($content_boxes_display['layout_type'] == 'tabs') { ?>
                
    <?php
        
        $html = '';
        $html .= '<div class="grid-x grid-padding-x section-body">';
        $html .= '<div class="cell">';
            if( $elements['content_boxes_content'] ) : 
                $html .= '<div class="tab-container show-for-large"><ul class="tabs" data-tabs id="cb-tabs">';
                foreach ($elements['content_boxes_content'] as $key => $value) :
                    $set_active = ($key == 0) ? ' is-active' : '';
                    $used_icon = $value['use_image_icon'];
                    $icon = $value['content_box_image_icon'];
                    $set_tab_icon = '';
                    $tab_title_class = '';
                    if($used_icon && $icon) {
                        $set_tab_icon = '<img class="tab-icon" src="'.$icon.'" alt="'.$value['content_box_title'].'">';
                        $tab_title_class = ' has-icon';
                    }
                    $tab_key = str_replace(' ', '-', strtolower($value['content_box_title']));
                    $tab_key = hi_remove_string_special_char($tab_key);
                    $html .= '<li class="tabs-title'.$tab_title_class.$set_active.'"><a href="#panel-'.$tab_key.'-'.$key.'" aria-selected="true">'.$set_tab_icon.$value['content_box_title'].'</a></li>';        
                endforeach;
                $html .= '</ul>';
                
                $html .= '<div class="tabs-content" data-tabs-content="cb-tabs">';
                    foreach ($elements['content_boxes_content'] as $key => $value) :

                        $hicBox = new hcPCBContent();
                        $set_active = ($key == 0) ? ' is-active' : '';
                        $tab_key = str_replace(' ', '-', strtolower($value['content_box_title']));
                        $tab_key = hi_remove_string_special_char($tab_key);
                    $html .= '<div class="tabs-panel'.$set_active.'" id="panel-'.$tab_key.'-'.$key.'">';
                    $html .= $value['content_box_blurb'];

                        if($value['content_box_link_type'] != 'none') {
                            if($value['content_box_button']['button_target'] == 'link' && $value['content_box_button']['link']) {
                                $link_target = ($value['content_box_button']['link']['target']) ? $value['content_box_button']['link']['target'] : '_self';
                                $link_label = ($value['content_box_button']['link']['title']) ? $value['content_box_button']['link']['title'] : 'View';
                                $html .= '<a href="'.$value['content_box_button']['link']['url'].'" class="button" target="'.$link_target.'">'.$link_label.'</a>';    
                            }
                            if($value['content_box_button']['button_target'] == 'modal') {
                                $button_label = ($value['content_box_button']['modal']['title']) ? $value['content_box_button']['modal']['title'] : 'View';
                               $html .= '<button data-open="'.$value['content_box_button']['modal']['data_open'].'" class="button">'.$button_label.'</button>';     
                            }
                            
                        }
                    
                  $html .= '</div>';
                 endforeach;
                $html .= '</div></div>';
                
            endif;

            if( $elements['content_boxes_content'] ) : 
                $html .= '<div class="accordion-container hide-for-large"><ul class="accordion" data-accordion  data-allow-all-closed="true">';
                foreach ($elements['content_boxes_content'] as $key => $value) :
                 $html .= '<li class="accordion-item" data-accordion-item>';                            
                            $html .= '<a href="#" class="accordion-title">'.$value['content_box_title'].'</a>';
                            
                           $html .= '<div class="accordion-content" data-tab-content>';
                              $html .= $value['content_box_blurb'];  
                               if($value['content_box_link_type'] != 'none') {
                                    if($value['content_box_button']['button_target'] == 'link' && $value['content_box_button']['link'] ) {
                                        $link_target = $value['content_box_button']['link']['target'] ? $value['content_box_button']['link']['target'] : '_self';
                                        $link_label = $value['content_box_button']['link']['title'] ? $value['content_box_button']['link']['title'] : 'View';
                                        $html .= '<a href="'.$value['content_box_button']['link']['url'].'" class="button" target="'.$link_target.'">'.$link_label.'</a>';    
                                    }
                                    if($value['content_box_button']['button_target'] == 'modal') {
                                        $button_label = $value['content_box_button']['modal']['title'] ? $value['content_box_button']['modal']['title'] : 'View';
                                       $html .= '<button data-open="'.$value['content_box_button']['modal']['data_open'].'" class="button">'.$button_label.'</button>';     
                                    }
                                    
                                }                         
                            $html .= '</div>';
                        $html .= '</li>';
                endforeach;
                $html .= '</ul></div>';
                
            endif;


        $html .= '</div>';


        

    


        $html .= '</div>';
        
        $pcb->displaySectionTabs($html);
            
    } else {
        if( $elements['content_boxes_content'] ) : 
            foreach ($elements['content_boxes_content'] as $key => $value) :
    
                $hicBox = new hcPCBContent();

                $button_type_class = '';
                if($value['content_box_link_type'] != 'none' && $value['content_box_button']) {
                   $button_type_class = $value['content_box_link_type'].'-link';
                }
                $hicBox->setClassesOf('hic-box-container', [$content_boxes_display['per_row'],$value['content_box_custom_css'],$button_type_class] );
                $hicBox->setTitle( $value['content_box_title'] );
                $hicBox->setContent( $value['content_box_blurb'] );

                $hicBox->setMediaType(  $value['media'] );
		
                switch($value["media"]){
                    case "video":
                        $hicBox->setImage(new hcPCBLink( $value['content_box_image'] ));
                        $hicBox->setVideo2( new hcPCBLink( $value['content_box_video'] ) ); 
                    break;
                    case "image":
                        $hicBox->setImage(new hcPCBLink( $value['content_box_image'] ));
                    break;
                    case "gallery":
                        $hicBox->setGallery( $value['gallery'] );  
                    break;
                }
                        
		
                $hicBox->setUseImageIcon($value['use_image_icon']);
                if($value['use_image_icon']) $hicBox->setImageIcon(new hcPCBLink(  $value['content_box_image_icon'] ));
                else $hicBox->setIcon( $value['content_box_icon'] );
                
    
                if($value['content_box_link_type'] != 'none' && $value['content_box_button']) {
                    if($value['content_box_button']['button_target'] == 'modal'){
                        $button = new hcPCBButtonElement($value['content_box_button']['modal']);
                        if($value['content_box_link_type'] == 'box') $button->setIsBoxLink(true);
                        if($value['content_box_link_type'] == 'text') $button->setLinkOnly(true);
                        $hicBox->setButton($button);
                    } else 
                        if($value['content_box_button']['link']){
                            $button = new hcPCBButtonElement($value['content_box_button']['link']);
                            if($value['content_box_link_type'] == 'box') $button->setIsBoxLink(true);
                            if($value['content_box_link_type'] == 'text') $button->setLinkOnly(true);
                            $hicBox->setButton($button);
                        }
                }
                
              
		
                $hicBox->setBoxID($value['content_box_id']);
				
			
                
                
                //$hicBox->setClassesOf('hic-box', [ $value['content_box_custom_css'], $button_type_class ] );
                
                $pcb->setContentBox($hicBox);
                
            endforeach;
    
        endif; 

            $pcb->displaySection();
    }