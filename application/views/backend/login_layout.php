<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$pageTitle; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=base_url()?>/bower_components/admin-lte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?=base_url()?>/bower_components/admin-lte/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?=base_url()?>/bower_components/admin-lte/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="<?=base_url()?>assets/templates/common/images/favicon.png" type="image/png" sizes="16x16">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?=base_url(); ?>"><?=$this->config->item('project_name'); ?></a>
        </div><!-- /.login-logo -->

        <?php $this->load->view($modulePath.$content); ?>

    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url()?>/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_url()?>/bower_components/admin-lte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?=base_url()?>/bower_components/admin-lte/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>
