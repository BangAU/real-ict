<?php
class PCB_LOCATION_PROFILE {
    public function __construct(){
        add_shortcode('location_contact', array( $this, 'create_shortcode' ) );
    }
    public function create_shortcode( $atts ){
        extract(shortcode_atts(
			array(
                'datas' => 'avatar,name,position,phone,email',
                'disable_html' => '0',
                'separator' => ', ',
                'widget'      => "1",
			), $atts
        ) );

        $disable_html = $disable_html == "1" ? true : false;
        $widget = $widget == "1" ? true : false;
        $datas = $datas ? $datas : 'avatar,name,position,phone,email';

		$datas = explode(",",$datas);
        
        ob_start();
        
        $is_single_location = is_singular('location');
        $is_single_location_post = is_singular('location_post');
        $is_single_location_page = is_singular('location_page');
    
        if($is_single_location || $is_single_location_post || $is_single_location_page){
            $profile = get_field('location_contact_person_avatar');
            $name = get_field('location_contact_person');
            $position = get_field('location_contact_person_position');
            $phone = get_field('location_phone');
            $email = get_field('location_email_address');
                
            if($profile || $name || $position || $phone || $email) : 
                if(!$disable_html) : 
                    if($widget) : ?>
                    <div class="sidebar-widget-element location-profile-widget square-images">
                        <div class="grid-x grid-padding"><?php
                    endif;
                            $content = "";
                            $content .= '<div class="contact-details">';
                            foreach($datas as $data) :
                                if($data == "name" && $name){
                                    $content .= "<div class='contact-name'>".$name."</div>";
                                }
                                if($data == "position" && $position){
                                    $content .= "<div class='contact-name-position'>".$position."</div>";
                                }
                                if($data == "phone" && $phone){
                                    $content .= '<div class="contact-phone">';
                                    $content .= '<i class="fas fa-mobile-alt"></i>';
                                    $content .= '<a href="tel:' . str_replace(' ', '', $phone) . '">' . $phone . '</a>';
                                    $content .= '</div>';
                                }
                                if($data == "email" && $email){
                                    $content .= '<div class="contact-email">';
                                    $content .= '<i class="far fa-envelope"></i>';
                                    $content .= '<a href="mailto:' . $email . '">' . $email . '</a>';
                                    $content .= '</div>';
                                }
                            endforeach;
                            $content .= '</div>';
                            
                            if($data == "avatar" && $profile){
                                $hicBox = new hcPCBContent();
                                $hicBox->setContent( $content );
                                $hicBox->setImage(new hcPCBLink( $profile ));
                                
                                $hicBox->displayContent(); 
                            } else {
                                echo $content;
                            }
                           
                    if($widget) : ?>
                        </div>
                    </div><?php
                    endif;
                else : 
                    foreach($datas as $index => $data) :
                        if($data == "name" && $name) : 
                            $datas[$index] = $name ? $name : ""; 
                        elseif($data == "position" &&  $position) : 
                            $datas[$index] = $position ? $position : ""; 
                        elseif($data == "phone" && $phone) : 
                            $datas[$index] = $phone ? $phone : ""; 
                        elseif($data == "email" &&  $email) : 
                            $datas[$index] = $email ? $email : ""; 
                        else :
                            $data[$index] = "";
                        endif; 
                    endforeach;

                    $datas = array_filter($datas);
                    if($separator == "\n") _e(wpautop(implode( $separator, $datas ))); 
                    else _e(implode($separator, $datas));

                endif;
            endif;
        }

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}
new PCB_LOCATION_PROFILE();