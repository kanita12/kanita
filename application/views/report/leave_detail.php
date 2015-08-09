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
		div,p{font-size:12px;}
		table td{font-size:12px;}
		.center, .center-align {text-align: center;}
		.right-align{text-align:right;}
		h4{font-size:33px;font-weight: normal;line-height:20px;}
		h5{font-size:23px;font-weight: normal;line-height:10px;}
		table.salary{width:100%;border:1px solid #E0E0E0;border-collapse:inherit;border-spacing: 0;}
		table.salary tr.header td{border-bottom:1px solid #000;}
		table.salary tr.footer td{border-top:1px solid #000;border-bottom:1px solid #000;}
	</style>
	<h4 class="center-align">เอกสารการลางาน</h4>
	<div class="right-align">
		<b>เขียนที่</b> ออนไลน์
		<br>
		<b>วันที่</b> <?php echo date_thai_format_no_time_full_from_db($query["LCreatedDate"]); ?>
	</div>
	<div>
		<b>เรื่อง</b> <?php echo $query["LTName"] ?>
		<br>
		<b>เรียน</b> คณะผู้บริหาร
	</div>
	<p>เนื่องด้วยข้าพเจ้า <?php echo $emp_detail["EmpFullnameThai"]; ?> หน่วยงาน<?php echo $emp_detail["InstitutionName"]; ?> แผนก<?php echo $emp_detail["DepartmentName"]; ?> ตำแหน่ง<?php echo $emp_detail["PositionName"]; ?>
	<br>&nbsp;<br>
	มีความประสงค์ขอ<?php echo $query["LTName"]; ?>เนื่องจาก <?php echo $query["LBecause"]; ?>
	<br>&nbsp;<br>
	เป็นเวลา <?php echo $query["sum_leave_time"]; ?> ตั้งแต่วันที่ <?php echo dateThaiFormatFromDB($query["LStartDate"]) ?> เวลา <?php echo timeFormatNotSecond($query["LStartTime"]) ?>น. จนถึง <?php echo dateThaiFormatFromDB($query["LEndDate"]) ?> เวลา <?php echo timeFormatNotSecond($query["LEndTime"]); ?>น.
	</p>
	<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
	<div class="right-align">
		<table>
			<tr>
				<td></td>
				<td class="center-align">
					จึงเรียนมาเพื่อทราบ
					<br>&nbsp;<br>&nbsp;<br>
					________________________________
					<br>&nbsp;<br>
					(<?php echo $emp_detail["EmpFullnameThai"]; ?>)
				</td>
			</tr>
		</table>
	</div>
	<hr>
	<table>
		<tr>
			<td>
				สถิติการลาในปีงบประมาณนี้
			</td>
			<td class="center-align" valign="bottom" style="height:300px">
				<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
				<?php foreach ($query_log as $row): ?>
					ผู้อนุมัติ <?php echo $row["EmpFullnameThai"]; ?>
					<br>
					ตำแหน่ง<?php echo $row["PositionName"]; ?> / แผนก<?php echo $row["DepartmentName"]; ?>
					<br>
					<?php echo date_thai_format_no_time_from_db($row["LLDate"]); ?>
					<?php if ($row !== end($query_log)) : ?>
						<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
					<?php endif ?>
				<?php endforeach ?>
			</td>
		</tr>
	</table>
	<?php
    // we can have any view part here like HTML, PHP etc
    $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output($emp_detail["EmpID"].'_leave_'.$year.'_'.$month.'.pdf', 'I');