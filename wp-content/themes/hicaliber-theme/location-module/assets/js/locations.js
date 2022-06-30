;(function ($) {
    // Google Map Dependencies ; 
    var htwMap = document.getElementById('htwMap');
    var mapStyles = "";
    var mapLat = -24.766785;
    var mapLng = 134.824219;
    var mapZoom = 4.7; 
    var activeInfoWindow;
    
    if(htwMap){        
        // var geocoder = new google.maps.Geocoder();
        // var infowindow = new google.maps.InfoWindow();
        // var bounds = new google.maps.LatLngBounds();

       

        mapZoom = hep.mapZoom ? Number(hep.mapZoom) : mapZoom;
            
        if(htwMap.dataset.mapStyle.length > 0){
            var parseStyle = JSON.parse(htwMap.dataset.mapStyle);
            if(Array.isArray(parseStyle)){
                mapStyles = parseStyle;
            }
        } 
    }

    var LOCATION_APP = {
        prevClickedPinID: 0,
        infoWindowOpen: false,
        markers: [],
        marker: {},
        locations: {},
        gmap: {},
        
        isSingleLocation : $('#htwMap').data('map-single'),
        
        init: function () {

            // Center of Australia map;
            const AUcenterCoord = new google.maps.LatLng(
                hep.mapCenterLat ? Number(hep.mapCenterLat) : mapLat, 
                hep.mapCenterLng ? Number(hep.mapCenterLng) : mapLng
            );

            LOCATION_APP.gmap = new google.maps.Map(htwMap, {
                zoom: mapZoom,
                center: AUcenterCoord,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: mapStyles
            }),

            LOCATION_APP.locations();
        },
        map_infowindow_small: function ($location) {
            var html = "";
            var img = "";
            if ($location.featured_image_small) {
                img = $location.featured_image_small;
            }
            if (img == "") {
                if ($location.gallery[0]) {
                    img = $location.gallery[0].sizes.thumbnail;
                }
            }
            var has_img = img ? " has-image" : "";
            html = "<div class='mini-info-window" + has_img + "'>" + $location.name + "<div class='bg-helper img-holder' style='background-image:url(" + img + ")' ></div></div>";
            return html;
        },
        preLoadHtml: function( $message ) {
            return "";
            if( $message == "" ) {
                $message = "Loading";       
            }
            return '<div class="preloader-full-div"><div><div class="circle-loader "></div>'+$message+'</div></div>';
        },
        the_content: function ($location) {
            var content = "";
            if ($location.excerpt) {
                content = "<div class='pre-line'>" + $location.excerpt + "</div>";
            }
            return content
        },
        small_map_location_details: function ($location) {
            var html = "";
            html += "<div class='location-detail'>" + LOCATION_APP.map_location_details($location) + "</div>";
            return html;
        }, 
        map_location_details: function ($location) {
            var html = "";
            var rating = "";
            var contactPhone = "";
            var contactEmail = "";
            var contactWebsite = "";
            var socialFacebook = "";
            var socialGoogle = "";
            var socialTwitter = "";
            var socialLinkedIn = "";
            var socialInstagram = "";
            var socialYoutube = "";
            var contactDetails = "";
            var openingHoursDetails = "";
            var socialMedia = "";
            var learnMoreLabel = 'Learn More';
            var readMoreButton = '';
            var content = LOCATION_APP.the_content($location);
            var img = $location.featured_image;
            if (img == false || img == null) {
                if ($location.gallery[0]) {
                    img = $location.gallery[0].sizes.large;
                }
            }
            if (typeof $location.post_rating != 'undefined' && $location.post_rating != 'none-selected') {
                if (Number.isInteger(parseInt($location.post_rating)) && hep.previewContent.includes('rating')) {
                    // rating += '<div class="rating"><span>'+$location.post_rating + ".0</span>";
                    rating += '<div class="rating">';
                    for (var i = 0; i < $location.post_rating; i++) {
                        rating += "<i class='fa fa-star'></i>";
                    }
                    rating += '</div>';
                }
            }

            if (typeof $location.location_address != 'undefined') {
                if ($location.location_address != "") {
                    contactAddress = "<div class='contact-address'>" + $location.location_address + "</div>";
                }
            }

            if (typeof $location.location_phone != 'undefined' && hep.previewContent.includes('phone')) {
                if ($location.location_phone != "") {
                    var phoneLabel = typeof $location.phone_label != 'undefined' && $location.phone_label != "" ? $location.phone_label : $location.location_phone;
                    contactPhone = "<div class='contact-phone'><a href='tel:" + $location.location_phone + "'>" + phoneLabel + "</a></div>";
                }
            }
            if (typeof $location.location_email_address != 'undefined' && hep.previewContent.includes('email')) {
                if ($location.location_email_address != "") {
                    var emailLabel = typeof $location.email_label != 'undefined' && $location.email_label != "" ? $location.email_label : $location.location_email_address;
                    contactEmail = "<div class='contact-email'><a href='mailto:" + $location.location_email_address + "'>" + emailLabel + "</a></div>";
                }
            }

            if (typeof $location.location_website_url != 'undefined' && hep.previewContent.includes('website')) {
                if ($location.location_website_url != "") {
                    var websiteLabel = typeof $location.email_label != 'undefined' && $location.website_label != "" ? $location.website_label : $location.location_website_url;
                    contactWebsite = "<div class='contact-website'><a href='" + $location.location_website_url + "'>" + websiteLabel + "</a></div>";
                }
            }

            if($location.location_contact_person || $location.location_contact_person_position || contactPhone || contactEmail || contactWebsite || $location.location_address) {

                contactDetails = "<div class='contact-details'>";
                if($location.contact_details_label) contactDetails += "<h4>" + $location.contact_details_label + "</h4>"; 
                    var contactPersonDetails = "";
                    if($location.location_contact_person_avatar && hep.previewContent.includes('contact-person')) {
                        contactPersonDetails += "<div class='contact-person-avatar'><img src="+ $location.location_contact_person_avatar +" alt="+$location.location_contact_person+"></div>" ;    
                    } 


                    if($location.location_contact_person && hep.previewContent.includes('contact-person')) {
                        contactPersonDetails += "<div class='contact-person'>" + $location.location_contact_person + "</div>" ;    
                    } 
                    if($location.location_contact_person_position && hep.previewContent.includes('contact-person')) {
                        contactPersonDetails += "<div class='contact-person-position'>" + $location.location_contact_person_position + "</div>" ;    
                    }
                    if(contactPersonDetails) contactDetails += "<div class='contact-person-wrap'>" + contactPersonDetails + "</div>";
                    contactDetails += contactAddress;                    
                    contactDetails += contactPhone;
                    contactDetails += contactEmail; 
                    contactDetails += contactWebsite; 
                    contactDetails += "</div>";
            }
            
            if (typeof $location.location_opening_hours != 'undefined' && hep.previewContent.includes('opening_hours')) {
                
                if (Array.isArray($location.location_opening_hours) && $location.location_opening_hours.length > 0 ) {
                    openingHoursDetails = "<div class='opening-hours-details'>";
                    if($location.opening_hours_label) openingHoursDetails += "<h4>" + ($location.opening_hours_label ? $location.opening_hours_label : "Opening Hours") + "</h4>"; 
                    $location.location_opening_hours.forEach( function(opening_hours, index){
                        openingHoursDetails += "<div class='opening_hours_entry'>";
                        if(opening_hours.day || opening_hours.day){
                            openingHoursDetails += "<div class='daytime'>";
                            if(opening_hours.day) openingHoursDetails += "<span class='day'>" + opening_hours.day + ": </span>";
                            if(opening_hours.time) openingHoursDetails += "<span class='time'>" + opening_hours.time + "</span>";
                            openingHoursDetails += "</div>";
                        }
                        if(opening_hours.time) openingHoursDetails += "<div class='note'>" + opening_hours.note + "</div>";
                        openingHoursDetails += "</div>";
                    });

                    openingHoursDetails += "</div>";
                }
            }
            
            if (typeof $location.location_social_facebook != 'undefined') {
                if ($location.location_social_facebook != "") {
                    socialFacebook = "<li><a target='_blank' href='" + $location.location_social_facebook + "'><i class='fab fa-facebook-f'></i></a>";
                }
            }
            if (typeof $location.location_social_google_plus != 'undefined') {
                if ($location.location_social_google_plus != "") {
                    socialGoogle = "<li><a target='_blank' href='" + $location.location_social_google_plus + "'><i class='fab fa-google-plus-g'></i></a>";
                }
            }
            if (typeof $location.location_social_twitter != 'undefined') {
                if ($location.location_social_twitter != "") {
                    socialTwitter = "<li><a target='_blank' href='" + $location.location_social_twitter + "'><i class='fab fa-twitter'></i></a>";
                }
            }
            if (typeof $location.location_social_linkedin != 'undefined') {
                if ($location.location_social_linkedin != "") {
                    socialLinkedIn = "<li><a target='_blank' href='" + $location.location_social_linkedin + "'><i class='fab fa-linkedin-in'></i></a>";
                }
            }
            if (typeof $location.location_social_instagram != 'undefined') {
                if ($location.location_social_instagram != "") {
                    socialInstagram = "<li><a target='_blank' href='" + $location.location_social_instagram + "'><i class='fab fa-instagram'></i></a>";
                }
            }
            if (typeof $location.location_social_youtube != 'undefined') {
                if ($location.location_social_youtube != "") {
                    socialYoutube = "<li><a target='_blank' href='" + $location.location_social_youtube + "'><i class='fab fa-youtube'></i></a>";
                }
            }
            
            if( (socialFacebook || socialGoogle || socialTwitter || socialLinkedIn || socialInstagram || socialYoutube) && hep.previewContent.includes('social-media') ){
                socialMedia = "<div class='social-media-container'><ul class='social-media'>" + socialFacebook + socialGoogle + socialLinkedIn + socialInstagram + socialYoutube + "</ul></div>";
            } 
            if(hep.previewContent.includes('button')){
                if(!LOCATION_APP.isSingleLocation){
                    if (typeof $location.learn_more_label != 'undefined') {
                        if ($location.learn_more_label != "") {
                            learnMoreLabel = $location.learn_more_label;
                        }
                    }   
                    
                    readMoreButton = "<div class='button-area btn-readmore'><a class='button uppercase' href='" + $location.permalink + "'>" + learnMoreLabel + "</a></div>";
                } else {
                    // readMoreButton = "<div class='button-area'><a class='button uppercase' href='/locations/'>Back<a></div>";
                }
            }
            var avatar_img = $location.location_contact_person_avatar;
            var has_img = img || avatar_img ? " has-image" : "";
            var img_out = img ? img : avatar_img ? avatar_img : ""; 
            
            var desc = content != "" ? "<div class='desc'>" + content + "</div>" : "";
            
            var getDirectionBtn = $location.location_direction != "" ? "<a href='" + $location.location_direction + "' class='button btn-direction' target='_blank'>Get Directions</a>" : "";
            
            html = "<div class='inner" + has_img + "'>\
                        <div class='bg-helper' style='background-image:url(" + img_out + ")'></div>\
                        <div class='content'>\
                        <div class='name'>" + $location.name + "</div>\
                        " + rating + "\
                        " + desc + "\
                        " + socialMedia + "\
                        " + contactDetails + "\
                        " + openingHoursDetails + "\
                        " + readMoreButton + "\
                        " + getDirectionBtn + "\
                        <div>\
                    </div>";

            return html;
        },
        map_markers: function (locations) {
            var mapid = 0;
            var location = "";
            var lookUpLocation = document.getElementById('lookUpLocation');
            var options = { componentRestrictions: {country: ['au','nz']} };

            if(lookUpLocation != null){
                var lookUp = new google.maps.places.Autocomplete(lookUpLocation, options);        

                google.maps.event.addListener(lookUp, 'place_changed', function() {
                    var places = lookUp.getPlace();                                
                    if (places.length == 0) {
                        return;
                    }
                    
                    var bounds = new google.maps.LatLngBounds();   

                    if(places.geometry !== undefined){
                        bounds.union( places.geometry.viewport);
                        LOCATION_APP.gmap.fitBounds(bounds);   
                    }
                });
            }

            LOCATION_APP.clear_markers();
            
            for (i = 0; i < locations.length; i++) {
                var marker = LOCATION_APP.marker;
                var locationName = locations[i].name;
                location = locations[i];
                
                // RE SET MAP CENTER
                if(LOCATION_APP.isSingleLocation){
                    LOCATION_APP.gmap = new google.maps.Map(htwMap, {
                        zoom: 10,
                        center: new google.maps.LatLng(
                            Number(location.location_latitude), 
                            Number(location.location_longitude)
                        ),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles: mapStyles
                    });
                }

                // SET THE MARKERS
                
                var re_icon = {
                    url: location.map_marker_default ? location.map_marker_default : hep.pinmapDefault,
                    scaledSize: new google.maps.Size(30, 41), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.location_latitude, location.location_longitude),
                    icon: re_icon,
                    default_icon: location.map_marker_default ? location.map_marker_default : hep.pinmapDefault,
                    selected_icon: location.map_marker_selected ? location.map_marker_selected : hep.pinmapSelected,
                    map: LOCATION_APP.gmap,
                });
                marker.id = mapid;
                mapid++;

                // HOVER INFOWINDOW
                if(hep.previewLayout == "info-window-style-1"){
                    // SET INFO WINDOW
                    marker['infowindow'] = new google.maps.InfoWindow({
                        content: LOCATION_APP.map_infowindow_small(locations[i])
                    });

                    google.maps.event.addListener(marker, 'mouseover', function () {
                        this['infowindow'].open(LOCATION_APP.gmap, this);
                    });
                    // HOVER INFOWINDOW
                    google.maps.event.addListener(marker, 'mouseout', function () {
                        this['infowindow'].close();
                    });
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {

                        if (this['infowindow']) { this['infowindow'].close();}

                        var infoWindow =  function () {
                            var the_content = LOCATION_APP.map_location_details(locations[i]);
                            // Update the size of the map pin when clicked
                            marker.setIcon(marker.selected_icon);
    
                            // Return the previous clicked map pin to its default map pin, if the previous pin window is still open
                            if(LOCATION_APP.infoWindowOpen){
                                LOCATION_APP.markers[LOCATION_APP.prevClickedPinID].setIcon(LOCATION_APP.markers[LOCATION_APP.prevClickedPinID].default_icon);
                            }
    
                            // Open Info Window once pins are updated
                            LOCATION_APP.infoWindowOpen = true;
    
                            // Set the previous click pin
                            LOCATION_APP.prevClickedPinID = marker.id;
    
                            if ($('#htwMap .location-detail').length > 0) {
                                $('#htwMap').removeClass('open');
                                setTimeout(function () {
                                    $('#htwMap .location-detail').remove();
                                    $('#htwMap').append("<div class='location-detail'>" + the_content + "</div>");
                                    $('#htwMap').addClass('open')
                                }, 1000);
                            } else {
                                setTimeout(function () {
                                    $('#htwMap').append("<div class='location-detail'>" + the_content + "</div>");
                                    $('#htwMap').addClass('open')
                                }, 1000);
                            }
    
                        }
                        
                        activeInfoWindow = infoWindow;

                        return infoWindow;
                    })(marker, i));
                } else if(hep.previewLayout == "info-window-style-2") {
                    // SET INFO WINDOW
                    marker['infowindow'] = new google.maps.InfoWindow({
                        content: LOCATION_APP.small_map_location_details(locations[i])
                    });

                    google.maps.event.addListener(marker, 'click', function () {
                        if (activeInfoWindow) { activeInfoWindow.close();}
                        this['infowindow'].open(LOCATION_APP.gmap, this);
                        activeInfoWindow = this['infowindow'];
                    });
                }
                
                if(LOCATION_APP.isSingleLocation){
                    var the_content = LOCATION_APP.map_location_details(locations[i]);
                    if ($('#htwMap .location-detail').length > 0) {
                        $('#htwMap').removeClass('open')
                        setTimeout(function () {
                            $('#htwMap .location-detail').remove();
                            $('#htwMap').append("<div class='location-detail'>" + the_content + "</div>");
                            $('#htwMap').addClass('open')
                        }, 0);
                    } else {
                        setTimeout(function () {
                            $('#htwMap').append("<div class='location-detail'>" + the_content + "</div>");
                            $('#htwMap').addClass('open')
                        }, 0);
                    }
                }
                
                LOCATION_APP.markers.push(marker);
            }
        },
        clear_markers: function(){
            for (var i=0; i < LOCATION_APP.markers.length; i++) {
              LOCATION_APP.markers[i].setMap(null);
            }
        },
        add_search: function () {
            if(!LOCATION_APP.isSingleLocation){
                var content = "<input placeholder='Enter Location' id='lookUpLocation' type='text'>";
                $("<div  class='location-search-input'>" + content + "</div>").insertBefore($('#htwMap'));
                $('#htwMap').prepend("<a href='#' title='Hide' class='close_side'>close</a>");
                $('.close_side').on('click', function () {

                    // Return the previous clicked pin to it's default map pin
                    LOCATION_APP.markers[LOCATION_APP.prevClickedPinID].setIcon(LOCATION_APP.markers[LOCATION_APP.prevClickedPinID].default_icon);
                    
                    // Reset previous clicked PIN and info window as there is no open window
                    LOCATION_APP.prevClickedPinID = 0;
                    LOCATION_APP.infoWindowOpen = false;
                    $('#htwMap').removeClass('open');
                    $('#htwMap .location-detail').remove();
                    return false;
                });   
            }
        },
        locations: function () {

            let preloadHtml = LOCATION_APP.preLoadHtml('Loading Locations');
            let $category = "";
            let $atts = "";
            let apiUrl = "";
            
            $('#htwMap').css({
                'height': '700px'
            }).addClass('ajax-on-loader').append( preloadHtml );
            
            
            if( typeof $('#htwMap').attr('data-location-category') != "undefined" ) {
                $atts = $('#htwMap').attr('data-location-category');
                $atts = "?category="+$atts;
            }
            
            if( typeof $('#htwMap').attr('data-locations') != "undefined" ) {
                $atts = $('#htwMap').attr('data-locations');
                $atts = "?ids="+$atts;
            }
            
            
            apiUrl = hep['site_url'] + "/wp-json/hi-api/v1/locations"+$atts;
            
            $.ajax({
                url: apiUrl,
                dataType: 'json',
                success: function (data, textStatus, xhr) {
                    if(  data.data ) {
                        LOCATION_APP.locations = data.data;
                        $('.preloader-full-div').remove();
                        LOCATION_APP.add_search();
                        LOCATION_APP.map_markers(LOCATION_APP.locations);
                    }
                }
            });
        }
    }
    if ($('#htwMap').length > 0) {
        $(document).ready(function(){

            LOCATION_APP.init();   

            //search filter for category
            $(".location-categories > li").css("cursor", "pointer");
            $(".location-categories > li").on("click", function(){

                let preloadHtml = LOCATION_APP.preLoadHtml('Loading Locations');

                $('#htwMap').css({
                    'height': '700px'
                }).addClass('ajax-on-loader').append( preloadHtml );

                $(".location-categories > li").removeClass("active");
                $(this).addClass("active");

                let $atts = "?category=" + $(this).attr("data-id");
                apiUrl = hep['site_url'] + "/wp-json/hi-api/v1/locations"+$atts;
                
                $.ajax({
                    url: apiUrl,
                    dataType: 'json',
                    success: function (data, textStatus, xhr) {
                        if(  data.data ) {
                            LOCATION_APP.locations = data.data;
                            $('.preloader-full-div').remove();
                            LOCATION_APP.map_markers(LOCATION_APP.locations);
                        }
                    }
                });
            });

        });
    }
}(jQuery));

jQuery(document).ready(function($) {

    globalEventDirection = undefined;
    $(document).on("pjax:popstate", function(event){
            globalEventDirection = event.direction;
            LOCATION_APP.init;
        });

    $(document).on("pjax:success", function(event){
        if(globalEventDirection === "back" || globalEventDirection === "forward" ) {
            //reinitialize javascript
            LOCATION_APP.init;
            globalEventDirection = undefined;
        }
    });

    if(hep.location_base_url != undefined){
        jQuery('.wloc-base-url > a, a.wloc-base-url').each(function(){
            var e = jQuery(this);
            var href = e.attr("href");
            if( href.startsWith("#") ){
                e.attr("href", hep.location_base_url + href);
            } else if(href == "" || href == undefined) {
                e.attr("href", hep.location_base_url);
            }
        });
    }
});