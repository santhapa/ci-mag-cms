<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>File Manager</title>

	

	<!-- jQuery and jQuery UI (REQUIRED) -->
	<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	
	<!-- jQuery 2.1.4 -->
	<script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>

	<link href="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/css/elfinder.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/js/elfinder.min.js"></script>
	<link href="<?php echo base_url()?>assets/templates/backend/plugins/elfinder/css/theme.css" rel="stylesheet" type="text/css" />

	
	<script type="text/javascript" charset="utf-8">

	    // Helper function to get parameters from the query string.
	    function getUrlParam(paramName) {
	        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
	        var match = window.location.search.match(reParam) ;

	        return (match && match.length > 1) ? match[1] : '' ;
	    }

	    $(document).ready(function() {
	        var funcNum = getUrlParam('CKEditorFuncNum');

	        var elf = $('#elfinder').elfinder({
	            url : '<?php echo site_url("elfinder/init") ?>',
	            getFileCallback : function(file) {
	                window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
	                window.close();
	            },
	            resizable: false
	        }).elfinder('instance');
	    });

	</script>
</head>
<body>
	<!-- Element where elFinder will be created (REQUIRED) -->
	<div id="elfinder"></div>

</body>
</html>
