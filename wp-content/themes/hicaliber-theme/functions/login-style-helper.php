<?php
add_action('login_head', 'custom_login_styles');
 
function custom_login_styles() {
     
    $login_opt = [];
    if(_get_field_value('opt_login_page', 'options')) {
        $login_opt = _get_field_value('opt_login_page', 'options');
    }
    extract($login_opt);
    $brand_colour = _get_field_value('site_brand_colour', 'options');
    $primary_colour = _get_field_value('site_primary_button_hover_colour', 'options');
    
    $site_logo = get_field('g_site_logo', 'options');

 	?>
        <style>
            body:before {
                content: '';
                background-image: url(<?php echo $login_bg_img; ?>) !important;
                position: absolute;
                left: 0;
                height: 100%;
                width: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
            body.login-layout-1:before {
                 width: calc(100% - 480px);
            }
            h1 a { 
                background-image: url(<?php echo $site_logo; ?>) !important; 
            }
            h1 a { 
                background-image: url(<?php echo $site_logo; ?>) !important; 
            }
            #login{
                <?php echo hi_rgb($brand_colour,5); ?> !important;
            }
            .login #login_error,
            .login .message {
                <?php echo hi_rgb($brand_colour,75); ?> !important;
            }
            .login .message {
                border-left: 16px <?php echo $brand_colour; ?> solid;
            }

            .login .button-primary#wp-submit {
                background-color: <?php echo $brand_colour; ?>;
            }

            .login .button-primary#wp-submit:focus,
            .login .button-primary#wp-submit:hover{
                background-color: <?php echo $primary_colour; ?>;
            }
        </style>
    <?php
   
}