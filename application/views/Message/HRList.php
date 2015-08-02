<table>
	<tr>
		<td>วันที่ส่ง</td>
		<td>หัวเรื่อง</td>
		<td>ผู้ส่ง</td>
		<td>การตอบ</td>
	</tr>
	<?php foreach($query as $row){ ?>
	<tr>
		<td><?php echo $row["MCreatedDate"]; ?></td>
		<td><a href="<?php echo site_url('Message/detail/'.$row["MID"]);?>" target="_blank">
			<?php echo $row["MSubject"]; ?></a></td>
			<td><?php echo $row["SendEmpID"]; ?></td>
		<td><?php echo $row["ReplyEmpID"];?> เมื่อ <?php echo $row["LatestReplyDate"];?></td>
	<?php } ?>
</table>

<?php echo $links;?>

