<link rel='stylesheet' href='<?php echo js_url() ?>fullcalendar/fullcalendar.css' />
<script src='<?php echo js_url() ?>fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo js_url() ?>fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: 'Activity/feedActivity',
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
</script>
<div id='calendar'></div>