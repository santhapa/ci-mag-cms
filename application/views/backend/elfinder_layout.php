<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($pageTitle)? $pageTitle." :: ".$pageTitleSuffix : $pageTitleSuffix; ?></title>

	<!-- jQuery and jQuery UI (REQUIRED) -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css">
	
	<!-- jQuery 2.1.4 -->
	<script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>

	<link href="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/css/elfinder.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/js/elfinder.min.js"></script>
	<link href="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/css/theme.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<?php //$this->load->view('backend/'.$content); ?>
	<?php $this->load->view($modulePath.$content);  ?>

</body>
</html>
