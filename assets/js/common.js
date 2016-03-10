$(function(){
  $(document).ready(function()
  {
    $("#inputKeyword").keyup(function (e) 
    {
      if(e.keyCode == 13) // enter key
      {
        $("#submitSearch").click();
      }
    });
  });

  jQuery.fn.onlyNumber = function(input){
    $(this).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  }
jQuery.fn.setTextboxShowUnShowMessage = function(textMessage){
    if($(this).val()=='')
    {
      $(this).val(textMessage);
      $(this).css("color", "#b7bec8");
    }
    $(this).click(function(){
        var textin = $(this).val();

        if(textin == textMessage) {
            $(this).val('');
            $(this).css("color", "#000000");
        }
        else if(textin == ""){
            $(this).val(textMessage);
            $(this).css("color", "#b7bec8");
        }

    }).keyup(function(event){
        var textin = $(this).val();
        if(event.which == 8) {
            if (textin == "") {
                $(this).val(textMessage);
                $(this).css("color", "#b7bec8");
            }
        }

    }).keydown(function(event){
        var textin = $(this).val();
        if (textin == textMessage) {
            $(this).val('');
            $(this).css("color", "#000000");
        }
    }).focusout(function(){
        var textin = $(this).val();
        if (textin == "") {
            $(this).val(textMessage);
            $(this).css("color", "#b7bec8");
        }
    });
    };
});

function gotoURL($url){
    window.location.href = $url;
}
function historyBack()
{
  window.history.back();
}
function loadContent(controller){
  $.ajax({
          type : "POST",
          url : controller,
          success : function(data) {
            $("[id$='b-container']").html(data);
            scrollToID("[id$='b-container']");
          }
        });
  }
  function scrollToID(id){
     $('html, body').animate({
       scrollTop: $(id).offset().top
      }, 500);
  }
  function submitDataAjax(controller,data,succFunc){
    $.ajax({
        url: controller,
        type: 'POST',
        data: data, // $(this).serialize(); you can use this too
        success: succFunc

    });
  }
function checkBeforeDelete(){
  if(confirm('แน่ใจว่าคุณต้องการลบ?')){
    return true;
  }
  else{
    return false;
  }
}
function alert_before_delete(object_anchor)
{
  var returner = false;
  swal(
  {
    title: 'แน่ใจนะ? ว่าจะลบ',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่!',
    closeOnConfirm: false
  },function(isConfirm)
  {
    if(isConfirm)
    {
      window.location.href = $(object_anchor).attr("href");
    } 
  });
  return false;
}
function delete_this(object_anchor)
{
  var obj = $(object_anchor);
  var url = obj.attr("href");
  var id = obj.attr("data-id");
  swal({
    title: 'แน่ใจนะ? ว่าจะลบ',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่!',
    closeOnConfirm: false
  }, function() {
    $.ajax({
        type: "POST",
        url: url,
        data: { id: id },
        cache: false,async: false,timeout: 30000,
        success: function (data) {
            obj.parent().parent().fadeOut();
            swal(
              'เรียบร้อย!',
              '',
              'success'
              );
        }
    });
  });
  return false;
}
function deleteThis(object,url,nowID)
{
  swal({
    title: 'แน่ใจนะ? ว่าจะลบ',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่!',
    closeOnConfirm: false
  }, function() {
    $.ajax({
        type: "POST",
        url: url,
        data: { id: nowID },
        cache: false,async: false,timeout: 30000,
        success: function (data) {
            $(object).parent().parent().fadeOut();
            swal(
              'เรียบร้อย!',
              '',
              'success'
              );
        }
    });

  });
}
function timeDiff(time1,time2)
  {
    time1 = time1.split(":");
    var start1 = time1[0]*60*60;
    var end1 = time1[1]*60;
    var stime1 = start1+end1;

    time2 = time2.split(":");
    var start2 = time2[0]*60*60;
    var end2 = time2[1]*60;
    var stime2 = start2+end2;

    var sumtime = (stime2-stime1)/  ( 60 * 60 ); // 1 Hour =  60*60

    return sumtime;

  }