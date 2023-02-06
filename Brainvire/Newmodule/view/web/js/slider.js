require(['jquery', 'slider'], function($, slider) {
    $(document).ready(function() {
 $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });      
    });
});


    // require([
    //     'jquery',
    //     'Brainvire_Newmodule/slider'
    // ], function ($, slider) {
        
       
    // });