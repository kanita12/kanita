<h2><?php echo $topic; ?></h2>
<br/>

<table>
	<tr>
		<td>วันที่ส่ง</td>
		<td>หัวเรื่อง</td>
		<td>ผู้ส่ง</td>
		<td>การตอบ</td>
	</tr>
	<?php foreach($query->result_array() as $row){ ?>
	<tr>
		<td><?php echo $row["MCreatedDate"]; ?></td>
		<td><a href="<?php echo site_url('Message/detail/'.$row["MID"]);?>" target="_blank">
			<?php echo $row["MSubject"]; ?></a></td>
			<td><?php echo $row["M_EmpID"]; ?></td>
		<td><?php echo $row["LatestReplyBy"];?> เมื่อ <?php echo $row["LatestReplyDate"];?></td>
	<?php } ?>
</table>

<?php echo $links;?>

