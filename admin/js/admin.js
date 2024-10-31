(function ($) {
  'use strict';
  $(document).ready(function(){
    $("#countdown_template").trigger('change');
    $("#product-countdown-local-timezone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
    let newDatenew = myGeeks($("#product-countdown-default").val());
    $("#product-countdown").val(newDatenew.getFullYear()+'/'+`${newDatenew.getMonth() + 1}`.padStart(2, "0")+'/'+`${newDatenew.getDate()}`.padStart(2, "0")+' '+`${newDatenew.getHours()}`.padStart(2, "0")+':'+`${newDatenew.getMinutes()}`.padStart(2, "0"));
  });
  $("#countdown_template").on('change',function(){
    if($("#countdown_template").val() == 'template2'){
      $(".template-color").show();
    }else{
      $(".template-color").hide();
    }
  });
}(jQuery));
function getTimeZone() {
  var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
  return (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
}
function myGeeks(newDate) {
  var theDate = new Date(Date.parse(newDate+' UTC'));
  return theDate;
}