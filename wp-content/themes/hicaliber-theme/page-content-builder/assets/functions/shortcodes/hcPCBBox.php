<?php
class PCB_HIC_BOX {
    public function __construct(){
        add_shortcode('content_box', array( $this, 'create_shortcode' ) );
    }
    public function create_shortcode( $atts, $content ){
        extract(shortcode_atts(
			array(
                'title'      => "",
                'image'      => "",
                'gallery'    => "",
                'video'      => "",
                // 'icon'       => "",
                'button'     => "",
                'model'      => 'cbox',
			), $atts
        ) );
        
        $models = array(
                "cbox" => new hcPCBContent(),
                "article" => new hcPCBArticle(),
                "review" => new hcPCBTestimonial(),
            );
        
        $model = array_key_exists($model, $models) ? $model : "cbox";
        
        $media = "image";

        ob_start();
        $hicBox = $models[$model];
        $hicBox->setTitle( $title );
        $hicBox->setContent( $content );
        
        $hicBox->setImage( new hcPCBLink( $image ) );

        if($video){
            $media = 'video';
            $hicBox->setVideo2( new hcPCBLink( $video ) );
        }

        if($gallery){
            $gallery = explode(",",$gallery);
            $img_arr = array();
            if(is_array($gallery) ? count($gallery) > 0 : false){
                $media = 'gallery';
                foreach($gallery as $image){
                    $img_arr[] = array(
                        'url' => $image
                    );
                }
            }
            
            $hicBox->setGallery( $img_arr ); 
        }
        
        // $image_icon = false;
        // $hicBox->setUseImageIcon( $image_icon );
        // if( $image_icon ) $hicBox->setImageIcon( new hcPCBLink($icon) );
        // else $hicBox->setIcon( $icon );

        $hicBox->setMediaType( $media );
        
        if($button){
            $button = explode(",",$button);
            $btn_attrs = array();
            if(is_array($button) ? count($button) > 0 : false){
                foreach($button as $attr){
                    $attr = explode("=>",$attr);
                    if(count($attr) == 2){
                        $btn_attrs[$attr[0]] = $attr[0] == 'data_open' ? "modal-elem-".$attr[1] : $attr[1];
                    }
                }

                $hicBox->setButton( new hcPCBButtonElement( $btn_attrs ) );
            }
        }

        $hicBox->setNoColumns(true);

        $hicBox->displayContent();

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
new PCB_HIC_BOX();