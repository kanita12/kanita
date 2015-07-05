<script type="text/javascript" src="<?php echo js_url() ?>jOrgChart/jquery.jOrgChart.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>jOrgChart/prettify.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/jquery.jOrgChart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/prettify.css" />

<div class="text-center">
<?php echo $chartData ?>
</div>

<div id="chart" class="orgChart"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#org").jOrgChart({
          chartElement : '#chart'
        });
    });
</script>