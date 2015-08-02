<script type='text/javascript'>
$(document).ready(function(){
  swal({
    title: 'เรียบร้อยแล้ว',
    closeOnConfirm: true,
    showCancelButton: false,
    type:'success'
  },function() {
    window.location.href="<?php echo $url; ?>";
  });

});
</script>
