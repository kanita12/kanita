<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "PDF Report";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('freeserif');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('freeserif', '', 9);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();
ob_start();
	?> 
	<style type="text/css">
		div{font-size:12px;}
		table td{font-size:12px;}
		.center, .center-align {text-align: center;}
		.right-align{text-align:right;}
		h4{font-size:33px;font-weight: normal;line-height:20px;}
		h5{font-size:23px;font-weight: normal;line-height:10px;}
		table.salary{width:100%;border:1px solid #E0E0E0;border-collapse:inherit;border-spacing: 0;}
		table.salary tr.header td{border-bottom:1px solid #000;}
		table.salary tr.footer td{border-top:1px solid #000;border-bottom:1px solid #000;}
	</style>
	<table border="0" width="100%">
		<tr>
			<td width="14%">รหัสพนักงาน</td>
			<td width="18%"><?php echo $emp_detail["EmpID"] ?></td>
			<td width="13%">ชื่อ-นามสกุล</td>
			<td colspan="4"><?php echo $emp_detail["EmpFullnameThai"] ?></td>
		</tr>
		<tr>
			<td>แผนก</td>
			<td><?php echo $emp_detail["SectionName"] ?></td>
			<td>ตำแหน่ง</td>
			<td width="23%"><?php echo $emp_detail["PositionName"] ?></td>
			<td width="10%">หน่วยงาน</td>
			<td width="22%"><?php echo $emp_detail["UnitName"] ?></td>
		</tr>
	</table>
	&nbsp;<br>&nbsp;
	<hr>
	&nbsp;<br>&nbsp;
	<h4 class="right-align">รายละเอียดการทำงานล่วงเวลา</h4>
	<div class="right-align">
		ส่งคำขอทำงานล่วงเวลา : วันที่ <?php echo $created_day ?> <?php echo $created_month_name ?> <?php echo $created_year_thai ?>
	</div>
	&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
	<div>วันที่ต้องการทำงานล่วงเวลา : วันที่ <?php echo $day ?> <?php echo $month_name ?> <?php echo $year_thai ?></div>
	<div>ตั้งแต่เวลา : <?php echo timeFormatNotSecond($query["wot_time_from"]); ?>น.</div>
	<div>จนถึงเวลา : <?php echo timeFormatNotSecond($query["wot_time_to"]); ?>น.</div>
	&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
	<div class="right-align">
		<?php foreach ($query_log as $row): ?>
			ผู้อนุมัติ <?php echo $row["EmpFullnameThai"]; ?>
			<br>
			ตำแหน่ง<?php echo $row["PositionName"]; ?> / แผนก<?php echo $row["DepartmentName"]; ?>
			<br>&nbsp;<br>&nbsp;<br>&nbsp;
		<?php endforeach ?>
	</div>
	<?php
    // we can have any view part here like HTML, PHP etc
    $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output($emp_detail["EmpID"].'_ot_'.$year.'_'.$month.'.pdf', 'I');