(function ($) {

    Drupal.behaviors.initDropzone = {
        attach: function (context, settings) {
               $('#view-content-ajax').NewWaterfall();
        }
    };

})(jQuery);