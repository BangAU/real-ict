<?php

class PROJECT_VIEW {
    
    public static function td_meta( $label="", $data , $suffix = "", $id="", $class="", $datas="" ){

        $html = "";

        if( $data ) {
            $html .= "<tr".($id ? " id='".$id."'" : "").($class ? " class='".$class."'" : "").">";
                $html .= "<td class='td-label'>".$label."</td>";
                $html .= "<td class='td-value" . ($datas ? " data-variable-container" : "") . "'" . ($datas ? " ". $datas : "") . ">".$data.$suffix."</td>";
            $html .= "</tr>";
        }

        echo $html;
    }

	public static function set_image( $img ){
		
		if( $img ){
			return 'style="background-image:url('.$img.')"';
		}
		
	}

    /**************************************************
     * Range Template listed on Category Page
     *************************************************/

     public static function project_range_template( $range , $type = "minimal" ){
        
        $css = "small-12 medium-4 large-3";
        $desc_align = "text-center";
        $term = get_queried_object();
        if( $type == "minimal" ) {
            $css = "small-12 medium-6";
            $desc_align = "";
        }

        $html = "<div class='row row-flex featured-slider'>";
        if( $range ) { 
            foreach( $range as $data) {
                $front_desc = "";
                
                $html .= "<div class='columns ".$css."'>";
                    $html .= "<a class='link range-link' href='".$data['link']."'>";
                    if( get_featured_image($data['id']) && $type != 'minimal' ) {
                        $html .= "<div class='bg-helper range-img' style='background-image:url(".get_featured_image($data['id']).")'>";
                        
                        $html .= "</div>";
                    }
                    
                    $html .= "<div class='". $desc_align." adaptive range-content'>";
                    
                        $html .= "<h5>".$data['title']."</h5>";
                        
                        if( has_excerpt( $data['id'] ) ) {
                            $front_desc = $data['excerpt'];
                        } else {
                            $front_desc = wp_trim_words( $data['description'] , 20, "..." );
                        }
                        $html .= "<div class='desc'>".$front_desc."</div>";
                    
                    $html .= "</div>";

                    $html .= "</a>";
                $html .= "</div>";
            }
        }
        $html .= "</div>";
        return $html;
    }
    
    public static function project_range_template_other( $range , $type = "minimal" ){
        
        $css = "small-12 medium-4 large-3";
        $desc_align = "text-center";
        $term = get_queried_object();
        if( $type == "minimal" ) {
            $css = "small-12 medium-6";
            $desc_align = "";
        }

        $html = "<div class='row row-flex flex'>";
        if( $range ) { 
            foreach( $range as $data ) {
           
                  
                $front_desc = "";

                $html .= "<div class='columns large-6'>";
                    $html .= "<div class='other-range-content'><a class='link range-link' href='".$data['link']."'>";
                        $html .= "<div class='clearfix flex'>";
                            if( get_featured_image($data['id']) ) {
                                $html .= "<div class='medium-3 columns no-pad-l'><div class='bg-helper range-img' style='background-image:url(".get_featured_image($data['id']).")'></div></div>";
                            }
                            
                            $html .= "<div class='". $desc_align." range-content medium-9 columns'>";
                                $html .= "<div>";
                                    $html .= "<h5>".$data['title']."</h5>";
                                    
                                    if( has_excerpt( $data['id'] ) ) {
                                        $front_desc = wp_trim_words( $data['excerpt'] , 10, ".." );
                                    } else {
                                        $front_desc = wp_trim_words( $data['description'] , 10, ".." );
                                    }
                                    $html .= "<div class='desc'>".$front_desc."</div>";
                                $html .= "</div>";
                            $html .= "</div>";
                            //$html .= "<div class='medium-3 columns no-pad-r'><div class='other-view'><span>View</span></div></div>";
                        $html .= "</div>";
                    $html .= "</a></div>";
                $html .= "</div>";
            }
        }
        $html .= "</div>";
        return $html;
    }

    /**************************************************
     * Video and Gallery Content
     *************************************************/

