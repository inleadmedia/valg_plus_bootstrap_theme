(function ($) {
  'use strict';

  Drupal.behaviors.BefFix = {
      attach: function (context, settings) {
          var views_exposed_form = $('#views-exposed-form-search-bkm-items-page-1', context);

          views_exposed_form.hide();
          views_exposed_form.find('.form-control').not('.form-text, .form-select').removeClass('form-control');
          views_exposed_form.show();
      }
  };

})(jQuery);

