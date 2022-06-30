<?php
define('ASSETS_FONTS', get_template_directory_uri() . '/assets/fonts/' );

class GS_COMMON {
    const fonts = [        
        'arial'   => [
            'name'          => 'Arial',
            'font_family'   => "'Arial'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'Arial/Arial.ttf',
                ],
            ]
        ], 
        'baskervillegreekupright'   => [
            'name'          => 'Baskerville Greek Upright',
            'font_family'   => "'Baskerville Greek Upright'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'BaskervilleGreekUpright/BaskervilleGreekUpright.ttf',
                ],
            ]
        ],
        'bree'      => [
            'name'          => 'Bree Serif',
            'url'           => 'https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap',
            'font_family'   => "'Bree Serif', serif"
        ],
        'din'   => [
            'name'          => 'DIN',
            'font_family'   => "'DIN'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'DIN/DINRegular.ttf',
                ],
                [
                    'url'           => ASSETS_FONTS . 'DIN/DINBold.ttf',
                    'weight'        => 'bold'
                ],
                [
                    'url'           => ASSETS_FONTS . 'DIN/DINLight.ttf',
                    'weight'        => '200'
                ],
                [
                    'url'           => ASSETS_FONTS . 'DIN/DINMedium.ttf',
                    'weight'        => '300'
                ]
            ]
        ],
        'dinblack'   => [
            'name'          => 'DIN Black',
            'font_family'   => "'DIN Black'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'DIN/DINBlackRegular.otf',
                ],
            ]
        ],
        'Dosis'      => [
            'name'          => 'Dosis',
            'url'           => 'https://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700&display=swap',
            'font_family'   => "'Dosis', sans-serif"
        ],
        'lato'      => [
            'name'          => 'Lato',
            'url'           => 'https://fonts.googleapis.com/css?family=Lato&display=swap',
            'font_family'   => "'Lato', sans-serif"
        ],
        'minionpro'   => [
            'name'          => 'Minion Pro',
            'font_family'   => "'Minion Pro'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'MinionPro/MinionPro-Regular.otf',
                ],
            ]
        ],
        'monteserrat'       => [
            'name'          => 'Montserrat',
            'url'           => 'https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,600,600i,700i,700,800,900',
            'font_family'   => "'Montserrat', sans-serif"
        ],
        'muli'      => [
            'name'          => 'Muli',
            'url'           => 'https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i',
            'font_family'   => "'Muli', sans-serif"
        ],
        'opensans'      => [
            'name'          => 'Open Sans',
            'url'           => 'https://fonts.googleapis.com/css?family=Open+Sans&display=swap',
            'font_family'   => "'Open Sans', sans-serif"
        ],
        'poppins' => [
            'name'          => 'Poppins',
            'url'           => 'https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap',
            'font_family'   => "'Poppins', sans-serif",
        ],
        'ptserif' => [
            'name'          => 'PT Serif',
            'url'           => 'https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i&display=swap',
            'font_family'   => "'PT Serif', serif",
        ],
        'raleway' => [
            'name'          => 'Raleway',
            'url'           => 'https://fonts.googleapis.com/css?family=Raleway:200,300,300i,400,400i,500,500i,600,600i,700,700i&display=swap',
            'font_family'   => "'Raleway', sans-serif",
        ],           
        'proximanova'   => [
            'name'          => 'Proxima Nova',
            'font_family'   => "'Proxima Nova'",
            'local_urls'     => [
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-5966eafb54cf5.otf',
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-bold-5966eda094e4b.otf',
                    'weight'        => 'bold'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-bold-italic-5966ee9774a93.otf',
                    'weight'        => 'bold',
                    'style'        => 'italic'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-extrabold-5966ece04c22f.otf',
                    'weight'        => 'bolder'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-extrabold-italic-5966ee3847740.otf',
                    'weight'        => 'bolder',
                    'style'         => 'italic'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-light-5966ec9e87b7e.otf',
                    'weight'        => 'light'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-light-italic-5966ef047da5d.otf',
                    'weight'        => 'light',
                    'style'         => 'italic'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-regular-italic-5966ee8e1d583.otf',
                    'style'         => 'italic'
                ],
                [
                    'url'           => ASSETS_FONTS . 'ProximaNova/proxima-nova-semibold-5966ed3a36e38.otf',
                    'weight'         => '400'
                ]
            ]
        ],
        'roboto' => [
            'name'          => 'Roboto',
            'url'           => 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap',
            'font_family'   => "'Roboto', sans-serif",
        ],
        'vollkorn' => [
            'name'          => 'Vollkorn',
            'url'           => 'https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
            'font_family'   => "'Vollkorn', sans-serif",
        ],
        'custom-font'       => [
            'name'          => 'Custom Font',
            // 'url'           => "custom",
            // 'font_family'   => "custom"
        ],
    ];
    public static function resgistered_menu() {
        $default_menu_locations = array(
            'main-nav' => __( 'The Main Menu', 'jointswp' ),   // Main nav in header
            'location-menu' => __( 'Location Page Menu', 'jointswp' ),   // Location Menu in header
            'footer-links' => __( 'Footer Menu (1st)', 'jointswp' ), // Primary nav in footer
            'footer-links-2' => __( 'Footer Menu (2nd)', 'jointswp' ), // Secondary nav in footer
            'footer-links-3' => __( 'Footer Menu (3rd)', 'jointswp' ), // Secondary nav in footer
            'footer-links-4' => __( 'Footer Menu (4th)', 'jointswp' ), // Secondary nav in footer
            'mobile-menu' => __( 'Mobile Menu', 'jointswp' ), // Secondary nav in footer
            'top-menu' => __( 'Top Menu', 'jointswp' )
        );
    
        $default_menu_locations = apply_filters( 'default_menu_locations', $default_menu_locations );
        
        $additional_locations = [];
        if( get_field('opt_custom_menu_location','option') ) {
            $additional_locations = get_field('opt_custom_menu_location','option');
            if( is_array( $additional_locations ) ) {
                foreach( $additional_locations as $menu ) {
                    $key = str_replace( " ", "-",  strtolower( $menu['label'] )  );
                    $default_menu_locations[$key] = $menu['label'];
                }
            }
        }
        return $default_menu_locations;
    }
    public static function contact_details() {
        return get_field('contact_details','options');
    }
    
    function font_options( $field ) {        
        global $wpdb; 
        $field['choices'] = [];
        $fonts = self::fonts;
        
        foreach( $fonts as $key => $value ) {
            $field['choices'][ $key ] = $value['name'];
        }
        return $field;
    }
    
    
    // populate the Menu option
    
        // populate the Menu option
    
    public static function font_heading() {
        $font_heading = get_field('font_heading','options');
        $get_font_family = $font_heading['font_family'];
        $custom_font_group =  get_field('opt_custom_font' , 'options' );
        if( $get_font_family  == "custom-font" && isset(  $custom_font_group['google_font_url'] )  && isset( $custom_font_group['font_family'] ) ) {
            $font = [
                'url'           => $custom_font_group['google_font_url'],
                'font_family'   =>  $custom_font_group['font_family']
            ];
        } else {            
            $the_font = $get_font_family ? $get_font_family : 'roboto';
            $font = self::fonts;
            $selected_font = $the_font; // get field update the index
            $font = $font[$selected_font]; 
        }
        return $font;
    }

    public static function font_body() {
        $font_body = get_field('font_body','options');

        $get_font_family = $font_body['font_family'];
        $custom_font_group =  get_field('opt_custom_font' , 'options' );
        if( $get_font_family  == "custom-font" && isset(  $custom_font_group['google_font_url'] )  && isset( $custom_font_group['font_family'] ) ) {
            $font = [
                'url'           => $custom_font_group['google_font_url'],
                'font_family'   =>  $custom_font_group['font_family']
            ];
        } else {            
            $the_font = $get_font_family ? $get_font_family : 'roboto';
            $font = self::fonts;
            $selected_font = $the_font; // get field update the index
            $font = $font[$selected_font]; 
        }
        return $font;
    }
    
     function __construct(){
        add_filter('acf/load_field/key=field_5d9ae93c48ee3', [$this, 'font_options'] );
        add_filter('acf/load_field/key=field_5d9aea70e8f9d', [$this, 'font_options'] );
    }

}

new GS_COMMON();