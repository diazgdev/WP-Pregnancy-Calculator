jQuery(document).ready(function($) {
  $('#submit-weeks-of-pregnancy').click(function(event) {
      event.preventDefault();
      var data = {
          'action': 'semanas_de_embarazo_ajax',
          'last_period': $('#last-period').val(),
          'nonce': weeksOfPregnancyAjax.nonce
      };
      $.post(weeksOfPregnancyAjax.ajaxurl, data, function(response) {
          $('#weeks-of-pregnancy-result').html(response);
      });
  });

  $.datepicker.setDefaults($.datepicker.regional['es']);
  $('#last-period').datepicker({
      dateFormat: 'dd-mm-yy'
  });

  $('#last-period').on('keyup change', function() {
    if ($(this).val()) {
      $('#submit-weeks-of-pregnancy').removeAttr('disabled');
    } else {
      $('#submit-weeks-of-pregnancy').attr('disabled', 'disabled');
    }
  });
});
