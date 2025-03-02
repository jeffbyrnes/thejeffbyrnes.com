/*global jQuery, accounting*/
jQuery(document).ready(function ($) {
  var $columnValues = $('#demo-column').find('input'),
    $columnOutputs = $('#demo-column').find('.output');

  $columnValues.bind('keydown keyup keypress focus blur paste', function () {
    var list = $.map($columnValues, function (each) { return $(each).val(); }),
      formatted = accounting.formatColumn(list, {
        format: "%s %v"
      });

    $.each($columnOutputs, function (i, each) {
      $(each).text(formatted[i]);
    });
  });
});
