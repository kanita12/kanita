<?php echo form_open($formURL); ?>
<input type="hidden" name="hdRoleID" value="<?php echo $roleID ?>" />
<div class="row">
    <div class="col s12">
        <div class="input-field col s12">
            <?php echo form_input(array('name'=>'txtName','id'=>'txtName','value'=>"$varName")); ?>
            <label for="txtName">ชื่อ Role</label>
        </div>
    </div>
            <table>
	        
            <?php
                $lastGroup = '';  
                foreach ($queryPerm as $k => $v): ?>
                <?php 
                    $rp = false;
                    $rpExits = false;
                    if(isset($queryRolePerm[$v['Key']]['value'])){
                        $rp = $queryRolePerm[$v['Key']]['value'];
                        $rpExits = true;
                    }
                    
                    $nowGroup = $v['PermGroupName'];

                ?>
                <?php if ($lastGroup != $nowGroup): ?>
                    <tr>
                        <th colspan="4">
                            Group Permission : <?php echo $nowGroup ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Allow</th>
                        <th>Deny</th>
                        <th>Ignore</th>
                    </tr>
                    <?php $lastGroup = $nowGroup;?>
                <?php endif ?>
                
                <tr>
                    <td><?php echo $v['Name'] ?></td>
                    <td>
                        <?php 
                            echo "<input type=\"radio\" name=\"perm_" . $v['ID'] . "\" ";
                            echo "id=\"perm_" . $v['ID'] . "_1\" value=\"1\" ";
                            if ($rp === true && $roleID != ''){
                                echo " checked=\"checked\"";
                            }
                            echo " /><label for='perm_" . $v['ID'] . "_1'></label>";
                        ?>
                     </td>
                     <td>
                        <?php 
                            echo "<input type=\"radio\" name=\"perm_" . $v['ID'] . "\" ";
                            echo "id=\"perm_" . $v['ID'] . "_0\" value=\"0\" ";
                            if ($rp != true && $roleID != ''){
                                echo " checked=\"checked\"";
                            }
                            echo " /><label for='perm_" . $v['ID'] . "_0'></label>";
                        ?>
                     </td>
                     <td>
                        <?php 
                            echo "<input type=\"radio\" name=\"perm_" . $v['ID'] . "\" ";
                            echo "id=\"perm_" . $v['ID'] . "_X\" value=\"X\" ";
                            if ($roleID == '' || $rpExits == false){
                                echo " checked=\"checked\"";
                            }
                            echo " /><label for='perm_" . $v['ID'] . "_X'></label>";
                        ?>
                     </td>
                </tr> 
            <?php endforeach ?>
            <?php
   
    //         foreach ($queryPerm as $k => $v)
    //         {
    //             echo "<tr><td><label>" . $v['Name'] . "</label></td>";
    //             echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_1\" value=\"1\"";
    //             if ($queryRolePerm[$v['Key']]['value'] === true && $roleID != '') { echo " checked=\"checked\""; }
    //             echo " /></td>";
    //             echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_0\" value=\"0\"";
    //             if ($queryRolePerm[$v['Key']]['value'] != true && $roleID != '') { echo " checked=\"checked\""; }
    //             echo " /></td>";
				// echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_X\" value=\"X\"";
    //             if ($roleID == '' || !array_key_exists($v['Key'],$queryRolePerm)) { echo " checked=\"checked\""; }
    //             echo " /></td>";
    //             echo "</tr>";
    //         }
	            ?>
	            <tr><td colspan="3">
	            <?php echo form_submit('btnSubmit','บันทึก'); ?>
	        </td></tr>
            </table>
            </div>
<?php echo form_close(); ?>