<?php
class PCB_BUTTON {
    public function __construct(){
        add_shortcode('button', array( $this, 'create_shortcode' ) );
    }
    public function create_shortcode( $atts ){
        extract(shortcode_atts(
			array(
                'url'      => "",
                'title'    => "",
                'target'   => "",
                'data_open' => "",
                'classes'     => "",
			), $atts
        ) );
        
        ob_start();
        
        if($url || $data_open) : 
            if($data_open){
                $button_data = array(
                    'title'    => $title,
                    'data_open' => "modal-elem-".$data_open,
                );
            } elseif ($url) {
                $button_data = array(
                    'url'      => $url,
                    'title'    => $title,
                    'target'   => $target,
                );
            }
            $button = new hcPCBButtonElement($button_data);
            
            $classes = explode(",",$classes);
            
            if(is_array($classes) ? count($classes) > 0 : false){
                foreach($classes as $cls){
                    if($cls) $button->toggleClass($cls);
                }
            }
            echo $button->displayButtonElement();
        endif;

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
new PCB_BUTTON();