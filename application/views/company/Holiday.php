<input type="hidden" id="hdUrl" value="<?php echo $ajaxUrl; ?>"/>
<div class="section">
	<div id='calendar'></div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3 center-align">
			<table class="bordered highlight">
				<thead>
					<tr>
						<th>วันที่</th>
						<th>ชื่อวันหยุด</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($query as $row): ?>
						<tr>
							<td><?php echo dateThaiFormatUn543FromDB($row["HDate"]) ?></td>
							<td><?php echo $row["HName"] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
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