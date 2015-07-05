<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Test Organization Chart</title>
    <link rel="stylesheet" type="text/css" href="<?php echo bootstrap_url() ?>css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo css_url() ?>stylesheet.css" />
    <script type="text/javascript" src="<?php echo js_url() ?>jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo bootstrap_url() ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo js_url() ?>jOrgChart/jquery.jOrgChart.js"></script>
    <script type="text/javascript" src="<?php echo js_url() ?>jOrgChart/prettify.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/jquery.jOrgChart.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo js_url() ?>jOrgChart/css/prettify.css" />  </head>
  <body>
    <?php echo $chartData ?>

      
    
    
    <div id="chart" class="orgChart"></div>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#org").jOrgChart({
              chartElement : '#chart'
            });
        });
    </script>

  </body>
</html>
