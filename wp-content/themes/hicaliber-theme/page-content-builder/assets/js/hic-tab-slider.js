jQuery(document).ready(function($) {
    function tab_slider( elem, asForElem ) {
        
        elem.slick({
        	dots: false,
        	arrows: true,
        	infinite: false,
        	draggable: true,
        	autoplay: false,
        	dots: false,
        	slidesToShow: 6,
        	slidesToScroll: 1,
			asNavFor : asForElem.selector,
			variableWidth: true,
        	focusOnSelect : true,
        		responsive:[
        	 		{
        	 			breakpoint: 641, 
        	 				settings: {
        		        		 infinite: false,
        		        		 slidesToShow: 2,
        		        		 slidesToScroll: 1,
        		        		 autoplay: false, 
        		        		 dots: false,
        		        		 arrows: true,
        		        		 speed: 400,
								 asNavFor : asForElem.selector,
								 variableWidth: false,
        		        		 focusOnSelect : true,
        	 				}
        	 		},
        	 		{
        	 			breakpoint: 1024, 
        	 				settings: {
        		        		 infinite: false,
        		        		 slidesToShow: 4,
        		        		 slidesToScroll: 1,
        		        		 autoplay: false, 
        		        		 dots: false,
        		        		 arrows: true,
        		        		 speed: 400,
								 asNavFor : asForElem.selector,
								 variableWidth: true,
        		        		 focusOnSelect : true,
        	 				}
        	 		}
        	 	]
        });
        
        asForElem.slick({
        	dots: false,
        	arrows: false,
        	infinite: false,
        	draggable: false,
        	autoplay: false,
        	dots: false,
        	slidesToShow: 1,
        	slidesToScroll: 1,
        	asNavFor : elem.selector,
        	fade: true,
        	focusOnSelect : true,
        });
    }
    
    if( jQuery('.tab-slider').length > 0 ) {
        jQuery('.tab-slider').each(function(i,v){
            var elem = jQuery(this);
            var asForElem = jQuery('.tab-content-slider');
            
            tab_slider( elem, asForElem );
        
        });
    }

});