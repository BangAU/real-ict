<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section
 *
 */
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta class="foundation-mq">

    <!-- Icons & Favicons -->
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
    <?php $favicon = _get_field_value('site_global_favicon','options'); ?>
    <?php $set_favicon = ($favicon) ? $favicon : get_template_directory_uri().'/favicon.png'; ?>
    <link rel="icon" href="<?php echo $set_favicon; ?>">
    <!--[if IE]>
			<link rel="shortcut icon" href="<?php echo $set_favicon; ?>">
			<![endif]-->

    <?php $mobile_icon = _get_field_value('site_global_mobile_icon', 'options'); ?>
    <?php if($mobile_icon) : ?>
    <link href="<?php echo $mobile_icon; ?>" rel="apple-touch-icon" />
    <?php else : ?>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png"
        rel="apple-touch-icon" />
    <?php endif; ?>

    <meta name="msapplication-TileColor" content="#f01d4f">
    <meta name="msapplication-TileImage"
        content="<?php echo get_template_directory_uri(); ?>/assets/images/win8-tile-icon.png">
    <meta name="theme-color" content="#121212">
    <?php } ?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c8ebe26dd2.js" crossorigin="anonymous"></script>
    <!-- Font Awesome -->


    <?php 
			$google_map_api_key = _get_field_value('opt_google_api', 'options');
			$google_map_api_key = $google_map_api_key ? $google_map_api_key : 'AIzaSyBrFsdUZxr4tgv-sLk6OdtI1qtR813pSbI';
		?>
    <?php if($google_map_api_key) : ?>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_api_key; ?>&libraries=places"
        type="text/javascript"></script>
    <?php endif; ?>
    <?php wp_head(); ?>

    <!-- Sharing Meta Data -->
    <?php if(_get_field_value('g_site_og_image','options')) : ?>
    <meta property="og:image" content="<?php echo _get_field_value('g_site_og_image','options'); ?>" />
    <meta name="twitter:image" content="<?php echo _get_field_value('g_site_og_image','options'); ?>" />
    <?php else: ?>
    <meta property="og:image" content="<?php echo _get_field_value('g_site_logo','options'); ?>" />
    <meta name="twitter:image" content="<?php echo _get_field_value('g_site_logo','options'); ?>" />
    <?php endif; ?>
    <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />

    <?php
			$custom_css_code = _get_field_value('g_site_custom_css','options');
			if($custom_css_code) {
				echo "<style>".$custom_css_code."</style>";
			}

			$head_script = _get_field_value('g_site_head_code','options'); 
			if($head_script) {
				echo $head_script;
			}

			if( is_singular('location') && _get_field_value("ls_location_custom_design", "options") ){
				$location_head_script = _get_field_value('head_code'); 
				if($location_head_script) {
					echo $location_head_script;
				}
			} elseif( ( is_singular('location_post') || is_singular('location_page') ) && _get_field_value("ls_location_custom_design", "options") ) {
				$parent_id = _get_field_value('link_to_location');
				$location_head_script = _get_field_value('head_code', $parent_id); 
				if($location_head_script) {
					echo $location_head_script;
				}
			} 
		?>
</head>

<body <?php body_class(); ?>>

    <?php 
            //Body Script from Site Settings Advance > Body Code
			$body_script = _get_field_value('g_site_body_code','options');
			
			if($body_script) : 
				echo $body_script; 
			endif;

			if( is_singular('location') && _get_field_value("ls_location_custom_design", "options") ){
				$location_body_script = _get_field_value('body_code');
				if($location_body_script) : 
					echo $location_body_script; 
				endif;
			} elseif( ( is_singular('location_post') || is_singular('location_page') ) && _get_field_value("ls_location_custom_design", "options") ) {
				$parent_id = _get_field_value('link_to_location');
				$location_body_script = _get_field_value('body_code', $parent_id); 
				if($location_body_script) {
					echo $location_body_script;
				}
			} 
        ?>

    <div class="off-canvas-wrapper">

        <!-- Load off-canvas container. Feel free to remove if not using. -->
        <?php get_template_part( 'parts/content', 'offcanvas' ); ?>

        <div class="off-canvas-content" data-off-canvas-content>

            <header class="header <?php echo _get_field_value('opt_header_layout','options'); ?>" role="banner">
                <?php 
						$show_top_header = false;
						if( (is_singular('location') || is_singular('location_post') || is_singular('location_page') ) && _get_field_value("ls_location_custom_design", "options") ){
							$show_top_header = _get_field_value('ls_show_top_header','options');
							$top_header_cols = _get_field_value('ls_top_header_cols','options');
							$top_column1_elements = _get_field_value('ls_top_header_col_1','options');
							$col_1_type = isset($top_column1_elements['element']) ? $top_column1_elements['element'] : ''; 
							$top_column2_elements = _get_field_value('ls_top_header_col_2','options'); 
							$col_2_type = isset($top_column2_elements['element']) ? $top_column2_elements['element'] : '';
							$col_1_size = $col_1_type == 'contact-information' ? 'medium-9' : ($col_2_type == 'contact-information' ? 'medium-3' : '');
							$col_2_size = $col_2_type == 'contact-information' ? 'medium-9' : ($col_1_type == 'contact-information' ? 'medium-3' : '');
						} else {
							$show_top_header = _get_field_value('g_site_show_top_header','options');
							$top_header_cols = _get_field_value('g_site_top_header_cols','options');
							$top_column1_elements = _get_field_value('g_site_top_header_col_1','options');
							$col_1_type = isset($top_column1_elements['element']) ? $top_column1_elements['element'] : ''; 
							$top_column2_elements = _get_field_value('g_site_top_header_col_2','options'); 
							$col_2_type = isset($top_column2_elements['element']) ? $top_column2_elements['element'] : '';
							$col_1_size = $col_1_type == 'contact-information' ? 'medium-9' : ($col_2_type == 'contact-information' ? 'medium-3' : '');
							$col_2_size = $col_2_type == 'contact-information' ? 'medium-9' : ($col_1_type == 'contact-information' ? 'medium-3' : '');
						}
					?>
                <?php if($show_top_header) : ?>
                <div class="top-header <?php echo $top_header_cols; ?>">
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="cell small-6">
                                <?php  
											set_top_elements($top_column1_elements);
										?>
                            </div>
                            <?php if( $top_header_cols == 'two-column') : ?>
                            <div class="cell small-6">
                                <?php 
												set_top_elements($top_column2_elements);
											?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php 
						function set_top_elements($top_element = '') {
							switch ($top_element['element']) {
								case 'contact-information':
									hi_set_top_contact_info();
								break;
								case 'social-media':
									set_social_media();
								break;
								case 'top-menu':
									joints_top_menu();
								break;
								case 'text':
									hi_set_top_text($top_element);
								break;
								default:
									hi_set_top_contact_info();
								break;
							}
						}
					?>

                <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>

                <div id="getSampleWidgetContent">
                    <div class='widgetbox'>
                        <h3 class='uppercase'>
                            <button id="positionControl" class="button position-control"></button>
                            Samples Requested
                        </h3>
                        <div class='content'>
                            <div class='item-wrap'></div>
                            <button class='getSample button primary-button uppercase' data-fav-page='1'>Get
                                Samples</button>
                        </div>
                    </div>
                </div>

            </header> <!-- end .header -->