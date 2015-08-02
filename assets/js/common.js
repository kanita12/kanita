$(function(){
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
