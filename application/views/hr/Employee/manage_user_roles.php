<h2>จัดการ Roles : <?php echo $emp_detail['EmpFullnameThai'] ?></h2>
<?php echo form_open($form_url); ?>

    <input type='hidden' id='hd_user_id' name='hd_user_id' value='<?php echo $user_id ?>'>

    <?php 
        $this->acl->ACL($user_id);
        $roles = $this->acl->getAllRoles('full');
    ?>
    <table>
        <tr>
            <th></th>
            <th>Member</th>
            <th>Not Member</th>
        </tr>
        <?php foreach ($roles as $k => $v): ?>
            <tr>
                <td><?php echo $v['Name'] ?></td>
                <td>
                    <input type="radio" name='role_<?php echo $v['ID'] ?>' name='role_<?php echo $v['ID'] ?>_1'
                    value='1'
                    <?php if ( $this->acl->userHasRole($v['ID']) ): ?>
                        checked='checked'
                    <?php endif ?>
                    >
                </td>
                <td>
                    <input type="radio" name='role_<?php echo $v['ID'] ?>' name='role_<?php echo $v['ID'] ?>_0'
                    value='0'
                    <?php if ( ! $this->acl->userHasRole($v['ID']) ): ?>
                        checked='checked'
                    <?php endif ?>
                    >
                </td>
            </tr>
        <?php endforeach ?>
    <table>
        <input type="submit" name="Submit" value="Submit" />
<?php echo form_close(); ?>
        
  