    public static function gallery( $gallery = "" , $video = "", $gallery_option="", $display_view_all_button=true){
        $html = ""; 

        $has_lightbox = false;
        $has_thumbnails = false;
        $thumb_to_show = 3;
        $thumb_arrows = true;
        $thumb_dots = false;
        $thumb_center_mode = true;

        $gallery_type = isset($gallery_option['gallery_type']) ? $gallery_option['gallery_type'] : 'slider';
        if($gallery_type && isset($gallery_option['thumbnails'])){
            if($gallery_option['thumbnails'] && $gallery_type == 'slider') $has_thumbnails = true;
        }
        if(isset($gallery_option['lightbox'])){
            if($gallery_option['lightbox']) $has_lightbox = true;
        }
        if(isset($gallery_option['thumb_to_show'])){
            $thumb_to_show = $gallery_option['thumb_to_show'];
        }
        if(isset($gallery_option['thumb_arrows'])){
            $thumb_arrows = $gallery_option['thumb_arrows'];
        }
        if(isset($gallery_option['thumb_dots'])){
            $thumb_dots = $gallery_option['thumb_dots'];
        }
        if(isset($gallery_option['thumb_center_mode'])){
            $thumb_center_mode = $gallery_option['thumb_center_mode'];
        }

        if( $gallery ){
            $html .= "<div class='" . ($gallery_type == 'grid' ? "grid-x grid-padding-x flex " : "") . "image-" . $gallery_type . ($has_lightbox ? " with-lightbox" : "") . ($has_thumbnails ? " with-thumbnails" : "") . "'>";
                foreach( $gallery as $img ) {
                    if($gallery_type == 'grid'){
                        $per_row = isset($gallery_option['per_row']) ? $gallery_option['per_row'] : 'medium-6 large-4';
                        $html .= "<div class='cell " . $per_row . "'>";
                        if($has_lightbox) {
                            $html .= "<a href='" . $img['url'] . "' data-thumb='" . $img['url'] . "' data-fancybox='gallery'>";
                        }

                        $html .= '<div class="hic-image-container">';
                        // $html .= '<div class="img-st bg-helper" style="background-image: url('.$img['url'].');"></div>';
                        $html .= '<div class="hic-image" style="background-image:url('.$img['url'].');"></div>';
                        $html .= '</div>';

                        if($has_lightbox) {
                            $html .= "</a>";
                        }
                        $html .= "</div>";
                    }else{
                        if($has_lightbox) {
                            $html .= "<a href='" . $img['url'] . "' rel='lightbox'" . (!$img['caption'] ? " onmouseover='this.title=\"\"'" : " ") . " title='" . ($img['caption'] ? $img['caption'] : $img['filename']) . "'>";
                        }

                        $html .= '<div><div class="image-container">';
                        $html .= '<div class="img-st bg-helper" style="background-image: url('.$img['url'].');"></div>';
                        // $html .= '<div src="'.$img['url'].'"/>';
                        $html .= '</div></div>';

                        if($has_lightbox) {
                            $html .= "</a>";
                        }
                    }
                } 
            $html .= "</div>";
        }

        if($has_thumbnails && is_array($gallery) ? count($gallery) > 1 : false ){
            
            $html .= '<div class="project_gallery_thumb_slider thumb-slide" data-slider-layout=""';
            $html .= ' data-slides-to-show="' . $thumb_to_show . '"';
            $html .= ' data-arrows="' . ($thumb_arrows ? "true" : "false") . '"';
            $html .= ' data-dots="' . ($thumb_dots ? "true" : "false"). '"';
            $html .= ' data-center-mode="' . ($thumb_center_mode ? "true" : "false"). '"';
            $html .= '>';
                foreach( $gallery as $image ){
                    
                    $html .= '<div class="bg-helper thumb-slide-image" style="background-image: url(' . $image['url'] . ');"></div>';

                }
            $html .= '</div>';
        }

        if($has_lightbox && $gallery_type == 'slider' && $display_view_all_button){
            $html .= '<div class="hic-button-wrapper inner-element button-trigger-lightbox show-for-medium text-center">';
                $button = new hcPCBButtonElement();
                $button->constructButton('#', 'View all');
                $button->toggleClasses(['dark-button', 'small-button', 'btn-open-lightbox']);
                $button->generateButtonElement();
                $html .= $button->getButtonElement();
            $html .= '</div>';
        }
       
        return $html;
    }
    
