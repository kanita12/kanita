<h2><?php echo $topic; ?></h2>
<br/>

<?php echo form_open(site_url("Message/save_message"));?>

<a href="javascript:void(0);" onclick="$('#send_message').toggle('slow');">ข้อความใหม่</a>

<div id="send_message" style="display: none;">
	ชื่อเรื่อง : <input type="text" name="input_subject">
	<br>
	ข้อความ : 
	<br>
	<textarea name="input_message"></textarea>
	<br>
	<input type="submit" value="ส่งข้อความ">
</div>

<?php echo form_close(); ?>

<br/>
<br/>
<div class="CSSTableGenerator">
	<table>
		<tr>
			<td>วันที่ส่ง</td>
			<td>หัวเรื่อง</td>
			<td>การตอบ</td>
		</tr>
		<?php foreach($query->result_array() as $row){ ?>
		<tr>
			<td><?php echo $row["MCreatedDate"]; ?></td>
			<td><a href="<?php echo site_url('Message/detail/'.$row["MID"]);?>" target="_blank">
				<?php echo $row["MSubject"]; ?></a></td>
			<td>
				<?php if ($row["LatestReplyBy"] == ""): ?>
					ยังไม่มีการตอบ
					<?php else: ?>
						<?php echo $row["LatestReplyBy"];?> เมื่อ <?php echo $row["LatestReplyDate"];?>
				<?php endif; ?>
				</td>
		<?php } ?>
	</table>
</div>