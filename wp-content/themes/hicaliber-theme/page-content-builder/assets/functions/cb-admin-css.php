<?php
add_action('admin_head', 'hex_element_choices_styles');
 
function hex_element_choices_styles() {
     
 	 ?>
        <style>
            .acf-field-5b8e7a10e7e6a input,
            .acf-field-5bb360bba3398 input,
            .acf-field-5bac2c795ee2e input,
            .acf-field-57a7fa8f1bd05 input,
            .acf-field-5bb61ca2ab403 input,
            .acf-field-5bc081119b803 input,
            .acf-field-5bed78d6d49a1 input,
            [class*="acf-field-"][data-name="pe_g_select"] input{
           		display: none;
            }
            .acf-field-5b8e7a10e7e6a ul.acf-radio-list,
            .acf-field-5bb360bba3398 ul.acf-radio-list,
            .acf-field-5bac2c795ee2e ul.acf-radio-list,
            .acf-field-57a7fa8f1bd05 ul.acf-checkbox-list,
            .acf-field-5bb61ca2ab403 ul.acf-radio-list,
            .acf-field-5bc081119b803 ul.acf-radio-list,
            .acf-field-5bed78d6d49a1 ul.acf-radio-list,
            [class*="acf-field-"][data-name="pe_g_select"] ul.acf-radio-list{
            	display: flex;
                flex-wrap: wrap;
            	
            }
            .acf-field-5b8e7a10e7e6a ul.acf-radio-list li,
            .acf-field-5bb360bba3398 ul.acf-radio-list li,
            .acf-field-5bac2c795ee2e ul.acf-radio-list li,
            .acf-field-5bc081119b803 ul.acf-radio-list li,
            .acf-field-5bed78d6d49a1 ul.acf-radio-list li,
            [class*="acf-field-"][data-name="pe_g_select"] ul.acf-radio-list li{
            	margin-bottom: 24px;
            	width: 170px;
            }

            .acf-field-57a7fa8f1bd05 ul.acf-checkbox-list li,
            .acf-field-5bb61ca2ab403 ul.acf-radio-list li {
                  margin-bottom: 24px;
                  width: 120px;  
            }

            .acf-field-5b8e7a10e7e6a ul.acf-radio-list .pe-choices-container,
            .acf-field-5bb360bba3398 ul.acf-radio-list .pe-choices-container,
            .acf-field-5bac2c795ee2e ul.acf-radio-list .pe-choices-container,
            .acf-field-57a7fa8f1bd05 ul.acf-checkbox-list .pe-choices-container,
            .acf-field-5bb61ca2ab403 ul.acf-radio-list .pe-choices-container,
            .acf-field-5bc081119b803 ul.acf-radio-list .pe-choices-container,
            .acf-field-5bed78d6d49a1 ul.acf-radio-list .pe-choices-container,
            [class*="acf-field-"][data-name="pe_g_select"] ul.acf-radio-list .pe-choices-container{
            	position: relative;
            	 transition: all .15s ease;
            	 text-align: center;
            }
            
             .acf-field-5b8e7a10e7e6a ul.acf-radio-list .pe-choices-container:before,
             .acf-field-5bb360bba3398 ul.acf-radio-list .pe-choices-container:before,
             .acf-field-5bac2c795ee2e ul.acf-radio-list .pe-choices-container:before,
             .acf-field-57a7fa8f1bd05 ul.acf-checkbox-list .pe-choices-container:before,
             .acf-field-5bb61ca2ab403 ul.acf-radio-list .pe-choices-container:before,
             .acf-field-5bc081119b803 ul.acf-radio-list .pe-choices-container:before,
             .acf-field-5bed78d6d49a1 ul.acf-radio-list .pe-choices-container:before,
             [class*="acf-field-"][data-name="pe_g_select"] ul.acf-radio-list .pe-choices-container:before{
             	content: '';
             	background-image: url(<?php echo ASSETS_IMG.'element-images/'.'check-icon.png'; ?>);
         	    height: 29px;
			    background-size: contain;
			    width: 29px;
			    display: block;
			    position: absolute;
			    top: -6px;
			    right: -9px;
			    opacity: 0;
			    transform: scale(0.6);
			    transition: all .25s ease-in-out;
				 z-index: 2;
             }
             
             .acf-field-5b8e7a10e7e6a ul.acf-radio-list .selected .pe-choices-container:before,
             .acf-field-5bb360bba3398 ul.acf-radio-list .selected .pe-choices-container:before,
             .acf-field-5bac2c795ee2e ul.acf-radio-list .selected .pe-choices-container:before,
             .acf-field-57a7fa8f1bd05 ul.acf-checkbox-list .selected .pe-choices-container:before,
             .acf-field-5bb61ca2ab403 ul.acf-radio-list .selected .pe-choices-container:before,
             .acf-field-5bc081119b803 ul.acf-radio-list .selected .pe-choices-container:before,
             .acf-field-5bed78d6d49a1 ul.acf-radio-list .selected .pe-choices-container:before,
             [class*="acf-field-"][data-name="pe_g_select"] ul.acf-radio-list .selected .pe-choices-container:before{
            	opacity: 1;
            	transform: scale(1);
            }
            .acf-field-5b8e7a10e7e6a .selected img,
            .acf-field-5b8e7a10e7e6a .pe-choices-container:hover img,
            .acf-field-5bb360bba3398 .selected img,
            .acf-field-5bb360bba3398 .pe-choices-container:hover img,
            .acf-field-5bac2c795ee2e .selected img,
            .acf-field-5bac2c795ee2e .pe-choices-container:hover img,
            .acf-field-57a7fa8f1bd05 .selected img,
            .acf-field-57a7fa8f1bd05 .pe-choices-container:hover img,
            .acf-field-5bb61ca2ab403 .selected img,
            .acf-field-5bb61ca2ab403 .pe-choices-container:hover img,
            .acf-field-5bc081119b803 .selected img,
            .acf-field-5bc081119b803 .pe-choices-container:hover img,
            .acf-field-5bed78d6d49a1 .selected img,
            .acf-field-5bed78d6d49a1 .pe-choices-container:hover img,
            [class*="acf-field-"][data-name="pe_g_select"] .selected img,
            [class*="acf-field-"][data-name="pe_g_select"] .pe-choices-container:hover img{
            	box-shadow: 0 2px 8px 0 rgba(0,0,0, .2);
            }
            
            .acf-field-5b8e7a10e7e6a .selected img,
            .acf-field-5b8e7a10e7e6a .pe-choices-container:hover,
            .acf-field-5bb360bba3398 .selected img,
            .acf-field-5bb360bba3398 .pe-choices-container:hover,
            .acf-field-5bac2c795ee2e .selected img,
            .acf-field-5bac2c795ee2e .pe-choices-container:hover,
            .acf-field-57a7fa8f1bd05 .selected img,
            .acf-field-57a7fa8f1bd05 .pe-choices-container:hover,
            .acf-field-5bb61ca2ab403 .selected img,
            .acf-field-5bb61ca2ab403 .pe-choices-container:hover,
            .acf-field-5bc081119b803 .selected img,
            .acf-field-5bc081119b803 .pe-choices-container:hover,
            .acf-field-5bed78d6d49a1 .selected img,
            .acf-field-5bed78d6d49a1 .pe-choices-container:hover,
            [class*="acf-field-"][data-name="pe_g_select"] .selected img,
            [class*="acf-field-"][data-name="pe_g_select"] .pe-choices-container:hover{
            	opacity: 1;
            }
             .acf-field-5b8e7a10e7e6a img,
             .acf-field-5bb360bba3398 img,
             .acf-field-5bac2c795ee2e img,
             .acf-field-5bc081119b803 img,
             .acf-field-5bed78d6d49a1 img,
             [class*="acf-field-"][data-name="pe_g_select"] img{
             		width: 170px;
             		opacity: .5;
             }

             .acf-field-57a7fa8f1bd05 img,
             .acf-field-5bb61ca2ab403 img{
                        width: 120px;
                        opacity: .5;
             }

             .acf-field-5b8e7a10e7e6a .element-label,
             .acf-field-5bb360bba3398 .element-label,
             .acf-field-5bac2c795ee2e .element-label,
             .acf-field-57a7fa8f1bd05 .element-label,
             .acf-field-5bb61ca2ab403 .element-label,
             .acf-field-5bc081119b803 .element-label,
             .acf-field-5bed78d6d49a1 .element-label,
             [class*="acf-field-"][data-name="pe_g_select"] .element-label{
             	text-transform: uppercase;
             	    font-weight: 600;
             } 
             
             .acf-field-flexible-content  .acf-fc-layout-handle span.disabled_element {
                color: white;
                background-color: #ca4a1f;
                position: absolute;
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                padding-left: 36px;
                display: flex;
                align-items: center;
                text-transform: uppercase;
            }

            .acf-field-flexible-content  .acf-fc-layout-handle span.acf-fc-layout-order {
                z-index: 1;
                position: relative;
            }

            #the-list .type-product .thumbnail.column-thumbnail,
            #the-list .type-product .featured.column-featured,
            th.manage-column.column-thumbnail,
            th.manage-column.column-featured{
                text-align: center;
            }

            th.manage-column.column-thumbnail{
                width: 50px;
            }

            th.manage-column.column-featured {
                width: 100px;
            }

            th.manage-column.column-thumbnail span::after,
            th.manage-column.column-featured span::after {
                position: absolute;
                background-color: rgba(0,0,0,.85);
                color: #fff;
                font-size: 12px;
                padding: 6px;
                border-radius: 4px;
                bottom: -15px;
                left: 10px;
                box-sizing: border-box;
                display: none;
            }

            th.manage-column.column-thumbnail span::after {
                content: 'Image';
            }

            th.manage-column.column-featured span::after {
                content: 'Featured';
            }

            th.manage-column.column-thumbnail span:hover::after,
            th.manage-column.column-featured span:hover::after {
                display: block;
            }

            th.manage-column.column-thumbnail span,
            th.manage-column.column-featured span {
                position: relative;
            }

            th.manage-column.column-thumbnail span:before,
            th.manage-column.column-featured span:before {
                font-size: 14px;
            }

            <?php if(!class_exists( 'RL' )) : ?>
                .acf-field-5a091a9649f51, .acf-field-5d95fa4f2776e, .acf-field-5d95fa4f2776f, .acf-field-5b02a7dce4c19, .acf-tab-button[data-key="field_5b02a76fe4c17"]{
                    display: none;
                }
            <?php endif; ?>

            <?php 
            $role = "";
            $user = wp_get_current_user();
            $location = get_user_meta(  $user->ID , 'user_location', true );	
            if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
                if( in_array( 'user-location' , $user->roles ) && $location ) { ?>
                    #acf-group_5b581d4b4f175{
                        display: none !important;
                    }
                <?php }
            } ?>
        </style>
        <?php
   
}