    /**************************************************
     * Parent : Project Listing
     *************************************************/
     public static function generate_projects_listing( $heading, $blurb = '', $proj, $container_class = '', $proj_details = '', $listing_options='' ) {
        
        $hs = new hicaliber_theme_helpers;

        $content_boxes_display = _get_sub_field_value('pe_projects_layout');
        $design = _get_sub_field_value('content_boxes_design');
        $default_heading = _get_sub_field_value('pe_projects_header');

        $content_to_display = is_array($listing_options) && isset($listing_options['project_content_to_display']) ? $listing_options['project_content_to_display'] : [];

        $section_css = "";

        // $section_css = $hs::css_class_helper(
        //    [ 'page-element', 'project-element', 'project-listing', 'content-boxes', $design['section_classes'], $design['theme'], $content_boxes_display['display'], $design['text_alignment'], $design['background_image'] ? 'has-bg-img' : '' ]
        // );

        $class = "";
            if( !(is_array($content_to_display) ? in_array('button', $content_to_display) : false) ) {
                $class = "button-hidden";
            }

        $section_css = $hs::css_class_helper(
            [ 'page-element', 'content-boxes', 'project-content-boxes', 'project-listing', $design['section_classes'], $design['theme'], $design['text_alignment'], $content_boxes_display['display'], $class ]
        );
        
        if(!$heading){
            if($default_heading['peh_section_title']) $heading = $default_heading['peh_section_title'];
            else $heading = "Related Projects";
        }

        if(!$blurb){
            if($default_heading['peh_sub_heading']) $blurb = $default_heading['peh_sub_heading'];
        }
        
        $html = "";
        
        $proj = $proj[0];
        
        
        if( is_array($proj) ? count($proj) > 0 : false ) {
            
            $html .= '<section ' . hi_set_pageid($design['section_id']) . ' class="' . $section_css . '">';
                $html .= $hs::design_background_image( $design['background_image']);
                $html .= '<div class="inner-section">';
                $html .= '<div class="grid-container">';
                $html .= '<div class="grid-x grid-padding-x row-flex project-list">';
                $html .= '<div class="cell small-12  section-header"><h2 class="section-title">'. $heading .'</h2><h4 class="sub-heading">'. $blurb .'</h4></div>
                        </div>';
                
                $html .= '<div class="grid-x grid-padding-x section-body ' . $content_boxes_display['layout_type'] . '" data-item-col="' . $content_boxes_display['per_row'] . '" >'; 

                if( $proj && is_array($proj) ? count($proj) > 0 : false ) {
                    foreach( $proj as $key => $data ) {
                        $html .= "<div class='columns project-item ".$content_boxes_display['per_row']."'>";
                        $html .= self::project_template_2( $data, '', $listing_options  );
                        $html .= "</div>";
                    }
                }

                $html .= '</div></div></div></section>';

            return $html;
        }

    }
    
     /**************************************************
     * Listings Items : Related copy need to refator
     *************************************************/

