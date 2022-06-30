<?php

if(!class_exists("hicaliber_theme_hero")) :
    
class hicaliber_theme_hero {
    
    public static $youtube_regexp = "/^http:\/\/|https:\/\/(?:www.)?(?:youtube.com|youtu.be)\/(?:watch?(?=.*v=([\w-]+))(?:\S+)?|([\w-]+))$/";
    public static $vimeo_regexp = "/^http:\/\/|https:\/\/(?:www.)?(?:vimeo.com)\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)$/";
    
    public static function alignment( $main_text_style = "" ) {

		switch ($marketing_message_alignment) {
			case 'center':
				$main_text_style = 'style="margin: 0 auto; text-align: center;"';
				$text_aligntment = 'text-center';
				break;
			case 'right':
				$main_text_style = 'style="margin: 0 0 0 auto; text-align: right;"';
				$text_aligntment = 'text-right';
				break;
			
			default:
				$main_text_style = 'style="text-align: left;"';
				break;
		}
		
		return $main_text_style;
        
    }
    
    public static function bg_overlay( $colour ){
        if( $colour ){
            return '<div class="hero-bg-overlay" style="background-color:'.$colour.';"></div>';
        }
    }

    /****
     * Default Banner    
    ***/

    public static function default_hero( $content_args = array() ) {
        
        ob_start(); ?>

<div class="hero-main">
    <div class="bg-image" <?php echo hi_set_bg_img_raw($content_args['img']); ?>>
        <?php echo self::bg_overlay( $content_args['bg_overLay'] ); ?>
    </div>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <?php if(!empty($content_args['form_display']) && $content_args['form_options']['form_layout'] == 'form-layout-1') : ?>
            <div class="cell cell-form">

                <div class="hero-form">
                    <?php echo self::display_form($content_args['form_options']); ?>
                </div>


            </div>
            <?php endif; ?>
            <div class="cell cell-message">
                <div class="hero-banner-message">
                    <h1><?php echo $content_args['title']; ?></h1>
                    <?php echo $content_args['desc']; ?>
                    <?php if(is_singular('post')) : ?>
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part( 'parts/content', 'byline' ); ?>
                    <?php endwhile; endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-2') : ?>
<div class="hero-form">
    <?php echo self::display_form($content_args['form_options']); ?>
</div>
<?php endif; ?>

<?php
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }
    
    /****
     * generate button
    ***/
    
    public static function generate_cta_button( $btns = array() ){
        
        $html = "";
        $counter = 0;
        
        foreach( $btns as $btn ) {
            $counter++;
            $button_class = '';

            if($counter == 1) {
                $button_class = 'primary-white-button';
            } else {
                $button_class = 'secondary-white-button';
            }


            if( isset( $btn['url'] )  ) {
                $html .= '<a href="'.$btn['url'].'"';
                if($btn['target']) $html .= ' target="'.$btn['target'].'"';
                $html .= ' class="button '.$button_class.'">'.$btn['title'].'</a>';    
            }
            
        }
        
        return $html;
        
    }
    
    /****
     * Gallery image
    ***/
    
