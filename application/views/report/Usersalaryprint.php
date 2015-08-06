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
		table td{font-size:12px;}
		.center, .center-align {text-align: center;}
		.right-align{text-align:right;}
		h4{font-size:33px;font-weight: normal;line-height:20px;}
		h5{font-size:23px;font-weight: normal;line-height:10px;}
		table.salary{width:100%;border:1px solid #E0E0E0;border-collapse:inherit;border-spacing: 0;}
		table.salary tr.footer td{border-top:1px solid #000;border-bottom:1px solid #000;}
	</style>
	<h4 class="center-align">รายงานรายได้ประจำเดือน</h4>
	<h5 class="center-align"><?php echo $month_name ?> ปี <?php echo $year_thai ?></h5>
	&nbsp;<br>&nbsp;<br>&nbsp;
	<table border="0" width="100%">
		<tr>
			<td width="14%">รหัสพนักงาน</td>
			<td width="18%"><?php echo $emp_detail["EmpID"] ?></td>
			<td width="13%">ชื่อ-นามสกุล</td>
			<td colspan="4"><?php echo $emp_detail["EmpFullnameThai"] ?></td>
		</tr>
		<tr>
			<td>แผนก</td>
			<td><?php echo $emp_detail["DepartmentName"] ?></td>
			<td>ตำแหน่ง</td>
			<td width="23%"><?php echo $emp_detail["PositionName"] ?></td>
			<td width="10%">หน่วยงาน</td>
			<td width="22%"><?php echo $emp_detail["InstitutionName"] ?></td>
		</tr>
	</table>
	&nbsp;<br>&nbsp;<br>&nbsp;
	<table class="salary" cellpadding="5">
		<tbody>
			<tr>
				<td>เงินเดือน</td>
				<td><?php echo $query_now_salary["sapay_salary"] ?></td>
				<td>-</td>
			</tr>
			<tr>
				<td>ค่าทำงานล่วงเวลา</td>
				<td><?php echo $query_now_salary["sapay_ot"] ?></td>
				<td>-</td>
			</tr>
			<tr>
				<td>รวมเงินได้</td>
				<td><?php echo $query_now_salary["total_income"] ?></td>
				<td>-</td>
			</tr>
			<tr>
				<td>หักค่าประกันสังคม</td>
				<td>-</td>
				<td><?php echo $query_now_salary["sapay_deduction"] ?></td>
			</tr>
			<tr>
				<td>เงินได้สุทธิ</td>
				<td><?php echo $query_now_salary["total_income_deduction"] ?></td>
				<td>-</td>
			</tr>
			<tr>
				<td>หักภาษีเงินได้บุคคลธรรมดา</td>
				<td>-</td>
				<td><?php echo $query_now_salary["sapay_tax"] ?></td>
			</tr>
			<tr class="footer">
				<td>เงินได้สุทธิต่อเดือน</td>
				<td><?php echo $query_now_salary["sapay_net"] ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<?php
    // we can have any view part here like HTML, PHP etc
    $content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output($emp_detail["EmpID"].'_salary_'.$year.'_'.$month.'.pdf', 'I');