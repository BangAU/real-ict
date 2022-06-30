<?php
class PCB_GLOBAL_ELEMENT {
    public function __construct(){
        add_shortcode('global_element', array( $this, 'create_shortcode' ) );
    }
    public function create_shortcode( $atts ){
        extract(shortcode_atts(
			array(
                'id'      => "1"
			), $atts
        ) );

        ob_start();
        if( preg_match('/^\d+(,\d+)*$/', $id - 1) ){

            foreach(explode(",", $id - 1) as $arg){
                $elements = array('pe_g_select'=> $arg);
                include( locate_template('page-content-builder/elements/content-global_element.php', false, false ) );
            }
        } else echo "Invalid arguments for id";
        return ob_get_clean();
    }
}
new PCB_GLOBAL_ELEMENT();