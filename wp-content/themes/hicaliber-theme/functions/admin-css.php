<?php


/*************************************************************
*
* Custom CSS site Settings
*
**************************************************************/

function _bg_color( $color ) {
	echo 'background-color:'.$color;
}
function _color( $color ) {
	echo 'color:'.$color;
}

function hicaliber_custom_css(){

	
	$font_heading = GS_COMMON::font_heading();
	$font_body = GS_COMMON::font_body();
	
	//Colours
	$brand_colour = _get_field_value('site_brand_colour','options');
	$secondary_background = _get_field_value('opt_secondary_background','options');
	$dark_background = _get_field_value('opt_dark_background','options');
	$grey_background = _get_field_value('opt_grey_background','options');
	
	//Button
	$primary_button_colour = _get_field_value('site_primary_button_colour','options');
	$primary_button_colour_hover = _get_field_value('site_primary_button_hover_colour','options');


	$dark_button_colour = _get_field_value('site_dark_button','options');
	$dark_button_colour_hover = _get_field_value('site_dark_button_hover','options');

	$theme = _get_field_value('g_site_main_theme', 'options');

	$custom_topheader_colour = _get_field_value('g_site_custom_header_colours', 'options');
	$topheader_colour = _get_field_value('g_site_top_header_background_color', 'options');
	$topheader_text_colour = _get_field_value('g_site_top_header_text_color', 'options');


ob_start();
?>
	<style>	

		
		<?php if( isset( $font_heading['local_urls'] ) && is_array($font_heading['local_urls']) ) : ?> 
			<?php if(count($font_heading['local_urls']) > 0 && $font_heading['font_family']) : ?>
			 	<?php foreach ($font_heading['local_urls'] as $localFont) : ?>
					<?php if(isset($localFont['url']) ? $localFont['url'] : false  ) : ?>
						@font-face{
							font-family: '<?php echo $font_heading['name'] . (isset($localFont['weight']) ? ' ' . $localFont['weight'] : '' ) . (isset($localFont['style']) ? ' ' . $localFont['style'] : '' ); ?>';
							src: url(<?php echo $localFont['url']; ?>);
							<?php if(isset($localFont['weight'])) : ?>
								font-weight: <?php echo $localFont['weight']; ?>;
							<?php endif; ?>
							<?php if(isset($localFont['style'])) : ?>
								font-style: <?php echo $localFont['style']; ?>;
							<?php endif; ?>
						}
					<?php endif; ?> 
				<?php endforeach; ?>
			<?php endif; ?> 
		<?php endif; ?> 
		
		<?php if( isset( $font_body['local_urls'] ) && is_array($font_body['local_urls']) ) : ?> 
			<?php if(count($font_body['local_urls']) > 0 && isset($font_body['font_family']) ? $font_body['font_family'] : false ) : ?>
			 	<?php foreach ($font_body['local_urls'] as $localFont) : ?>
					<?php if(isset($localFont['url']) ? $localFont['url'] : false  ) : ?>
						@font-face{
							font-family: '<?php echo $font_body['name'] . (isset($localFont['weight']) ? ' ' . $localFont['weight'] : '' ) . (isset($localFont['style']) ? ' ' . $localFont['style'] : '' ); ?>';
							src: url(<?php echo $localFont['url']; ?>);
							<?php if(isset($localFont['weight'])) : ?>
								font-weight: <?php echo $localFont['weight']; ?>;
							<?php endif; ?>
							<?php if(isset($localFont['style'])) : ?>
								font-style: <?php echo $localFont['style']; ?>;
							<?php endif; ?>
						}
					<?php endif; ?> 
				<?php endforeach; ?>
			<?php endif; ?> 
		<?php endif; ?> 


		<?php if( isset($font_body['font_family']) ? $font_body['font_family'] != 'custom' : false ) : ?>
		body {
			font-family : <?php echo $font_body['font_family'] ?>;						
		}		
		<?php endif; ?>

        <?php if( isset($font_body['font_family']) ? $font_body['font_family'] != 'custom' : false ) : ?>
		h1, h2, h3, h4, h5, h6 {
			font-family : <?php echo $font_heading['font_family']; ?>;
		}
		<?php endif; ?>

		<?php $user = wp_get_current_user();

		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			if( in_array( 'user-location' , $user->roles ) ) : ?>
				#wp-admin-bar-new-location {
					display: none;
				}
			<?php
			endif;
		} ?>

		<?php if($primary_button_colour) : ?>
			.button,
			.wp-block-button__link:not(.has-background),
			.woocommerce #respond input#submit, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button,
		.woocommerce-page .page-elements .woocommerce a.button, 
		.woocommerce-page .page-elements .woocommerce button.button,
		.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, 
		.woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce button.button.alt.disabled {
				<?php _bg_color($primary_button_colour); ?>
			}

		.property-gallery-element .section-title{
			<?php _bg_color($primary_button_colour); ?>
		}
		<?php endif; ?>
		

		<?php if($brand_colour) : // start brand_colour ?>
		.header-theme .header,
		.header-theme .header .top-header,
		.off-canvas .menu>li.active > a,
		.footer-theme .footer,
		.subscription-term input[type="radio"]:checked+label, 
		.subscription-term li label:hover {
			<?php _bg_color($brand_colour); ?>
		}

		.prod-badge{
			<?php _bg_color($brand_colour); ?>
		}

		.hic-item-list .pager-column .page-numbers.current {
    		<?php _bg_color($brand_colour); ?>;
		}
		
		.modal-element.full-screen-layout.theme-section {
		    <?php echo hi_rgb($brand_colour, 95); ?>;
		}
    	
		.second-theme-section,
		.header-secondary .header,
		.header-secondary .header .top-header {
		    <?php _bg_color($secondary_background); ?>;
		}

		.modal-element.full-screen-layout.second-theme-section {
		    <?php echo hi_rgb($secondary_background, 95); ?>;
		}

		.dark-section,
		.footer-dark .footer,
		.header-dark .header, 
		.header-dark .header .top-header {
		    <?php _bg_color($dark_background); ?>;
		}

		.modal-element.full-screen-layout.dark-section {
			<?php echo hi_rgb($dark_background, 95); ?>;
		}

		.bottom-footer {
		     <?php echo hi_rgb($dark_background,90) ;  ?>
		}
		.grey-section {
		    <?php _bg_color($grey_background); ?>;
		}

		.modal-element.full-screen-layout.grey-section {
			<?php echo hi_rgb($grey_background, 95); ?>;
		}
		
		body:not(.footer-theme) .footer a:hover,
		body:not(.footer-theme) .footer a:focus,
		body:not(.footer-theme) .footer .menu a:hover,
		.page-element:not(.has-bg-img):not(.theme-section) .section-title span,
		.content-box-icon,
		.hero a:not(.button),
		a,
		.hero-slider .slick-dots li.slick-active button::before,
		.hero-slider .slick-dots li button:hover:before,
		.contact-details svg,
		.testomnial-main-content:before,
		.testomnial-main-content:after,
		body:not(.footer-theme) .footer .menu li.active a,
		.property-item .price_wrap,
		.footer .footer-layout-3 h4,
		.product-feature-icon svg,
		body:not(.header-theme) .header .menu li.active > a, 
		.header-light .header .menu li.active > a,
		body:not(.header-theme) .header .menu:not(.submenu) > :not(.menu-button) > a:hover,
		.dropdown.menu.medium-horizontal > li.is-dropdown-submenu-parent.active > a::after, .dropdown.menu.medium-horizontal > li.is-dropdown-submenu-parent > a:hover:after, 
		.header-light .header .menu a:hover,		
		 .testimonial-rating .fa-star,
		 .header-theme-inv .header .menu li > a:hover,
		 .header-theme-inv .header .menu li.active a,
		 .close_side::before,
		 .default-section .hic-icon, .theme-title .hic-title h3,
		 .sidebar ul li.active > a,
		 .sidebar .menu li.active > a {
			<?php _color($brand_colour); ?>
		}

		.primary-theme-boxes .hic-box {
			<?php _bg_color($brand_colour); ?>
		}

		.isotope-nav li.active,
		.isotope-nav li:hover,
		.custom-isotope-nav li.active,
		.custom-isotope-nav li:hover {
			<?php _bg_color($brand_colour); ?>
		}

		.hic-sitemap.sitemap-layout-1 .hic-title{
  			border-color: <?php echo $brand_colour; ?>;
		}
		
		.primary-text {
			<?php _color($brand_colour); ?> !important;
		}

		.theme-section,		
		.main-contact-form,
		.cnt-sec,
		#property_filters_options,
		 .header .top-bar .menu > li > a:before,
		.section-title:after,
		.header .menu .is-dropdown-submenu li a:hover, 
		.header .menu .is-dropdown-submenu li.active > a,
		.hero-form-container,
		.fancybox-progress,
		.pagination .current {
			<?php _bg_color($brand_colour); ?>
		}

		.property-gallery-element[data-gallery-layout="layout-1"] .tabs-title.is_active a{
			<?php _bg_color($brand_colour); ?>
		}
	
	    
        .accordion-title:hover,
        .is-active .accordion-title {
        	<?php _bg_color($brand_colour); ?>
        }
		.header .menu .menu-button a {
			<?php _bg_color($brand_colour); ?>
		}
		

		 .header .menu .is-dropdown-submenu li:hover,
		 .header .menu .is-dropdown-submenu li.active {
			<?php echo hi_rgb($brand_colour,85); ;  ?>
		}

		.product-listing .product.on-sale .hic-box:before{
			<?php echo hi_rgb($brand_colour,85); ;  ?>
		}
		
		
		.image-overlay-content .content-box:hover .content-box-overlay {
		    <?php echo hi_rgb($brand_colour,80) ;  ?>
		}
		.gallery-image:before {
		     <?php echo hi_rgb($brand_colour,76) ;  ?>
		}

		.contact-details [class*="contact-"]::before{
			<?php echo _color( $brand_colour ); ?>
		}

		.woocommerce-MyAccount-navigation ul li.is-active a, 
		.woocommerce-MyAccount-navigation ul li.is-active a:hover,
		.woocommerce-page .woocommerce table.shop_table thead th,
		table.wishlist-table thead th {
		  	<?php echo _bg_color( $brand_colour ); ?>
		}

		.woocommerce-message {
		    border-top-color: <?php echo $brand_colour; ?>;
		}

		.woocommerce-MyAccount-navigation ul li a:hover {
			<?php echo _color( $brand_colour ); ?>
		}

		<?php if($theme == 'layout-1'): ?>
		.layout-1.hic-tgs .header .contact-info svg path {
			fill: <?php echo $brand_colour; ?>;
		}

		.layout-1.hic-tgs .header .menu-container > .menu > li.active::before {
			<?php _bg_color($brand_colour); ?>;
		}

		.layout-1.hic-tgs .hero .hero-banner-form .form-wrapper{
			<?php echo _bg_color( $brand_colour ); ?>
		}

		.icon-left-content .hic-icon{
			<?php echo _color( $brand_colour ); ?>
		}

		.layout-1 .testimonials.default-section .inner-section{
			<?php echo _bg_color( $brand_colour ); ?>
		}
		.button {
			<?php echo _bg_color( $brand_colour ); ?>;
    		font-size: 16px;
    		font-weight: 400;
		}
		.layout-1 .button:hover,
		.layout-1 .button:focus {
			<?php echo _bg_color( $primary_button_colour_hover ); ?>;
		}
	
		.layout-1 .hero .button:not(.gform_button):hover  {
			<?php echo _bg_color( $brand_colour ); ?>;
			border-color: <?php echo $brand_colour; ?>; 
		}
		.layout-1 .button.video-button {
			<?php echo _bg_color( $brand_colour ); ?>
		}
		.layout-1.hic-tgs [class*="split-"].image-right-content.then-left .columns:nth-child(odd) .hic-content,
		.layout-1.hic-tgs [class*="split-"].image-left-content.then-right .columns:nth-child(even) .hic-content{
			<?php echo _bg_color( $brand_colour ); ?>
		}

		.layout-1.hic-tgs [class*="split-"].content-boxes.about .section-footer .button{
			<?php echo _bg_color( $brand_colour ); ?>
		}

		.layout-1.hic-tgs .has-bg-img .button.gform_button:hover {
			border-color: <?php echo $brand_colour; ?>;
			<?php echo _bg_color( $brand_colour ); ?>;
		}

		.layout-1.hic-tgs .main-contact-form svg:hover path {
			fill: <?php echo $brand_colour; ?>;
		}

		.layout-1.hic-tgs .main-contact-form a:hover {
			<?php echo _color( $brand_colour ); ?>
		}

		.layout-1.hic-tgs [class*="split-"].image-left-content.then-right .hic-content,
		.layout-1.hic-tgs [class*="split-"].image-right-content.then-left .hic-content{
			<?php echo _bg_color( $brand_colour ); ?>;
		}

		.pagination-page .prev, .pagination-page .next, .pagination .current{
			<?php echo _bg_color( $brand_colour ); ?>;
			border-color: <?php echo $brand_colour; ?>;
		}

		.pagination-page .prev:hover, .pagination-page .next:hover, .pagination .current:hover{
			<?php echo _color( $brand_colour ); ?>
		}

		.hic-tgs .burger-menu:after,
		.hic-tgs .burger-menu:before {
			<?php echo _bg_color( $brand_colour ); ?>;
		}

		.hic-tgs .burger-menu:after{
			box-shadow: 0 10px 0 <?php echo $brand_colour; ?>, 0 20px 0 <?php echo $brand_colour; ?>;
		}

		.hic-tgs .off-canvas .menu li.active a,
		.hic-tgs .off-canvas .menu li a:hover,
		.hic-tgs .off-canvas .menu li a:focus {
			<?php echo _bg_color( $brand_colour ); ?>
		}
		.banner-form-style-1 .hero .button.gform_button {
			<?php echo _bg_color( $brand_colour ); ?>;
		}

		.header .top-bar-right .menu .submenu li:hover,
		.header .top-bar-right .menu .submenu li.active {
			<?php echo _bg_color( $brand_colour ); ?> !important;
		}

		.fullscreen-menu-overlay.overlay-scale .menu > li.active > a {
			<?php echo _color( $brand_colour ); ?>
		}

		.image-grid .hic-image-container .hic-image::after {
			<?php echo hi_rgb($brand_colour,85) ;  ?>
		}

		.layout-1.hic-tgs [class*="split-"].image-right-content .section-footer .button-wrapper .button:hover{
			<?php echo _bg_color( $brand_colour ); ?>;
			border-color: <?php echo _color( $brand_colour ); ?>;
		}

		.general-form .gform_page_footer input[type="submit"],
		.general-form .gform_footer input[type="submit"]{
		    <?php echo _bg_color( $brand_colour ); ?>;
		}

		.dark-section a:hover, 
		.dark-section a:focus {
			<?php echo hi_rgb($brand_colour,60) ;  ?>
		}
		.hic-pricing-table.content-boxes .hic-title,
		.hic-pricing-table.theme-section .hic-box .button {
			<?php echo _bg_color( $brand_colour ); ?>;
		}
		
		.ui-datepicker-calendar td a:hover,
		.ui-datepicker-calendar td a.ui-state-active {
		    <?php echo _bg_color( $brand_colour ); ?>
		}

		<?php endif; // end theme layout 1?>
		<?php endif; // end brand_colour ?>

		<?php if($primary_button_colour_hover): // start primary_button_colour_hover ?>
		.button:hover,
		.button:focus,
		.slick-current .button.tab,
		.single-project .description-gallery .slick-arrow,
		.single-project .tabbed-content .slick-arrow,
		.woocommerce #respond input#submit:hover, 
		.woocommerce a.button:hover, 
		.woocommerce button.button:hover, 
		.woocommerce input.button:hover,
		.woocommerce-page .page-elements .woocommerce a.button:hover, 
		.woocommerce-page .page-elements .woocommerce button.button:hover,
		.woocommerce #respond input#submit.alt:hover, 
		.woocommerce a.button.alt:hover, 
		.woocommerce button.button.alt:hover, 
		.woocommerce input.button.alt:hover,
		.section-search-form .list-option li.active .button {
			<?php _bg_color($primary_button_colour_hover); ?>
		}

		.bpd.bpd_layout_5 .recent-post-button.button:hover, 
        .bpd.bpd_layout_5 .recent-post-button.button:focus,
        .bpd.bpd_layout_5 .content-boxes-1 .content-box-button:hover,
        .bpd.bpd_layout_5 .content-boxes-1 .content-box-button:focus{
            border: 1px solid <?php _e($primary_button_colour_hover); ?>;
            <?php _bg_color($primary_button_colour_hover); ?>
		}
		
		<?php endif; // end primary_button_colour_hover ?>

		<?php if($dark_button_colour) : // start dark_button_colour ?>
		.theme .button,
		.search-widget input[type="submit"],
		body .button-tab-section .btn-tab-opn,
		.gform_button.button,
		.button.btn-black {
			<?php _bg_color($dark_button_colour); ?>
		}
		<?php endif; // end dark_button_colour ?>

		<?php if($dark_button_colour_hover): // start dark_button_colour_hover ?>
		.theme .button:hover,
		.theme .button:focus,
		 .search-widget input[type="submit"]:hover,
		 .search-widget input[type="submit"]:focus,
		body .button-tab-section .btn-tab-opn.active,
		.gform_button.button:hover,
		.gform_button.button:focus,
		.button.btn-black:hover,
		.button.btn-black:focus {
			<?php _bg_color($dark_button_colour_hover); ?>
		}
		<?php endif; // end dark_button_colour_hover; ?>
		.codefix{}

		.header .top-bar .menu .active>a{
			border-color: <?php echo $brand_colour; ?>;
		}
		
		.subscription-term li label {
		    border-color: <?php echo $brand_colour; ?>;
		}
		.subscription-term li label,
		.package-features li:before,
		.pricing-table .hic-title h3 {
		    <?php echo _color( $brand_colour ); ?>
		}

		

		<?php if($custom_topheader_colour) : ?>
			.header .top-header,
			.header .top-header a {
				<?php _color($topheader_text_colour); ?>;
			}

			.header .top-header {
				<?php _bg_color($topheader_colour); ?>;
			}
		<?php endif; ?>
		
		@media (min-width: 641px){
			.header.header-layout-2 .top-bar .top-bar-right::before {
		        <?php echo _bg_color( $brand_colour ); ?>
		    }
		}
	</style>

<?php

$buffer_style = ob_get_clean();

// Minify CSS
$buffer_style = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer_style);
$buffer_style = str_replace(': ', ':', $buffer_style);
$buffer_style = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer_style);

echo $buffer_style;

}

function set_head_font_family(){
	$font = GS_COMMON::font_heading();
	if( isset( $font['url'] ) && $font['url'] != "") {
		echo '<link href="'.$font['url'] .'" rel="stylesheet">';
	}

}
function set_body_font_family(){
	$font = GS_COMMON::font_body();
	if( isset( $font['url'] ) && $font['url'] != "") {
		echo '<link href="'.$font['url'] .'" rel="stylesheet">';
	}

}

add_action( 'wp_head', 'hicaliber_custom_css', 100 );
add_action( 'wp_head', 'set_head_font_family', 4 );
add_action( 'wp_head', 'set_body_font_family', 5 );