$('div#login input.input_text').on('blur',function(){
  if ($('div#login input.input_text').val() != "") {
      $('div#login input.input_text + label.input_label').addClass("fill");
  }else {
    $('div#login input.input_text + label.input_label').removeClass("fill");
  }
})
$('div#user_register_form input.input_text').on('blur',function(){
  if ($('div#user_register_form input.input_text').val() != "") {
      $('div#user_register_form input.input_text + label.input_label').addClass("fill");
  }else {
    $('div#user_register_form input.input_text + label.input_label').removeClass("fill");
  }
})
$('div#login input.input_pass').on('blur',function(){
  if ($('div#login input.input_pass').val() != "") {
      $('div#login input.input_pass + label.input_label').addClass("fill");
  }else {
    $('div#login input.input_pass + label.input_label').removeClass("fill");
  }
})
$('div#user_register_form input.input_pass').on('blur',function(){
  if ($('div#user_register_form input.input_pass').val() != "") {
      $('div#user_register_form input.input_pass + label.input_label').addClass("fill");
  }else {
    $('div#user_register_form input.input_pass + label.input_label').removeClass("fill");
  }
})
$('input.input_email').on('blur',function(){
  if ($('input.input_email').val() != "") {
      $('input.input_email + label.input_label').addClass("fill");
  }else {
    $('input.input_email + label.input_label').removeClass("fill");
  }
})
$('div#user_register_form input.input_repass').on('blur',function(){
  if ($('div#user_register_form input.input_repass').val() != "") {
      $('div#user_register_form input.input_repass + label.input_label').addClass("fill");
  }else {
    $('div#user_register_form input.input_repass + label.input_label').removeClass("fill");
  }
})
$('input[type="button"]').on('click',function(){
  $('div#user_register_form').addClass('appear');
});
$('input[type="reset"]').on('click',function(){
  $('div#user_register_form input.input_repass + label.input_label').removeClass("fill");
  $('div#user_register_form input.input_pass + label.input_label').removeClass("fill");
  $('input.input_email + label.input_label').removeClass("fill");
  $('div#user_register_form input.input_text + label.input_label').removeClass("fill");
  $('div#user_register_form label.error').removeClass('visible');
  $('div#user_register_form div.input_wrapper.password').removeClass('error');
  $('div#user_register_form label.error').removeClass('visible');
  $('div#user_register_form div.input_wrapper.password').removeClass('error');
});
