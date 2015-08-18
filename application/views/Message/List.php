<?php echo form_open(site_url("Message/save_message"));?>
<div class="container">
	<div class="row right-align">
		<div class="col s12">
			<a href="javascript:void(0);" class="btn-floating btn-large waves-effect waves-light red" onclick="$('#send_message').toggle('slow');"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<div id="send_message" class="card" style="display:none;">
  <div class="card-content">
    <div class="row">
      <div class="col s12">
        <div class="input-field col s12">
          <input type="text" name="input_subject" id="input_subject">
          <label for="input_subject">ชื่อเรื่อง</label>
        </div>
        <div class="input-field col s12">
          <textarea name="input_message" id="input_message" class="materialize-textarea"></textarea>
          <label for="input_message">ข้อความ</label>
        </div>
      </div>
    </div>
  </div>
  <div class="card-action right-align">
  	<a href="javascript:void(0);" class="btn-flat waves-effect waves-teal green-text" onclick="check_before_submit();">Send</a>
    <a href="javascript:void(0);" class="btn-flat waves-effect waves-red red-text" onclick="$('#send_message').toggle('slow');">Cancel</a>
  </div>
</div>
<?php echo form_close(); ?>

<table class="bordered highlight">
	<thead>
		<tr>
			<th>วันที่ส่ง</th>
			<th>หัวเรื่อง</th>
			<th>การตอบ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($query->result_array() as $row): ?>
			<tr>
				<td>
					<?php echo date_time_thai_format_from_db($row["MCreatedDate"]); ?>
				</td>
				<td><a href="<?php echo site_url('Message/detail/'.$row["MID"]);?>" target="_blank">
					<?php echo $row["MSubject"]; ?></a></td>
				<td>
					<?php if ($row["LatestReplyBy"] == ""): ?>
						ยังไม่มีการตอบ
						<?php else: ?>
							<?php echo $row["LatestReplyBy"];?> เมื่อ <?php echo date_time_thai_format_from_db($row["LatestReplyDate"]);?>
					<?php endif; ?>
				</td>
				<td>
					<?php if ($row["LatestReplyBy"] == ""): ?>
						<!-- ถ้ายังไม่มีการตอบ ลบได้นะ -->
						<a href="<?php echo site_url('Message/delete/') ?>"
                        data-id="<?php echo $row["MID"] ?>" 
                        class="btn-floating btn-small waves-effect waves-light red"
                        onclick="return delete_this(this);">
                        	<i class="material-icons">delete</i>
                    	</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script type="text/javascript">
	function check_before_submit()
	{
		var subject = $("#input_subject").val();
		var message = $("#input_message").val();
		var msg = "";
		if($.trim(subject) === "")
		{
			msg += "- ชื่อเรื่อง<br/>";
		}
		if($.trim(message) === "")
		{
			msg += "- ข้อความ<br/>";
		}
		if(msg !== "")
		{
			swal({
				title: "กรุณากรอก",
				html: msg,
				type: "error"
			});
			return false;
		}
		else{ $("form").submit(); return false; }
		return false;
	}
</script>