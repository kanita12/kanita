<input type="hidden" id="hdUrl" value="<?php echo $ajaxUrl; ?>"/>
<h1><?php echo $topicPage ?></h1>
<br/>
<br/>
<div id='calendar'></div>
<div>
	<?php foreach ($query as $row): ?>
		<?php echo dateThaiFormatFromDB($row["HDate"]) ?>
		<?php echo $row["HName"] ?>
	<?php endforeach ?>
</div>

<link rel='stylesheet' href='<?php echo js_url() ?>fullcalendar/fullcalendar.css' />
<script src='<?php echo js_url() ?>fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo js_url() ?>fullcalendar/fullcalendar.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    var ajaxUrl = $("#hdUrl").val();
    $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',	
		},
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: ajaxUrl,
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