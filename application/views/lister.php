
<script>
$(document).ready(function()
{
	ajaxSubmit();
});
function ajaxSubmit()
{
	var myurl = 'efarmstore.com';
	$.ajax({
		type : "POST",
		url : 'http://www.cekpr.com',
		data: { url: myurl },
		success : function(data) {
			alert(data);
		}
	});
}
</script>