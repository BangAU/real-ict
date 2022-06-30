jQuery( document ).ready(function($){

    jQuery('.image-slider').each(function(index){
		var imgSliderID = 'project-image-slider-' + (index + 1);
		var thumbSliderID = 'project-thumb-slider-' + (index + 1);
		var imgSliderSelector = '#'+imgSliderID;
		var thumbSliderSelector = '#'+thumbSliderID;
		
		jQuery(this).attr('id', imgSliderID);
		jQuery(this).next().attr('id', thumbSliderID);
		
		var imgSlider = jQuery(imgSliderSelector);
		var thumbSlider = jQuery(thumbSliderSelector);
		
        imgSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            infinite: true,
            autoplay: true,
            asNavFor : thumbSliderSelector,
            fade : true,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 641,
                    settings: {
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,
                        dots: false,
                        arrows: true,
                        speed: 400,
                        autoplaySpeed: 6000,
                        asNavFor : thumbSliderSelector,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        asNavFor : thumbSliderSelector,
                    }
                }
        
             ]
    
    
        });


        thumbSlider.slick({
            slidesToShow : thumbSlider.data('slides-to-show'),
            slidesToScroll : 1,
            dots : thumbSlider.data('dots'),
            arrows : thumbSlider.data('arrows'),
            asNavFor : imgSliderSelector,
            centerMode : thumbSlider.data('center-mode'),
            centerPadding : '0%',
            focusOnSelect : true,
            infinite : true,
            responsive: [
                {
                    breakpoint: 641,
                    settings: {
                        slidesToShow : 3,
                        slidesToScroll : 1,
                        dots : thumbSlider.data('dots'),
                        arrows : thumbSlider.data('arrows'),
                        asNavFor : imgSliderSelector,
                        centerMode : thumbSlider.data('center-mode'),
                        centerPadding : '0%',
                        focusOnSelect : true,
                        infinite : true,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow : thumbSlider.data('slides-to-show'),
                        slidesToScroll : 1,
                        dots : thumbSlider.data('dots'),
                        arrows : thumbSlider.data('arrows'),
                        asNavFor : imgSliderSelector,
                        centerMode : thumbSlider.data('center-mode'),
                        centerPadding : '0%',
                        focusOnSelect : true,
                        infinite : true,
                    }
                }
        
             ]
        });
		imgSlider.on('beforeChange', function(event,slick,slide,nextSlide) {
			var device_width = jQuery(window).width();
			var thumbSlideLength = thumbSlider.find('.slick-slide').length;
			if( 
				(device_width >= 769 && thumbSlideLength <= thumbSlider.data('slides-to-show'))
				|| (device_width >= 641 && thumbSlideLength <= 3)
				|| (device_width < 641 && thumbSlideLength == 1)
			){
				thumbSlider.find('.slick-slide').removeClass('slick-current').eq(nextSlide).addClass('slick-current');
			}	
		});			
    });

    function imgResp() {
        var viewportWidth = jQuery(window).width();
        jQuery('.img-sld-responsive').each(function(){
            var elem = jQuery(this);
            var l = elem.attr('data-img-l');
            var m = elem.attr('data-img-m') ? elem.attr('data-img-m') : elem.attr('data-img-l');
            var s = elem.attr('data-img-s') ?  elem.attr('data-img-s') : elem.attr('data-img-m') ;
            
            
    
            //console.log( viewportWidth );
            if( viewportWidth > 1024 ) {
                elem.attr('src' , l );
            } else if ( viewportWidth > 641 ) {
                elem.attr('src' , m );
            } else {
                elem.attr('src' , s );
            }
        })
    }

    imgResp();

    jQuery(window).resize(function(){
        imgResp();
    });

});