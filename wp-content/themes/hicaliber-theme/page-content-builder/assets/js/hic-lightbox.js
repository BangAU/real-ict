// jQuery(document).ready(function($) {
//     var lightboxid = 1;
//     $(".with-lightbox").each(function(){
//         var lb = $(this);
//         if(!lb.attr('data-lightbox-id')){
//             lb.attr('data-lightbox-id', lightboxid);
//             lightboxid++;
//         }

//         var HIC_LIGHTBOX = $('[data-lightbox-id="'+lb.attr('data-lightbox-id')+'"] a').tosrus({
//             caption    : {
//                   add        : true
//                },
//                 pagination : {
//                   add        : true,
//                   type       : "thumbnails"
//                },
//               infinite : true,
//         });
    
    
//         $('.btn-open-lightbox').on('click',function() {
//             HIC_LIGHTBOX.trigger("open");
//         });
//     });

// });