    public static function gallery_background_banner( $content_args ) {

        $slider_autoplay = '';        
        $slider_autoplay = $content_args['slider_autoplay'];
        $slider_arrows = $content_args['slider_arrows'];
        $slider_dots = $content_args['slider_dots'];
        $slider_autoplay_speed = $content_args['slider_autoplay_speed'];
        $slider_autoplay_attribut = 'data-autoplay="'.$slider_autoplay.'" data-autoplay-speed="'.$slider_autoplay_speed.'"';
        $slider_attribut = 'data-arrows="'.$slider_arrows.'" data-dots="'.$slider_dots.'"';

        
        ob_start(); ?>

<div class="hero-main hero-carousel-type">
    <div class="hero-slider" <?php echo ($slider_autoplay) ? $slider_autoplay_attribut : ''; ?>
        <?php echo $slider_attribut; ?>>
        <?php if($content_args['bg_image_slides']) : ?>
        <?php foreach( $content_args['bg_image_slides'] as $slide) : ?>
        <div class="bg-image" style="background-image: url(<?php echo $slide['url']; ?>)">
            <?php echo self::bg_overlay( $content_args['bg_overLay'] ); ?>


            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell">
                        <?php if( $content_args['bg_gallery_content'] ) : ?>
                        <div class="hero-banner-message">
                            <?php echo $content_args['bg_gallery_content']; ?>

                            <?php
                                                     
                                                        if($content_args['bgg_btns']['cta_button'] || $content_args['bgg_btns']['cta_button_2'] || ($content_args['video_popup_link'] && $content_args['video_popup_button_label'])): ?>
                            <div class='hic-button-wrap'>
                                <?php echo self::generate_cta_button( $content_args['bgg_btns'] ); ?>
                                <?php
                                                               echo self::get_video_button($content_args['video_popup_link'], $content_args['video_popup_button_label'], 'secondary-white-button video-button hero-button');
                                                            ?>
                            </div>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-1') : ?>

    <div class="hero-form">
        <?php echo self::display_form($content_args['form_options']); ?>
    </div>

    <?php endif; ?>
</div>

<?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-2') : ?>
<div class="hero-form">
    <?php echo self::display_form($content_args['form_options']); ?>
</div>
<?php endif; ?>

<?php
        
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public static function video_banner( $content_args ) {
        
        ob_start(); ?>
<div class="hero-main">
    <div class="hero-video-banner">
        <?php
                        $video_banner = $content_args['video_banner'];
                        echo self::bg_overlay( $content_args['bg_overLay'] );
                    ?>
        <?php
                        if($video_banner['hero_banner_video_type']=='file' && $video_banner['hero_background_video_file']) : ?>
        <div class="video-wrap show-for-large with-bg-overlay">
            <?php if($video_banner['hero_background_video_file']['url']) : ?>
            <video id="hero_bgvid" autoplay playsinline webkit-playsinline poster="" preload="none" loop muted="true">
                <source src="<?php echo $video_banner['hero_background_video_file']['url']; ?>" type="video/mp4">
            </video>
            <?php endif; ?>
        </div>
        <?php elseif($video_banner['hero_banner_video_type']=='url' && $video_banner['hero_video_url']): ?>
        <div class="video-wrap show-for-large with-bg-overlay">
            <?php 
                                $youtube_matches = [];
                                $vimeo_matches = [];

                                preg_match(self::$youtube_regexp, $video_banner['hero_video_url'], $youtube_matches);
                                preg_match(self::$vimeo_regexp, $video_banner['hero_video_url'], $vimeo_matches);

                                if(sizeof($youtube_matches) == 2) :
                            ?>
            <iframe id="hero_bgvid" class="embed youtube" width="100%" height="100%"
                src="https://www.youtube.com/embed/<?php echo $youtube_matches[1]; ?>?rel=0&autoplay=1&loop=1&showinfo=0&autohide=1&mute=1&controls=0&playlist=<?php echo $youtube_matches[1];?>"
                frameborder="no" allowfullscreen="0" allow="autoplay"></iframe>
            <?php 
                                elseif(sizeof($vimeo_matches) == 3) : 
                            ?>
            <iframe id="hero_bgvid" class="embed vimeo" width="100%" height="100%"
                src="https://player.vimeo.com/video/<?php echo $vimeo_matches[2]; ?>?rel=0&autoplay=1&loop=1&background=1&muted=1&byline=0"
                frameborder="no" allowfullscreen="0" allow="autoplay"></iframe>
            <?php
                                endif; 
                            ?>
        </div>
        <?php else: ?>
        <div class="bg-helper bg-image show-for-large"
            style="background-image: url(<?php echo $video_banner['hero_video_fallback_image']; ?>); ?>;"></div>
        <?php endif; ?>

        <div class="bg-helper bg-image hide-for-large"
            style="background-image: url(<?php echo $video_banner['hero_video_fallback_image']; ?>);"></div>

    </div>
    <?php if( $content_args['bg_gallery_content'] ) : ?>
    <div class="hero-banner-message">

        <div class="grid-container">
            <div class="grid-x grid-padding-x hide-for-large">
                <div class="cell small-12">
                    <div class="play-video">
                        <?php 
                                        if($video_banner['hero_banner_video_type']=='file' && $video_banner['hero_background_video_file']){
                                            echo self::get_video_button($video_banner['hero_background_video_file']['url'], '<i class="fas fa-play"></i>', 'play-button');
                                        } elseif($video_banner['hero_video_url']) {
                                            echo self::get_video_button($video_banner['hero_video_url'], '<i class="fas fa-play"></i>', 'play-button');
                                        }
                                    ?>
                    </div>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="cell small-12">
                    <?php 
    				                    echo $content_args['bg_gallery_content'];
    				                ?>
                    <div class='hic-button-wrap'>
                        <?php
    				                    echo self::generate_cta_button( $content_args['bgg_btns'] ); 
    				                ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php endif; ?>
    <?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-1') : ?>
    <div class="hero-form">
        <?php echo self::display_form($content_args['form_options']); ?>
    </div>
    <?php endif; ?>
</div>

<?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-2') : ?>
<div class="hero-form">
    <?php echo self::display_form($content_args['form_options']); ?>
</div>
<?php endif; ?>

<?php
        
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }

  public static function display_form($form_options) {
        extract($form_options);    
        ob_start(); ?>
<div class="inner-hero-form">
    <div class="hero-form-container">
        <header>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <h4 class="form-title"><?php echo $title; ?></h4>
            <div class="form-blurb">
                <?php echo $blurb; ?>
            </div>
        </header>

        <?php 
                        //getting form (populated with Gravity Form)
                        if(isset($form['id']) && $form_options['form_option'] == 'gravity-form') :
                            $tab_index = $tab_index ? $tab_index : 1;
                            gravity_form_enqueue_scripts($form['id'], true);
                            gravity_form($form['id'], false, false, true, '', true, $tab_index);
                        endif; 
                        
                        
                         if($form_options['form_option'] == 'hicaliber_booking_form'):
                            echo do_shortcode('[search-form]');    
                        endif;
                    ?>
    </div>
</div>
<?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    
    
    public static function slider_carousel_banner( $content_args ) {
        
        $slider_autoplay = '';
        $slider_autoplay = $content_args['slider_autoplay'];
        $slider_arrow = $content_args['slider_arrows'];
        $slider_dots = $content_args['slider_dots'];
        $slider_autoplay_speed = $content_args['slider_autoplay_speed'];
        $slider_autoplay_attribut = 'data-autoplay="'.$slider_autoplay.'" data-autoplay-speed="'.$slider_autoplay_speed.'"';
        $slider_attribut = 'data-arrows="'.$slider_arrow.'" data-dots="'.$slider_dots.'"';


        // hero_image_slides
        ob_start(); ?>

<?php if($content_args['slider']) : ?>
<div class="hero-main hero-carousel-type">
    <div class="hero-slider" <?php echo ($slider_autoplay) ? $slider_autoplay_attribut : ''; ?>
        <?php echo $slider_attribut; ?>>
        <?php foreach( $content_args['slider'] as $slide) : ?>

        <div class="bg-helper bg-image slide-item"
            style="background-image: url(<?php echo $slide['hero_sc_background_image']; ?>)">
            <?php echo self::bg_overlay( $content_args['bg_overLay'] ); ?>

            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell">
                        <div class="hero-banner-message">
                            <?php echo $slide['hero_sc_marketing_message']; ?>

                            <?php
                                            extract($slide['hero_sc_video']);
                                            if($slide['hero_sc_button']['cta_button'] || $slide['hero_sc_button']['cta_button_2'] || ($hero_banner_video_link_id && $hero_banner_video_link_label)): ?>
                            <div class='hic-button-wrap'>
                                <?php echo self::generate_cta_button( $slide['hero_sc_button'] ); ?>
                                <?php
                                                    echo self::get_video_button($hero_banner_video_link_id, $hero_banner_video_link_label, 'secondary-white-button video-button hero-button');
                                                ?>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <?php endforeach; ?>

    </div>
    <?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-1') : ?>

    <div class="hero-form">
        <?php echo self::display_form($content_args['form_options']); ?>
    </div>

    <?php endif; ?>
</div>
<?php if($content_args['form_display'] && $content_args['form_options']['form_layout'] == 'form-layout-2') : ?>
<div class="hero-form">
    <?php echo self::display_form($content_args['form_options']); ?>
</div>
<?php endif; ?>

<?php endif; ?>

<?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
        
    }

    public static function get_video_button($link, $label, $classes){
        $youtube_matches = [];
        $vimeo_matches = [];

        preg_match(self::$youtube_regexp, $link, $youtube_matches);
        preg_match(self::$vimeo_regexp, $link, $vimeo_matches);

        ob_start(); 
        
        if($link && $label ) : 
            if(sizeof($youtube_matches) == 2) : ?>
<a href="https://www.youtube.com/watch?v=<?php echo $youtube_matches[1]; ?>&rel=0" data-fancybox
    class="button <?php echo $classes; ?>"><?php echo $label; ?></a>
<?php elseif(sizeof($vimeo_matches)==3 ) : ?>
<a href="https://vimeo.com/<?php echo $vimeo_matches[2]; ?>" data-fancybox
    class="button <?php echo $classes; ?>"><?php echo $label; ?></a>
<?php else : ?>
<a href="<?php echo $link; ?>?iframe=true&width=200" data-fancybox
    class="button <?php echo $classes; ?>"><?php echo $label; ?></a>
<?php endif; 
        endif;

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

  

     public static function background_with_slider( $content_args ) {
        

        // Background Image w/ Slides
        ob_start(); ?>


<div class="bg-helper bg-image" <?php echo hi_set_bg_img_raw($content_args['img']); ?>>

    <?php echo self::bg_overlay( $content_args['bg_overLay'] ); ?>

</div>
<div class="hero-banner-message-w-slider">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell medium-5">
                <div class="hero-banner-message">
                    <?php if( $content_args['bg_gallery_content'] ) : ?>
                    <?php 
                                        echo $content_args['bg_gallery_content'];
                                        echo "<div class='hic-button-wrap'>";
                                        echo self::generate_cta_button( $content_args['bgg_btns'] ); 
                                        echo "</div>";
                                    ?>
                    <?php
                                        if($content_args['video_popup_link'] && $content_args['video_popup_button_label'] ){
                                            echo self::get_video_button($content_args['video_popup_link'], $content_args['video_popup_button_label'], 'secondary-white-button video-button hero-button');
                                        } 
                                    ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="cell medium-7">
                <div class="hero-gallery-slider">
                    <?php if($content_args['hero_image_slides']) : ?>
                    <div class="hero-gallery-slides">
                        <?php foreach( $content_args['hero_image_slides'] as $slide) : ?>
                        <div class="bg-helper bg-image slide-item"
                            style="background-image: url(<?php echo $slide['url']; ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if($content_args['hero_image_slides'] && count($content_args['hero_image_slides']) > 1) : ?>
                    <div class="hero-gallery-slides-thumb">
                        <?php foreach( $content_args['hero_image_slides'] as $slide) : ?>
                        <div class="bg-helper bg-image slide-item"
                            style="background-image: url(<?php echo $slide['url']; ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
        
    }    
    
    public static function display( $content_args = array() ) {

        
        /*
            page-banner : Page Banner
            gallery-background-banner : Gallery Background
            slider-carousel-banner : Slider Carousel
            video-background-banner : Video Background
        */
        
        /************
        * Check if banner is set to true
        *************/       

        $banner_options = _get_field_value('post_single_banner_options', 'options');

        $single_post_banner = FALSE;

        if(is_singular('post') && ($banner_options && $banner_options['show_page_banner']) ) {
            $single_post_banner = TRUE;
        }        

        if( $content_args['banner'] == true || $single_post_banner ) :
    
            ob_start(); ?>

<?php 
                    $form_display = isset($content_args['form_display']) ? $content_args['form_display'] : false;
                    $form_position = isset($content_args['form_options']['position']) ? $content_args['form_options']['position'] : '';
                                
                
                    $hero_classes = [$content_args['banner_type'], $content_args['banner_height'], $content_args['text_align'], (($form_display) ? 'has-form' . ' ' . $content_args['form_options']['form_layout'] . ' ' .$form_position : '')];

                    $hero_classes = implode(' ', array_filter($hero_classes));
                ?>

<section class="hero <?php echo $hero_classes; ?>">
    <div class="inner-hero"><?php
                        switch ( $content_args['banner_type'] ) {
                			case 'page-banner':
                				echo self::default_hero( $content_args );
                			break;
                			
                			case 'gallery-background-banner';
                			    echo self::gallery_background_banner( $content_args );
                			break;
                			
                			case 'slider-carousel-banner';
                			    echo self::slider_carousel_banner( $content_args );
                            break;
                            
                            case 'video-background-banner';
                                echo self::video_banner( $content_args );
                            break;

                            case 'background-with-slider';
                                echo self::background_with_slider( $content_args );
                            break;

                			default:
                			    echo self::default_hero( $content_args );
                		}
                        ?>
    </div>
    <?php 
                    
                    ?>
</section>
<?php
            $html = ob_get_contents();
            ob_end_clean();
            echo $html;
        
        endif;
    }

    public function __construct(){

    }

}

endif;