    public static function project_template_2( $proj , $proj_details = '', $listing_options ) {        
      
        $sav_fav_general = _get_field_value('pjgs_save_favourites_feature', 'options');
        $general_save = _get_field_value('pjgs_save_visibility', 'options');
        
        // $proj = $proj['select_project'];

        $actions = _get_field_value('proj_actions_main', $proj );
        
        $page_title = get_the_title($proj );

        //Getting Post Content
        $my_postid = $proj;
        $content_post = get_post($my_postid);
        $content = wpautop($content_post->post_content);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        $content = force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( $content ) , 20 ) ) );

        $content_to_display = is_array($listing_options) && isset($listing_options['project_content_to_display']) ? $listing_options['project_content_to_display'] : [];
        $content = has_excerpt($proj) ? wpautop( get_the_excerpt($proj) ) : $content;

        $item_name = $page_title;

        $upload_folder = wp_upload_dir();
     
        $d = json_encode( $proj  );
		ob_start(); ?> 

		<div class="hic-box">
		    
                <?php if( ( isset($actions["add_to_favourites"]) ? $actions["add_to_favourites"] : false ) && $sav_fav_general && $general_save) : ?>
                    <button class="button save-to-favourite addFavourites" data-project='<?php echo $d; ?>'  >
                        <span class="fa fa-star"></span> <span class="lbl uppercase">SAVE</span>
                    </button>
                <?php endif; ?>
               
                <?php 
                    $primage = get_the_post_thumbnail_url( $proj, 'full' );
                ?>
                <div class="hic-image-container<?php echo $primage ? ' has-image' : ''?>">
                    <a href="<?php echo get_permalink($proj); ?>">
                        <div class="overlay"></div>
                        <?php if($primage) : ?>
                            <div class="hic-image" <?php echo self::set_image( $primage ) ?>></div>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="hic-content">
                    <div class="hic-title">
                        <a href="<?php echo get_permalink($proj); ?>"><h3><?php echo get_the_title($proj); ?></h3></a>
                    </div>
                    <?php
                        if( is_array($content_to_display) ? in_array('category', $content_to_display) : false  ) {
                            $terms = get_the_terms($proj, 'project_cat');
                            $total = 0;
                            $counter = 0;
                            if(is_array($terms) ? ($total = count($terms)) > 0 : false): $counter = 1;?>
                            <div class="hic-category"><?php 
                                foreach($terms as $term) : ?>
                                    <a href="<?php echo get_category_link($term->term_id); ?>"><?php echo $term->name; ?></a><?php 
                                    if($counter < $total && $counter != $total) : ?><span class="hic-seperator"></span><?php endif;
                                    $counter++;
                                endforeach; ?>
                            </div>
                            <?php endif;
                        } 
                    ?>
                    <?php if($content && is_array($content_to_display) ? in_array('description', $content_to_display) : false ): ?>
                        <div class="hic-blurb"><?php echo $content; ?></div>
                    <?php endif; ?>
                    <div class="hic-button-wrap">
                        <a href="<?php echo get_permalink($proj); ?>"  class=" button primary-button">View <span>Project</span></a>
                    </div>
                </div>
            </div>

		<?php					
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    

    public static function img_resp( $s, $m ,$l ) {
        return "<img src='' class='img-sld-responsive' data-img-s='".$s."' data-img-m='".$m."' data-img-l='".$l."' >";
    }

    public static function video_section( $video, $content, $show_section=false ) {
        $hs = new hicaliber_theme_helpers;

        $design = _get_sub_field_value('cpts_video_design');

        $section_css = "";

        $heading = _get_sub_field_value('cpts_video_header');

        $section_css = $hs::css_class_helper(
           [ 'page-element', 'project-element', 'video', 'image-element', $design['section_classes'], $design['theme'], $design['text_alignment'] ]
        );

        $video_source_type = "";
        $video_image_placeholder = "";
        $youtube_video = "";
        $embed_code = "";
        $video_file = "";
        
        if( is_array($video) ) extract($video);
        
        $html = "";
        if($show_section) :
            
            if( ($video_source_type == 'url' && $youtube_video) || ($video_source_type == 'embed' && $embed_code) || ( $video_source_type == 'file' && isset($video_file['url']) ? $video_file['url'] : false) ) {

                $html .= '<section ' . hi_set_pageid($design['section_id']) . ' class="' . $section_css . '">';
                $html .= '<div class="inner-section">';
                $html .= '<div class="grid-container">';
                $html .= '<div class="grid-x grid-padding-x">';
                $html .= '<div class="cell medium-12 section-header text-center">';
                if($heading['peh_section_title']){
                    $html .= '<h2 class="section-title">' . $heading['peh_section_title'] . '</h2>';
                }
                if($heading['peh_sub_heading'] || $content['description']){
                    $html .= $content['description'] ? $content['description'] : $heading['peh_sub_heading'];
                }
                $html .= '</div></div>';
                $html .= '<div class="grid-x grid-padding-x"><div class="cell small-12">';
                $html .= "<div class='text-center'>";
                $html .= self::get_video($video); 
                $html .= "</div>";
                $html .= "</div></div></div></section>";
            }
        
        endif;
        
        return $html;
    }

    public static function get_video($video_options){
        $video_source_type = "";
        $video_image_placeholder = "";
        $youtube_video = "";
        $embed_code = "";
        $video_file = "";
        
        if( is_array($video_options) ) extract($video_options);
        
        ob_start(); ?>
        <div class="hic-video-container"><div class="overlay"></div><?php
        
        if( $video_source_type == 'url' && $youtube_video ) : ?> 
            
                <a href="<?php echo $youtube_video ?>?rel=0" data-fancybox>
                    <div class="hic-image" style="background-image: url( <?php echo $video_image_placeholder; ?> );">
                        <div class="v-align-container vpv-container">
                            <div class="table-cell-mid">                                                            
                                    <img class="video-play-button" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/play-button.png">                                                                    
                            </div>
                        </div>
                    </div>
                </a>
           <?php
        elseif( $video_source_type == 'embed' && $embed_code ) : echo $embed_code; 
        elseif( $video_source_type == 'file' && isset($video_file['url']) ? $video_file['url'] : false ) : ?>
            <video controls poster="<?php echo $video_image_placeholder; ?>" class="vid-st bg-helper" preload="none">
                <source src="<?php echo $video_file['url']; ?>" type="video/mp4"><?php
                if( $video_image_placeholder ) : ?>
                    <img class="img-st bg-helper" src="<?php echo $video_image_placeholder; ?>"/><?php
                endif; ?>
            </video><?php
        endif; ?>
        </div><?php
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
    
    public static function buttons( $buttons ) {
        $enquire = _get_field_value('pjgs_action_btn_enquire', 'options');
        $html = "";
        
        if( $enquire['visibility'] && ( isset($buttons['enquire']) ? $buttons['enquire'] : false )  ) : 
            
        ob_start(); ?>
            <div class="hic-button-wrap">
                <?php 
                    $button = "";
                        
                    if( $enquire['visibility'] && ( isset($buttons['enquire']) ? $buttons['enquire'] : false ) ) {
                        
                        $button = new hcPCBButtonElement();
                        if($enquire['button_target'] == "link") 
                            $button->constructButton( $enquire["link"]['url'], $enquire["label"], $enquire["link"]['target'] );
                        else 
                            $button->constructModalButton( $enquire["data_open"], $enquire["label"] );
                        if($enquire['show_icon']) $button->setIcon($enquire["icon"]);
                        $button->toggleClasses(["enquire-range", "light-button", "small-button"]);
                        $button->displayButtonElement();
                    }
                ?>

            </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        
        endif;
        
        return $html;
    }
}
