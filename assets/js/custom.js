//$(window).load(function(){
//$( document ).ready(function() {
 

    (function($) {
        $('.slider-single').slick({
       slidesToShow: 1,
       slidesToScroll: 1,
       arrows: true,
       fade: false,
       adaptiveHeight: false,
       infinite: true,
       useTransform: true,
       speed: 400
       
      });
     
      $('.slider-nav')
       .on('init', function(event, slick) {
         $('.slider-nav .slick-slide.slick-current').addClass('is-active');
       })
       .slick({
         slidesToShow: 7,
         slidesToScroll: 7,
         dots: false,
         focusOnSelect: false,
         infinite: true,
         responsive: [{
           breakpoint: 1024,
           settings: {
             slidesToShow: 5,
             slidesToScroll: 5,
           }
         }, {
           breakpoint: 640,
           settings: {
             slidesToShow: 4,
             slidesToScroll: 4,
           }
         }, {
           breakpoint: 420,
           settings: {
             slidesToShow: 3,
             slidesToScroll: 3,
         }
         }]
       });
     
      $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
       $('.slider-nav').slick('slickGoTo', currentSlide);
       var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
       $('.slider-nav .slick-slide.is-active').removeClass('is-active');
       $(currrentNavSlideElem).addClass('is-active');
      });
     
      $('.slider-nav').on('click', '.slick-slide', function(event) {
       event.preventDefault();
       var goToSingleSlide = $(this).data('slick-index');
     
       $('.slider-single').slick('slickGoTo', goToSingleSlide);
      });
     
     
     
      
     $('.clk').click(function(){
           $('.main-slder').addClass('broadmain');
     });
     
     $('.close').on('click',function(){
         console.log("hey");
              $('.main-slder').removeClass('broadmain');
     });
     
      var $slider = $('.slider-single');
     
     if ($slider.length) {
       var currentSlide;
       var slidesCount;
       var sliderCounter = document.createElement('div');
       sliderCounter.classList.add('slider__counter');
       
       var updateSliderCounter = function(slick, currentIndex) {
         currentSlide = slick.slickCurrentSlide() + 1;
         slidesCount = slick.slideCount;
         $(sliderCounter).text(currentSlide + '/' + "15")
       };
     
       $slider.on('init', function(event, slick) {
         $slider.append(sliderCounter);
         updateSliderCounter(slick);
       });
     
       $slider.on('afterChange', function(event, slick, currentSlide) {
         updateSliderCounter(slick, currentSlide);
       });
     
       
       $slider.not('.slick-initialized').slick()
       
     }
     })(jQuery);
     
     
        
     
     //});
     
     
        
     
      
     
     