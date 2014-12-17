(function ($) {
  'use strict';

  $(document).ready(function() {
    // Hide empty exposed filters.
    $('#views-exposed-form-bkm-item-list-panel-pane-1').find('.panel-default').each(function() {
      var panel = $(this);
      console.log(panel);
      var input = panel.find('.panel-body input');
      if (input.length > 0 && !input.is(':visible')) {
        panel.hide();
      }
    });
  });

})(jQuery);
