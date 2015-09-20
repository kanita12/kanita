<link rel='stylesheet' href='<?php echo js_url()?>fullcalendar/fullcalendar.css' />
<script src='<?php echo js_url()?>fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo js_url()?>fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
$(document).ready(function() {

    // page is now ready, initialize the calendar...
    var emp_id = $("#hd_emp_id").val();
    var site_url = $("#hd_site_url").val();
    var ajax_url = site_url+"Worktime/feed/"+emp_id;
    $('#calendar').fullCalendar({
    	timezones:'Asia/Bangkok',
			header: {
				left: 'prev,next today',
				center: 'title',
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: ajax_url,
        		type: 'POST',
				error: function() {
					$('#script-warning').show();
				}
			},
			loading: function(bool) {
				$('#loading').toggle(bool);
			}
		});

});
function printpdf()
{
	event.preventDefault();
	var moment = $('#calendar').fullCalendar('getDate');
	var year =  moment.format('YYYY');
	var month = parseInt(moment.format('MM'));
	var site_url = "<?php echo site_url(); ?>";
	var emp_id = "<?php echo $emp_id; ?>";
	if(emp_id != ""){ emp_id = emp_id;}
	var redirect_url = site_url+"Worktime/printpdf/"+year+"/"+month+"/"+emp_id;
	window.open(redirect_url, '_blank');
	return false;
}
</script>
<input type="hidden" name="hd_emp_id" id="hd_emp_id" value="<?php echo $emp_id ?>">
<input type="hidden" name="hd_site_url" id="hd_site_url" value="<?php echo site_url(); ?>">
<br>
<div class="right-align">
	<a href="<?php echo site_url("Worktime/myshiftwork/".$emp_id) ?>" class="btn waves-effect waves-light" target="_blank">ตารางเวลาเข้าออกงาน</a>
</div>
<br><br>
<div id='calendar'></div>
<br>
<div class="divider"></div>
<div class="section">
	<div class="center-align">
		<a href="javascript:void(0);" onclick="printpdf();" class="btn waves-effect waves-light" target="_blank">Print PDF</a>
	</div>
</div>