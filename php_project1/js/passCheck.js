$('input.input_pass').on('input',function(){
  var pass = $('input.input_pass').val();
  var repass = $('input.input_repass').val();
  if (pass != repass) {
    $('div#user_register_form label.error').addClass('visible');
    $('div#user_register_form div.input_wrapper.password').addClass('error');
    $('form.register').attr('onsubmit','return false');
  }else {
    $('div#user_register_form label.error').removeClass('visible');
    $('div#user_register_form div.input_wrapper.password').removeClass('error');
    $('form.register').attr('onsubmit','return true');
  }
});
$('input.input_repass').on('input',function(){
  var pass = $('input.input_pass').val();
  var repass = $('input.input_repass').val();
  if (pass != repass) {
    $('div#user_register_form label.error').addClass('visible');
    $('div#user_register_form div.input_wrapper.password').addClass('error');
    $('form.register').attr('onsubmit','return false');
  }else {
    $('div#user_register_form label.error').removeClass('visible');
    $('div#user_register_form div.input_wrapper.password').removeClass('error');
    $('form.register').attr('onsubmit','return true');
  }
});
