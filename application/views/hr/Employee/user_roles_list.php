<h2>
	จัดการสิทธิ์พนักงาน
	<?php echo $emp_detail['EmpNameTitleThai'] ?><?php echo $emp_detail['EmpFirstnameThai'] ?> <?php echo $emp_detail['EmpLastnameThai'] ?>
</h2>
<br><br>
<?php 
	$this->acl->ACL($emp_detail['UserID']); //get acl for want user_id 
?>
<!-- Roles for user -->
<div class='roles-for-user'>
	<h3>
		Roles ของพนักงาน
		[<a href="<?php echo site_url('hr/Employee/manage_user_roles/'.$emp_detail['UserID']) ?>">จัดการ Roles</a>]
	</h3>
	<ul>
		<?php 
			$roles = $this->acl->getUserRoles();
			foreach ($roles as $k => $v)
			{
				echo "<li>" . $this->acl->getRoleNameFromID($v) . "</li>";
			}
		?>
	</ul>
<div>
<!-- Roles for user -->
<br><br>
<!-- Permissions for user -->
<div class='permissions-for-user'>
	<h3>
		Permissions ของพนักงาน
		[<a href="<?php echo site_url('hr/Employee/manage_user_permissions/'.$emp_detail['UserID']) ?>">จัดการ Permissions</a>]
	</h3>
	<ul>
		<?php

			$perms = $this->acl->perms;
			foreach ($perms as $k => $v)
			{
				if ( $v['value'] === false )
				{ 
					continue; 
				}
				echo "<li>" . $v['Name'];
				if ( $v['inheritted'] ) 
				{ 
					echo "  (inheritted)"; 
				}
				echo "</li>";
			}
		?>
	</ul>
</div>
<!-- Permissions for user -->
