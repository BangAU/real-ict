(function ($) {
    
    var APP = {

        init: function (settings) {            

            // Select Post
            APP.hic_select_post();
            APP.hic_set_lightbox();
            APP.search_category_input();
            APP.isotope();
            APP.custom_button_isotope_filter();
            APP.hic_set_mobile_accordion();
            APP.foundation_mobile_menu_fix();
            APP.gallery_slider_with_thumb();
            APP.pcb_gallery_slider();
            APP.hic_site_map_accordion();

            //Merged
            APP.hic_loadmore();
            APP.hic_scripts();
            APP.gform_post_render();
            APP.hero_video_autoplay_fix();

            //To be refactored if needed to be added again
            //APP.hic_gravity_form_custom_script();
        },

        hero_video_autoplay_fix : function(){
            Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
                get: function () {
                    return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
                }
            });
            
            $('body').on('click touchstart', function () {
                const videoElement = document.getElementById('hero_bgvid');
                if(videoElement != null){
                    if (videoElement.playing) {}
                    else { videoElement.play(); }
                }
            });
        },

        hic_site_map_accordion : function(){
            $('.hic-sitemap.sitemap-style-2 .sitemap-items .page_item_has_children').append('<i class="far fa-angle-down"></i>');
            $('.hic-sitemap.sitemap-style-2 .sitemap-items .page_item_has_children i').on('click', function(){
                $(this).parent().find(".children").slideToggle( "slow" );
                $(this).parent().toggleClass('active');
            });
        },

        custom_button_isotope_filter : function() {
            if( $('.custom-isotope-nav').length){
                $('.custom-isotope-nav').each( function(){ 
                    var nav = $(this);
                    var target = nav.data('listing_selector');
                    
                    if($(target).length>0){
                        var footer = $(target).siblings('.section-footer');
                        var loadmore = nav.data('loadmore');
                        var lmObj = loadmore ? loadmore.split(",") : []; 
                        var loadmoreLabel = lmObj[0] != undefined ? lmObj[0] : 'Load more';
                        var initShow = lmObj[1] != undefined ? Number(lmObj[1]) : 12; //number of items loaded on init & onclick load more button
                        var counter = lmObj[2] ? Number(lmObj[2]) : 4; //counter for load more button

                        let $grid = $(target).isotope({});

                        nav.on( 'click', 'li', function() {
                            counter = lmObj[2] ? Number(lmObj[2]) : 4;
                            var filterValue = "";
                            nav.find('li').removeClass('active');
                            $(this).addClass('active');
            
                            nav.find("li.active").each( function (){
                                filterValue += $(this).attr('data-filter');
                            });
                            
                            $grid.isotope({ filter: filterValue });

                            if(loadmore){
                                loadMore(initShow);
                            }
                        });

                        //****************************
                        // Isotope Load more button
                        //****************************
                        var iso = $grid.data('isotope'); // get Isotope instance
                        
                        loadMore(initShow); //execute function onload
                        
                        function loadMore(toShow) {
                            $grid.find(".hidden").removeClass("hidden");
                            
                            var visibleElems = iso.filteredItems.slice(0, toShow).map(function(item) {
                                    return item.element;
                            });
                            
                            var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
                                    return item.element;
                            });
                        
                            $(hiddenElems).addClass('hidden');

                            $(visibleElems).find("a").each(function(){
                                var a_el = $(this);
                                if( is_image_link(a_el) && a_el.attr('data-fancybox') == undefined ){
                                    a_el.attr('data-fancybox', 'cb-gallery-filter')
                                    .attr('data-type', 'image')
                                    .attr('rel', 'gallery')
                                    .attr('data-thumbnail', a_el.attr('href'));
                                }
                            });
                            
                            $(visibleElems).find("a[data-fancybox]").fancybox();

                            $grid.isotope('layout');
                            
                            //when no more to load, hide show more button
                            if(footer.length == 0){ 
                                if (hiddenElems.length == 0) {
                                    $(target).siblings('.section-footer').hide();
                                } else {
                                    $(target).siblings('.section-footer').show();
                                }
                            } else {
                                if (hiddenElems.length == 0) {
                                    $("#load-more").hide();
                                } else {
                                    $("#load-more").show();
                                }
                            }
                        }

                        function is_image_link(link){
                            return  link.attr('href') ? (
                                        link.attr('href').includes('.jpg') || 
                                        link.attr('href').includes('.jpeg') || 
                                        link.attr('href').includes('.png')
                                    ) : false
                        }
                        
                        if(loadmore){
                            var FooterSectionHtml ="";
                            var loadmoreButtonHtml = '<button class="button" id="load-more">' + loadmoreLabel + '</button>';
                            
                            if(footer.length == 0){
                                FooterSectionHtml = '<div class="grid-x grid-padding-x section-footer">';
                                FooterSectionHtml += '<div class="cell">';
                                FooterSectionHtml += '<div class="hic-button-wrap">' + loadmoreButtonHtml + '</div>';
                                FooterSectionHtml += '</div>';
                                FooterSectionHtml += '</div>';

                                //append load more button
                                $grid.after(FooterSectionHtml);
                            } else {
                                footer.find('.hic-button-wrap').append(loadmoreButtonHtml);
                            }
                            
                            //when load more button clicked
                            $("#load-more").on("click", function() {
                                counter = counter + initShow;
                                loadMore(counter);
                            });
                        }
                    }
                });
            }
        },

        isotope : function() {
          
    
            if( $('.isotope-nav').length){
                
                $('.isotope-nav').each( function(){
                    var nav = $(this);
                    var navPageElement = nav.closest('.page-element');

                    let $grid = navPageElement.find('.section-body').isotope({});
                               
                    nav.on( 'click', 'li', function() {
                        var filterValue = "";
                        nav.find('li').removeClass('active');
                        $(this).addClass('active');

                        navPageElement.find(".isotope-nav li.active").each( function (){
                            filterValue += $(this).attr('data-filter');
                        });
                        
                        $grid.isotope({ filter: filterValue });
            
                    });
                });
            }  

            if( $('.isotope-select').length){
                
                $('.isotope-select').each( function(){
                    var nav = $(this);
                    var navPageElement = nav.closest('.page-element');

                    let $grid = navPageElement.find('.section-body').isotope({});
                               
                    nav.on( 'change', function() {
                        var filterValue = "";

                        navPageElement.find(".isotope-select").each( function (){
                            filterValue += $(this).children("option:selected").val();
                        });
                        
                        $grid.isotope({ filter: filterValue });
            
                    });
                });
            } 
            
        },

        search_category_input: function () {
            $('.search-category-input').on('click', function(){
                var el = $(this);
                var elNameTarget = el.attr('data-target-field-hidden');
                
                var selectedCat = $('input[data-target-field-hidden='+elNameTarget+']:checked').map(function () {  
                    return this.value;
                }).get().join(',');
                                        
                
                $('input[name="'+elNameTarget+'"]').val(selectedCat);
            });
        },

        // Select Post Function
        hic_select_post: function () {
            $('.hic-select-post').on('change', function() {
                var el = $(this);
                var url = $(this).find(":selected").val();              
                window.location.replace(url);
            });
        },  

        hic_set_lightbox: function () {

            var lightboxid = 1;
        
            $(".with-lightbox").each(function(){
                APP.generate_fancybox_gallery(lightboxid, $(this).find('.image-list:not(.slick-cloned) a'));
                lightboxid = lightboxid + 1;
            });
                           
        },

        hic_set_mobile_accordion: function() {

            //to refactor

            $( ".primary-sidebar .grid-x>.cell" ).prepend( "<div class='custom-mobile-menu'>Menu<i class= 'menu-icon burger-menu'></i></div>" );

           $('.primary-sidebar .sidebar-content').hide();

           $('.custom-mobile-menu').click(function(){
               
               $('.primary-sidebar .sidebar-content').slideToggle("slow");
           });

           $( ".child-page-menu .grid-container >.grid-x>.cell" ).prepend( "<div class='custom-mobile-menu'>Menu<i class= 'menu-icon burger-menu'></i></div>" );

           $('.child-page-menu .menu').hide();
   
           $('.custom-mobile-menu').click(function(){
               
               $('.child-page-menu .menu').slideToggle("slow");
           });
           
           $( "#hic-search-filter-form" ).prepend( "<div class='custom-mobile-menu filter-menu'>Filter<i class= 'menu-icon burger-menu'></i></div>" );

           $('#hic-search-filter-form .widget-form-inner-wrap').hide();
   
           $('.filter-menu').click(function(){
               
               $('#hic-search-filter-form .widget-form-inner-wrap').slideToggle("slow");
           });

        },

        hic_gravity_form_custom_script: function() {

            $('.gform_wrapper .gform_page_footer .button, .gform_wrapper .gform_footer .button').on('click', function(){

                var base_url = window.location.origin;
                var host = window.location.host;
                var pathArray = window.location.pathname.split( '/' );
                var basePath = "";

                var testHostRegEx = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|localhost$/
                if(testHostRegEx.test(host)){
                    basePath = base_url + "/" + pathArray[1];
                } else {
                    basePath = base_url;
                }

                /*_this.die('click');
                _this.css('background-size', '24px');
                _this.css('background-repeat', 'no-repeat');
                _this.css('background-position', '94% 50%');
                _this.prop('disabled',true);
                _this.css('background-image', 'url('+ basePath + '/wp-content/themes/hicaliber-theme/assets/images/loader.gif)');*/
                
                // _this.val('Submitting...');

                // _this.attr('disabled', 'disabled');// using this will stop the form from submitting
                // _this.closest('form').submit();// this will make sure that it submits

            });


             $('.search-widget.filter-form select').on('change', function(){
                $(this).closest('form').submit();
            });
        },

        foundation_mobile_menu_fix: function() {

            if (Foundation.MediaQuery.is('small')) {
                $('.is-accordion-submenu-parent > a').prop("onclick", null).off("click");
                $('.is-accordion-submenu-parent').prepend('<i class="far fa-angle-right"></i>');
                $('.is-accordion-submenu-parent > i').on("click", function(){
                    var $this = $(this).parent();
                    $this.toggleClass('is-active');
                    $this.children('.far').toggleClass('fa-angle-right fa-angle-down');
                    $this.children('.vertical.submenu').slideToggle();
                }); 
            }
        },

        gallery_slider_with_thumb: function() {
            
            $('.carousel .gallery-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                asNavFor : '.gallery-thumb-slider',
                fade : true,
                adaptiveHeight: true,
                dots: false,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 641,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: true,
                            asNavFor : '.gallery-thumb-slider',
                            fade : true,
                            adaptiveHeight: true,
                            dots: false,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: true,
                            asNavFor : '.gallery-thumb-slider',
                            fade : true,
                            adaptiveHeight: true,
                            dots: false,
                            arrows: false,
                        }
                    }
            
                 ]
        
        
            });
        
            $('.carousel .gallery-thumb-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                asNavFor : '.gallery-slider',
                centerMode : true,
                centerPadding : '32%',
                focusOnSelect: true,
                 responsive: [
                    {
                        breakpoint: 641,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false,
                            asNavFor : '.gallery-slider',
                            centerMode : true,
                            centerPadding : '29.33%',
                            focusOnSelect: true,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: false,
                            asNavFor : '.gallery-slider',
                            centerMode : true,
                            centerPadding : '30%',
                            focusOnSelect: true,
                        }
                    },        
                 ]
            });
            
        },

        pcb_gallery_slider: function() {
            $('.pcb-gallery-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,                
                infinite: true,
                autoplay: false,              
                fade : false,                
                dots: true,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 641,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: false,                            
                            fade: false,                            
                            dots: false,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,                            
                            infinite: true,
                            autoplay: false,                            
                            fade : false,                            
                            dots: true,
                            arrows: true,
                        }
                    },
                 ]
            });
        
            
        },

        //Merged
        hic_loadmore: function(){
            // ---------------- JS Generic Loadmore --------------------- //
            var article_list = $(".article-list.load-more-list");
            var article_list_item = article_list.find('.article-item');
            var article_per_page = article_list.attr('data-per-page');
            var article_load_more_button = $(".article-list.load-more-list + .section-footer .load-more-button.button");

            article_list_item.css('display', 'none');
            article_list_item.slice(0, article_per_page).show();
            if($(".article-list.load-more-list .article-item:hidden").length <= 0){
                article_load_more_button.css('display', 'none');
            }

            article_load_more_button.on('click', function (e) {
                e.preventDefault();
                var article_hidden_items = $(".article-list.load-more-list .article-item:hidden");
                
                article_hidden_items.slice(0, article_per_page).slideDown();
                if (article_hidden_items.length <= article_per_page) {
                    $(this).attr('display', 'none');
                }
                if($(".article-list.load-more-list .article-item:hidden").length <= 0){
                    article_load_more_button.css('display', 'none');
                }
                $('body,html').animate({
                    scrollTop: $(this).offset().top
                }, 1500);
            });

            var list = $(".hic-item-list.load-more-list");
            var list_item = list.find('.hic-item');
            var per_page = list.attr('data-per-page');
            var load_more_button = $(".hic-item-list.load-more-list + .section-footer .load-more-button.button");

            list_item.css('display', 'none');
            list_item.slice(0, per_page).show();

            if($(".hic-item-list.load-more-list .hic-item:hidden").length <= 0){
                load_more_button.css('display', 'none');
            }

            load_more_button.on('click', function (e) {
                e.preventDefault();
                var hidden_items = $(".hic-item-list.load-more-list .hic-item:hidden");
                
                hidden_items.slice(0, per_page).slideDown();
                if (hidden_items.length <= per_page) {
                    $(this).attr('display', 'none');
                }
                if($(".hic-item-list.load-more-list .hic-item:hidden").length <= 0){
                    load_more_button.css('display', 'none');
                }
                $('body,html').animate({
                    scrollTop: $(this).offset().top
                }, 1500);
            });
        },

        hic_scripts: function(){
 
            // Remove empty P tags created by WP inside of Accordion and Orbit
            $('.accordion p:empty, .orbit p:empty').remove();
            
             // Makes sure last grid item floats left
            $('.archive-grid .columns').last().addClass( 'end' );
            
            // Adds Flex Video to YouTube and Vimeo Embeds
            $('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').wrap("<div class='flex-video'/>");


            var themeLayout = $('body').attr('data-theme-layout');

            var autoplay = false;
            var slickArrows = false;
            var slickDots = false;
            var autoplaySpeed = 4000;

            var heroSlider = $('.hero-slider');

            if(heroSlider.attr("data-autoplay") && heroSlider.attr("data-autoplay") == 1) {
                autoplay = true;
            }
            if(heroSlider.attr("data-autoplay-speed")) {        
                autoplaySpeed = heroSlider.attr("data-autoplay-speed") * 1000;
            }
            if(heroSlider.attr("data-arrows") && heroSlider.attr("data-arrows") == 1) {
                slickArrows = true;
            }
            if(heroSlider.attr("data-dots") && heroSlider.attr("data-dots") == 1) {
                slickDots = true;
            }

            $('.hero-slider').not(".slick-initialized").slick({
                dots: slickDots,
                arrows: slickArrows,
                infinite: true,
                draggable: false,
                autoplay: autoplay,
                autoplaySpeed: autoplaySpeed,
                fade: true
            });
            
            var htmlMarginTop = $('html').css("margin-top");
            var headerHeight = $('.header').height()+"px";
            
            if( $('body').hasClass('sticky-header') && !$('body').hasClass('header-transparent')) {    
                $('.off-canvas-content').css({'padding-top': headerHeight });
                $('.sticky-header .header').css({'top': htmlMarginTop });
            }
            
            $( window ).resize(function() {
                
                var headerHeight = $('.header').height()+"px";
                var htmlMarginTop = $('html').css("margin-top");
                
                if( $('body').hasClass('sticky-header') && !$('body').hasClass('header-transparent')) {        
                    $('.off-canvas-content').css({'padding-top': headerHeight });
                    $('.sticky-header .header').css({'top': htmlMarginTop });
                }
                
            });
            
            $(window).scroll(function (event) {
                if($(window).width() < 641){
                    if( $('body').hasClass('sticky-header') && !$('body').hasClass('header-transparent')) {
                        var hmt = htmlMarginTop.replace("px","");
                        var scroll = $(window).scrollTop();
                
                        if(scroll > hmt ){
                            $('.off-canvas-content .header').css({
                                'top': "0"
                            });
                        } 
                        if( scroll <= hmt ){
                            $('.off-canvas-content .header').css({
                                'top': (hmt - scroll) + "px"
                            });
                        }
                    }
                }        
            });

            $('.hero-gallery-slides').not(".slick-initialized").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                infinite: true,
                autoplay: true,
                arrows: false,
                asNavFor : '.hero-gallery-slides-thumb',
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
                            arrows: false,
                            speed: 400,
                            autoplaySpeed: 6000,
                            asNavFor : '.hero-gallery-slides-thumb',
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                            asNavFor : '.hero-gallery-slides-thumb',
                        }
                    }
            
                 ]
            });

            $('.hero-gallery-slides-thumb').not(".slick-initialized").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                asNavFor : '.hero-gallery-slides',
                centerMode : false,
                focusOnSelect: true
            });

            if( $('.carousel .section-body').length > 0 ) {
                $('.carousel .section-body').each(function(i,v){
                    var elem = $(this);
                    var slider_nav = $('.carousel-nav.carousel .section-body');
                    var slider_for = $('.carousel-for.carousel .section-body');
                    var el_carousel = elem.hasClass('el-carousel');
                    
                    var parent_section = elem.closest('.page-element');
                    
                    if(parent_section.hasClass('carousel-nav') && slider_for.length > 0){
                        if(slider_nav.children().length == slider_for.children().length){
                            APP.generate_carousel( elem , elem.attr('data-item-col'), '.carousel-for.carousel .section-body' );
                        } else if(!el_carousel) APP.generate_carousel( elem , elem.attr('data-item-col') );
                    } else if(parent_section.hasClass('carousel-for') && slider_nav.length > 0){
                        if(slider_nav.children().length == slider_for.children().length){
                           APP.generate_carousel( elem , elem.attr('data-item-col'), '.carousel-nav.carousel .section-body' );
                        } else if(!el_carousel) APP.generate_carousel( elem , elem.attr('data-item-col') );
                    } else if(!el_carousel) APP.generate_carousel( elem , elem.attr('data-item-col') );
                
                });
            }
            
            $('.services-video-slider').not(".slick-initialized").slick({
                 slidesToShow: 4,
                slidesToScroll: 4,
                    responsive:[
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
                                }
                        },
                        
                    ]
            });


            $('.footer #back-to-top').on('click', function() {
                APP.smooth_scroll('.header', 0, 500);
            });

            $(window).load(function() {
                  APP.equalheight('.adaptive, .content-equal-height .hic-content');
                  APP.equalheight('.blurb-equal-height .hic-blurb');
                  APP.equalheight('.title-equal-height .hic-title');
            });


            $(window).resize(function(){
                  APP.equalheight('.adaptive, .content-equal-height .hic-content');
                  APP.equalheight('.blurb-equal-height .hic-blurb');
                  APP.equalheight('.title-equal-height .hic-title');
            });

            var maxHeight = 0;

            $(".box-equal-height .hic-box").each(function(){
               if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });
            
            $(".box-equal-height .hic-box").height(maxHeight);
            
            
            maxHeight = 0;

            $(".blurb-equal-height .hic-blurb").each(function(){
               if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });
            
            $(".blurb-equal-height .hic-blurb").height(maxHeight);


            maxHeight = 0;

            $(".title-equal-height .hic-title").each(function(){
               if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });
            
            $(".title-equal-height .hic-title").height(maxHeight);


            $('#fullscreenMenu, .fullscreen-menu-overlay .overlay-close').on('click',function () {
                $('.fullscreen-menu-overlay').toggleClass('open');
            });

            $('#ht4-form-btn').on('click', function() {
                $('body').toggleClass('form-active');
            });


            
            $('.button[href*="#"]').on('click', function(){
                var btn_link = $(this).attr('href');
                var link_regx = /^((?:(https?):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?)?(?:\?([^#]*))?(?:#(.*))?$/;
                var match = link_regx.exec(btn_link);
                var link_anchor = "";
                
                if(typeof match[8] !== 'undefined'){
                    link_anchor = '#' + match[8];
                }
                
                if(link_anchor){
                    APP.smooth_scroll(link_anchor, 0, 500);
                }
            });
            
            $(window).scroll(function() {
                if ($(this).scrollTop() > 20){  
                    $('body').addClass("scrolled");
                } else{
                    $('body').removeClass("scrolled");
                }
            });

            $(window).load(function() {
                if ($(this).scrollTop() > 20){  
                    $('body').addClass("scrolled");
                }
            });

            $('.speaker-button').on('click', function() {

                var heroVideo = $(".hero video");

                $('.speaker-button').toggleClass('active');


                if( heroVideo.prop('muted') ) {
                    heroVideo.prop('muted', false);
                } else {
                    heroVideo.prop('muted', true);
                }

                    
            });

             $('.custom-category-filter li').on('click', function() {

                var $carCategory = $(this).attr('data-car-cat');
                var $details = {};

                $details.cat = $carCategory;

                    $.ajax({
                        url: obVal.adminUrl,
                        type: 'POST',
                        data: {
                            action: 'test_ajax_call',
                            postdata: $details,
                            nonce: obVal.complete_info,
                        },
                        success: function( data, textStatus, xhr ) {

                            var obj = $.parseJSON(data);

                            

                            if( obj.success ) {                      
                                $('#content_roll').html(obj.success.listing);
                            } else {                        
                                window.alert('something went wrong please contact site admin');
                            }

                            
                            
                        }



                    });     

             });

             $('.team-slides').not(".slick-initialized").slick({
                dots: false,
                arrows: true,
                infinite: true,
                draggable: false,
                autoplay: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                autoplaySpeed: 6000,
                    responsive:[
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
                                }
                        },
                        {
                            breakpoint: 1024, 
                                settings: {
                                    infinite: true,
                                    slidesToShow: 2,
                                    slidesToScroll: 2,
                                    autoplay: true, 
                                    arrows: true,
                                    dots: false,
                                    speed: 400,
                                    autoplaySpeed: 6000,
                                }
                        }
                    ]
            });


            //Disable Gravity Form field with disabled class 
            $('.gfield.disabled input').attr('disabled', true);

            // Video Background positioning helper
            $('.flex-video #hero_bgvid').css('top', function(){
                var top = ($(this).height() - $(this).closest('.video-wrap').height()) / 2 * -1; 
                return top + 'px';
            });

            $('.hero .play-button').css('opacity', '1');

            $('.modal-menu a').each(function(){
                var e = $(this);
                var href = e.attr("href");
                var dataOpen = href ? href.replace("#","") : "modal-elem-0";
                e.attr("data-open", dataOpen);
                e.removeAttr("href");
            });
        },

        gform_post_render: function(){
            $(document).on('gform_post_render', function(){
                // code to trigger on AJAX form render
                $('.gform_wrapper').find('.gfield_select').each(function(){
                    var select_field = $(this);
                    if(!select_field.hasClass('default-set-value') && select_field.val()=="") select_field.addClass('default-set-value');   

                    if(select_field.on('change', function(){
                        if(select_field.val()==""){
                            if(!select_field.hasClass('default-set-value')) select_field.addClass('default-set-value'); 
                        } else select_field.removeClass('default-set-value');
                    }));
                });

                // remove gravity form input mask underscore
                $('.gfield.clear-mask').each(function(){
                    var e = $(this);
                    var zipcodefield = e.hasClass('postcode');
                    var phonefield = e.hasClass('phone');
                    var form_id = e.closest('form').attr('id');
                    
                    if(form_id){
                        form_id = form_id.replace("gform_", "") ;
                        var field_id = e.attr('id');
                        
                        if(field_id){
                            field_id = field_id.replace("field_" + form_id + "_", "");
                            
                            if(zipcodefield){
                                $('#input_' + form_id + '_' + field_id).mask( '9999', { placeholder: '' } );
                            }
                            
                            if(phonefield){
                                $('#input_' + form_id + '_' + field_id).mask( '9999999999', { placeholder: '' } );
                            }
                        }
                    }
                });

            });
        },

        //Generators
        generate_fancybox_gallery: function( gallery_group_number, images_element ) {
            images_element.each(function(){
                $(this).attr('data-fancybox', $(this).attr('data-fancybox') + gallery_group_number);
            });
        },

        generate_carousel: function( elem, param, asnavfor="" ){
            var sm = 1, md = 1, lg = 1;
            var parent_section = elem.closest('.page-element');
            var is_vertical = parent_section.hasClass('vertical-carousel');
            var showDots = parent_section.hasClass('show-carousel-dots') ? true : 
                (parent_section.hasClass('hide-carousel-dots') ? false : false);
            var showArrows = parent_section.hasClass('hide-carousel-arrows') ? false : 
                (parent_section.hasClass('show-carousel-arrows') ? true : true);
            var non_slider_on_large = parent_section.hasClass('disable-carousel-for-large');
            var adaptive_height = parent_section.hasClass('carousel-adaptive-height') ? true : false;
            var cm = parent_section.hasClass('carousel-center-mode') ? true : false;
            var autoplay = false;
            var cp = '25%';

            var unslickonlarge = false;
            if(non_slider_on_large) unslickonlarge = true;

            var autoplaySpeed = 6000;

            var autoplayAttr = elem.attr('data-autoplay');

            if(typeof autoplayAttr !== "undefined" && autoplayAttr == 1) {
                autoplay = true;
            }

            if(elem.attr("data-autoplay-speed")) {      
                autoplaySpeed = elem.attr("data-autoplay-speed") * 1000;
            }

          
            switch( param ) {
                case 'medium-6':
                    md = cm ? 1 : 2;
                    lg = cm ? 1 : 2;
                break;
                
                case 'medium-4':
                    md = cm ? 1 : 2;
                    lg = cm ? 1 : 3;
                break;    

                case 'medium-6 large-4':
                    md = cm ? 1 : 2;
                    lg = cm ? 1 : 3;
                break;                  
                
                case 'medium-6 large-3':
                    md = cm ? 1 : 2;
                    lg = cm ? 1 : 4;
                break;
                
                case 'medium-4 large-2_4':
                    md = cm ? 1 : 2;
                    lg = cm ? 3 : 5;
                    cp = '15%';
                break;

                case 'medium-4 large-2':
                    md = cm ? 1 : 2;
                    lg = cm ? 3 : 6;
                    cp = '15%';
                break;
            }
            
            
            if(elem.data('element') == 'testimonials') {
                
                 elem.not(".slick-initialized").slick({
                    dots: showDots,
                    arrows: showArrows,
                    infinite: true,
                    draggable: cm ? true : false,
                    autoplay: autoplay,
                    slidesToShow: lg,
                    slidesToScroll: 1,
                    autoplaySpeed: autoplaySpeed,
                    vertical: is_vertical,
                    centerMode: cm,
                    centerPadding: cm ? cp : '',
                    asNavFor: asnavfor,
                    adaptiveHeight: adaptive_height,
                        responsive:[
                            {
                                breakpoint: 641, 
                                    settings: {
                                         infinite: true,
                                         slidesToShow: sm,
                                         slidesToScroll: 1,
                                         autoplay: autoplay, 
                                         dots: showDots,
                                         arrows: showArrows,
                                         speed: 400,
                                         autoplaySpeed: autoplaySpeed,
                                         vertical: is_vertical,
                                         centerMode: cm,
                                         centerPadding: cm ? '25%' : '',
                                         asNavFor: asnavfor,
                                         adaptiveHeight: adaptive_height,
                                    }
                            },
                            {
                                breakpoint: 1024, 
                                    settings: {
                                        infinite: true,
                                        slidesToShow: md,
                                        slidesToScroll: 1,
                                        autoplay: autoplay, 
                                        arrows: showArrows,
                                        dots: showDots,
                                        speed: 400,
                                        autoplaySpeed: autoplaySpeed,
                                        vertical: is_vertical,
                                        centerMode: cm,
                                        centerPadding: cm ? '25%' : '',
                                        asNavFor: asnavfor,
                                        adaptiveHeight: adaptive_height,
                                    }
                            },
                            {
                                breakpoint: 9999,
                                settings: unslickonlarge ? "unslick" : {}
                            }
                        ]
                    });
                
            } else {
                
                elem.not(".slick-initialized").slick({
                    dots: showDots,
                    arrows: showArrows,
                    infinite: true,
                    draggable: cm ? true : false,
                    autoplay: autoplay,
                    slidesToShow: lg,
                    slidesToScroll: 1,
                    autoplaySpeed: autoplaySpeed,
                    vertical: is_vertical,
                    centerMode: cm,
                    centerPadding: cm ? cp : '',
                    asNavFor: asnavfor,
                    adaptiveHeight: adaptive_height,
                        responsive:[
                            {
                                breakpoint: 641, 
                                    settings: {
                                         infinite: true,
                                         slidesToShow: sm,
                                         slidesToScroll: 1,
                                         autoplay: autoplay, 
                                         dots: showDots,
                                         arrows: showArrows,
                                         speed: 400,
                                         autoplaySpeed: autoplaySpeed,
                                         vertical: is_vertical,
                                         centerMode: cm,
                                         centerPadding: cm ? '25%' : '',
                                         asNavFor: asnavfor,
                                         adaptiveHeight: adaptive_height,
                                    }
                            },
                            {
                                breakpoint: 1024, 
                                    settings: {
                                        infinite: true,
                                        slidesToShow: md,
                                        slidesToScroll: 1,
                                        autoplay: autoplay, 
                                        arrows: showArrows,
                                        dots: showDots,
                                        speed: 400,
                                        autoplaySpeed: autoplaySpeed,
                                        vertical: is_vertical,
                                        centerMode: cm,
                                        centerPadding: cm ? '25%' : '',
                                        asNavFor: asnavfor,
                                        adaptiveHeight: adaptive_height,
                                    }
                            },
                            {
                                breakpoint: 9999,
                                settings: unslickonlarge ? "unslick" : {}
                            }
                        ]
                 });
            }

            if(showDots && showArrows){
    		    var dots = parent_section.find('.slick-dots');
    		    var arrows = parent_section.find('.slick-arrow');
    		    
    		    if(dots && arrows ? true : false){
    		        arrows.css('top', 'calc(50% - ' + (dots.height() + Number(dots.css('margin-top').replace('px',''))) + 'px / 2)');   
    		    }
		    }
        },

        equalheight: function(container){
            var currentTallest = 0,
                 currentRowStart = 0,
                 rowDivs = [],
                 el,
                 topPosition = 0;
             $(container).each(function() {

               el = $(this);
               $(el).height('auto')
               topPosition = el.position().top;
               var currentDiv = 0;

               if (currentRowStart != topPosition) {
                 for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                   rowDivs[currentDiv].height(currentTallest);
                 }
                 rowDivs.length = 0; // empty the array
                 currentRowStart = topPosition;
                 currentTallest = el.height();
                 rowDivs.push(el);
               } else {
                 rowDivs.push(el);
                 currentTallest = (currentTallest < el.height()) ? (el.height()) : (currentTallest);
              }
               for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                 rowDivs[currentDiv].height(currentTallest);
               }
             });
        },

        smooth_scroll: function( $element, $additionalScrollSize, $speed) {
            if(undefined !=  $($element) && undefined != $(".off-canvas-wrapper")){
                var positionXP = $($element).position().top + $(".off-canvas-wrapper").scrollTop();        
                $("html, body").animate({scrollTop: positionXP - $additionalScrollSize},$speed);
            }
        }
    };


    var HIC_PAGINATION = {
        itemPerPage : 9,
        items : $('.hic-item-list .hic-item, .article-list.paginated .article-item'),
        numberOfItems : 0,
        container : $('.hic-paginate-pagination'),
        hicPagination : $('.hic-pagination-page'),
        pageName : "#page-",
        cssStyle : "light-theme",
        smoothScroll : {
            enable : false,
            scrollTo : '.main-content',
            speed : 500,
            adjustPosition : 80,
            scroll: function () {
                var positionXP = jQuery(this.scrollTo).position().top + jQuery(".off-canvas-wrapper").scrollTop();        
                jQuery("html, body").animate({scrollTop: positionXP - this.adjustPosition},this.speed);
            }
        },
        
        // initialize before creating the page element
        /*
         * How to initialize
         * .init() - will use all the diffault property of this object except changed before calling .create()
         * .init( $('items_selector'), $('container_selector'), $('pagination_selector'), 'pageName', numberOfItemPerPage)
         * .init( 'items_selector', 'container_selector', 'pagination_selector', 'pageName', numberOfItemPerPage)
         * All arguments are optional
         */
        init : function(items, container, pagination, pageName, perPage){
            // Set the jquery object containing all the elements
            if(items) if(items.jquery) this.items = items; // if the item set is already a jquery object
            else if(typeof items == "string") this.items = $(items); // if the items set is a selector
            
            // set the total number of items
            this.numberOfItems = this.items.length;
            
            // Set the jquery container object that holds the pagination
            if(container) if(container.jquery) this.container = container; // if item set is already a jquery object
            else if(typeof container == "string") this.container = $(container); // if the items set is a selector
            
            // Set the jquery object of the pagination
            if(pagination) if(pagination.jquery) this.hicPagination = pagination; // if the item set is already a jquery object
            else if(typeof pagination == "string") this.hicPagination = $(pagination); // if the items set is a selector
            
            if(pageName) this.pageName = pageName;
            
            if(perPage) this.itemPerPage = perPage;
        },
        
        create : function(){
            if (this.numberOfItems > this.itemPerPage) {
    
                this.container.css({
                    'visibility': 'visible'
                });
    
                // only show the first per_page items initially
                this.items.slice(this.itemPerPage).hide();
    
                // setup pagination
                this.hicPagination.pagination({
                    items: HIC_PAGINATION.numberOfItems,
                    itemsOnPage: HIC_PAGINATION.itemPerPage,
                    cssStyle: HIC_PAGINATION.cssStyle,
                    hrefTextPrefix: HIC_PAGINATION.pageName,
                    onPageClick: function (pageNumber) { // this is where the magic happens
                    
                        // if someone click the pagination scroll the page smoothly
                        if(HIC_PAGINATION.smoothScroll.enable) HIC_PAGINATION.smoothScroll.scroll();
                        
                        // someone changed page, hide/show trs appropriately
                        var showFrom = HIC_PAGINATION.itemPerPage * (pageNumber - 1);
                        var showTo = showFrom + HIC_PAGINATION.itemPerPage;
    
                        HIC_PAGINATION.items.hide() // first hide everything, then show for the new page
                            .slice(showFrom, showTo).show();
                    }
                });
    
            } else {
                this.container.css({
                    'visibility': 'hidden'
                });
            }
        }
        
    };
    
    //Default Hicaliber Content Pagination
    
    // START CPT Search Filter Element
    // Setup and load the pagination 
    HIC_PAGINATION.init();
    HIC_PAGINATION.itemPerPage = HIC_PAGINATION.container.data('per-page');
    HIC_PAGINATION.smoothScroll.enable = HIC_PAGINATION.container.data('smooth-scroll');
    HIC_PAGINATION.smoothScroll.speed = HIC_PAGINATION.container.data('scroll-speed') * 100;
    HIC_PAGINATION.create();

    
    $(document).ready(APP.init);

})(jQuery);