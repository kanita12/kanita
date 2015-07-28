<html>
<head>
	<title><?php echo $pageTitle ?></title>
	<script type="text/javascript" src="<?php echo js_url();?>jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo js_url();?>common.js"></script>
	<script src="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.css">

	<link type="text/css" rel="stylesheet" href="<?php echo css_url() ?>my_materialize.css"  media="screen,projection"/>
    <script type="text/javascript" src="<?php echo materialize_url() ?>js/materialize.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script type="text/javascript">
      $(document).ready(function()
      {
        $(".button-collapse").sideNav(
          {
            menuWidth: 200
          });
        $('select').material_select();
      });
    </script>
</head>
<body>
	<header>
      <nav class="top-nav">
        <div class="container">
        	<div class="nav-wrapper">
          		<a class="page-title"><?php echo $pageTitle ?></a>
        	</div>
        </div>
      </nav>
      <div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only"><i class="mdi-navigation-menu"></i></a></div>
      <?php $this->load->view('admin/menu_admin'); ?>
  </header>
    <main>
    	<div class="container">
        <br>
    		<div class="row">
				  <div class="col s12">