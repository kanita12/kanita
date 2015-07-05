รายละเอียดใบลา

ผู้ลา
รหัสพนักงาน : 
ชื่อ : 
เนื่องจาก : 

วันที่ขอลา :
จนถึงวันที่ : 
<?php echo form_open($form_url) ?>
<input type="hidden" name="hd_hr_userid" value="<?php echo $hr_userid ?>">
<input type="hidden" name="hd_headman_userid" value="<?php echo $headman_userid ?>">
<input type="hidden" name="hd_leave_id" value="<?php echo $leave_id ?>">

ความคิดเห็นเพิ่มเติม : <textarea name="txt_remark" rows="5" cols="30"></textarea>

<input type="radio" name="rdo_work" value="4"> อนุมัติ
<input type="radio" name="rdo_work" value="5"> ไม่อนุมัติ

<input type="submit" value="บันทึก">
<?php echo form_close(); ?>
