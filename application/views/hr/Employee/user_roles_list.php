<?php 
	$this->acl->ACL($emp_detail['UserID']); //get acl for want user_id 
?>
<div class="row">
	<div class="col s12">
		<ul class="collection with-header">
			<li class="collection-header">
			 	<h4 class="header">Roles ของพนักงาน [<a href="<?php echo site_url('hr/Employee/manage_user_roles/'.$emp_detail['UserID']) ?>">จัดการ Roles</a>]</h4>
			</li>
			<?php $roles = $this->acl->getUserRoles();
			foreach ($roles as $k => $v): ?>
				<li class="collection-item"><?php echo $this->acl->getRoleNameFromID($v) ?></li>
			<?php endforeach ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col s12">
		
		<ul class="collection with-header">
			<li class="collection-header">
			 	<h4 class="header">
				Permissions ของพนักงาน
				[<a href="<?php echo site_url('hr/Employee/manage_user_permissions/'.$emp_detail['UserID']) ?>">จัดการ Permissions</a>]
				</h4>
			</li>
			<?php $perms = $this->acl->perms;
				foreach ($perms as $k => $v)
				{
					if ( $v['value'] === false )
					{ 
						continue; 
					}
					echo "<li class='collection-item'>" . $v['Name'];
					if ( $v['inheritted'] ) 
					{ 
						echo "  (inheritted)"; 
					}
					echo "</li>";
				}
			?>
		</ul>
	</div>
</div>