<?php
    $evh = new hcElementController(_get_field_value('sites_elements', 'options'));
    
    if($evh::isVisible('gallery', true)) {
    
        require_once( 'gallery-cpt.php' );
        require_once( 'gallery-acf-settings-field.php' );
        require_once( 'gallery-acf-fields.php' );
    	
        function hi_gallery_single_page( $single_template  ) {
          
             global $post;
    	     if ($post->post_type == 'gallery') {
    	         $single_template = get_template_directory() . '/gallery-module/single-gallery.php';
    	     } 
    	     return $single_template;
        }
        
     if( function_exists('acf_add_options_page') ) {
       	acf_add_options_page( array( 
    		'page_title' 	=> 'Gallery Settings',
    		'parent'     => 'edit.php?post_type=gallery',
    		'capability'	=> 'edit_theme_options'
    	));    
    }
    
        add_filter( 'taxonomy_template', function( $template ) {
    	    $mytemplate = get_template_directory() . '/gallery-module/taxonomy-gallery_cat.php';
    	    if( is_tax( 'gallery_cat' ) && is_readable( $mytemplate ) )
    	        $template =  $mytemplate;
    	    return $template;
		});
		
		add_filter( 'single_template', 'hi_gallery_single_page' );
    
    }
	
	
	class HI_GALLERY_FUNCTION {
     
         public static function hi_set_gallery_html($layout , $light_box=FALSE, $image, $gallery_name="gallery") {
			$title = "";
			if(!isset($image['title'])){
				$name = pathinfo($image['url'], PATHINFO_FILENAME);
				$ext = pathinfo($image['url'], PATHINFO_EXTENSION);
				$title = $name.".".$ext;
			}
    	    $html = '';
    	    
    	     $html .= '<div class="cell image-list '. $layout.'">';
    		    if( $light_box ) :
    				 $html .= '<a  href="'.$image['url'].'" title="'.$title.'" data-caption="'.$title.'" data-fancybox="'.$gallery_name.'" data-thumb="'.$image['url'] .'">';
    			endif;    
    			
    			
    				 $html .= '<div class="hic-image" style="background-image: url('.$image['url'].')">';
    				 
    				// var_dump($image);
    					
    					
    					if( $light_box ) : 
    						 $html .= '<div class="cross-icon-wrap">';
    							 $html .= '<img src="'.get_template_directory_uri() . '/assets/images/zoom-in.png" alt="zoom-icon">';								
    						 $html .= '</div>';
    					endif;
    					
    
    				$html .= '</div>';
    			 if( $light_box ) :
    				$html .= '</a>';
    		    endif;
    		$html .='</div>';
    		
    		return $html;

        }
        public function __construct() {
         
        }
        
    }

    new HI_GALLERY_FUNCTION();


?>