<h4 class="header">รหัสพนักงาน <?php echo $emp_detail["EmpID"] ?> <?php echo $emp_detail['EmpFullnameThai'] ?></h4>

<?php echo form_open($form_url); ?>
<input type='hidden' name='hd_user_id' id='hd_user_id' value='<?php echo $user_id ?>'>
<?php
    $this->acl->ACL($user_id);
    $rPerms = $this->acl->perms;
    $aPerms = $this->acl->getAllPerms('full');
    $iVal = '(Deny)';
    $is_key_exists = true;
    $is_key_inheritted = false;
?>
<table class="responsive-table bordered highlight">
    <tr>
    	<th width="30%"></th>
    	<th></th>
    </tr>
	<?php foreach ($aPerms as $k => $v): ?>
	    <tr>
	    	<td><?php echo $v['Name'] ?></td>
	    	<td>
				<?php
					$is_key_inheritted = false;
					$is_key_exists = array_key_exists($v['Key'],$rPerms);
					if( $is_key_exists )
					{
						$is_key_inheritted = $rPerms[$v['Key']]['inheritted'];
					}	
				?>
	    		<select name='perm_<?php echo $v['ID'] ?>'>
	    			<option value='1'
	    				<?php if( $this->acl->hasPermission($v['Key']) && $is_key_exists !== false  && $is_key_inheritted != true ): ?> 
						selected='selected'
		    			<?php endif ?>
		    		>Allow</option>
		    		<option value='0'
			    		<?php if ( $is_key_exists !== false && $rPerms[$v['Key']]['value'] === false && $is_key_inheritted != true ): ?>
			    			selected='selected'
			    		<?php endif ?>
			    	>Deny</option>
			    	<option value='x'
			    		<?php if ( $is_key_exists !== false && $is_key_inheritted == true || !$is_key_exists ): ?>
			    			selected='selected'
			    			<?php if ( $is_key_exists !== false && $rPerms[$v['Key']]['value'] === true ): ?>
			    				<?php $iVal = '(Allow)'; ?>
			    			<?php endif ?>
			    		<?php endif ?>
			    	>Inherit <?php echo $iVal ?></option>
		    	</select>
	    	</td>
	    </tr>
    <?php endforeach ?>  
</table>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('hr/Employees/userroles/'.$emp_detail["EmpID"]) ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>