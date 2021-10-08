(function ($) {
  "use strict";

  $(document).ready(function () {

    function abc() {

      $('.slider_gera').each(function (index) {
        $(this).attr('data-slider', index);
        $(this).not('.slick-initialized').slick({
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 3,
          arrows: true,
          dots: true,
          appendArrows: this.closest('.container_slider'),
          prevArrow: '<div class="slider-prev fa fa-chevron-left fa-2x"></div>',
          nextArrow: '<div class="slider-next fa fa-chevron-right fa-2x"></div>',
          responsive: [{
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          },
          {
            breakpoint: 450,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 330,
            settings: {
              dots: false,
              slidesToShow: 1,
              slidesToScroll: 1

            }
          },
          ]
        });;
      });
    }
abc();
  });

})(jQuery);
