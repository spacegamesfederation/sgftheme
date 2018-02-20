var gotoslide = function(slide) {
    $('.slideshow').slickGoTo(parseInt(slide));
    console.log(slide);
}
jQuery(document).ready(function() {
    resetStarCanvas();
    jQuery('.slideshow').slick({
        //	autoplay: true,
        dots: true,
        arrows: true,
        infinite: true,
        speed: 1500,
        fade: true,
        cssEase: 'linear',
        focusoOnSelect: true,
        nextArrow: '<i class="slick-arrow slick-next"></i>',
        prevArrow: '<i class="slick-arrow slick-prev"></i>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    jQuery(".slideshow").css("display", "block");
});
jQuery("#video-subnav ul li:first-child a").addClass("selected-channel");

var $carousel = jQuery('.slideshow');
jQuery(document).on('keydown', function(e) {
    if (e.keyCode == 37) {
        $carousel.slick('slickPrev');
    }
    if (e.keyCode == 39) {
        $carousel.slick('slickNext');
    }
    var slideno = jQuery(this).data('slide');
});

jQuery('a[data-slide]').click(function(e) {
    jQuery("#video-subnav ul li a").removeClass("selected-channel");
    jQuery(this).addClass("selected-channel");
    var slideno = jQuery(this).data('slide');
    console.log(slideno);
    $carousel.slick('slickGoTo', slideno);

});


jQuery('.slideshow').on('afterChange', function(event, slick, currentSlide, nextSlide) {
    console.log(currentSlide);
});
