<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <?php
      $i = 0;
      $groupName = array();
    ?>
    <?php foreach ($queryConfigGroup->result_array() as $row): ?>
      <?php if ($i == 0): ?>
        <li role="presentation" class="active"><a href="#<?php echo $row['CFGNameEnglish'] ?>" aria-controls="<?php echo $row['CFGNameEnglish'] ?>" role="tab" data-toggle="tab"><?php echo $row['CFGName'] ?></a></li>
      <?php else: ?>
        <li role="presentation"><a href="#<?php echo $row['CFGNameEnglish'] ?>" aria-controls="<?php echo $row['CFGNameEnglish'] ?>" role="tab" data-toggle="tab"><?php echo $row['CFGName'] ?></a></li>
      <?php endif; ?>
      <?php
        $groupName[$row["CFGID"]] = $row["CFGNameEnglish"];
        $i++;
      ?>
    <?php endforeach; ?>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <?php $i = 0; ?>
    <?php foreach ($groupName as $key=>$value): ?>
      <?php if ($i == 0): ?>
        <div role="tabpanel" class="tab-pane active" id="<?php echo $value ?>">
          <?php echo getConfigurationByConfigGroupID($key); ?>
        </div>
      <?php else: ?>
        <div role="tabpanel" class="tab-pane" id="<?php echo $value ?>">
          <?php echo getConfigurationByConfigGroupID($key); ?>
        </div>
      <?php endif; ?>
      <?php $i++; ?>
    <?php endforeach; ?>
  </div>

</div>
