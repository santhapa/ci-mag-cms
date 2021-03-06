<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($pageTitle)? $pageTitle." :: ".$pageTitleSuffix : $pageTitleSuffix; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url()?>/bower_components/admin-lte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url()?>/bower_components/admin-lte/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url()?>/bower_components/admin-lte/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="<?php echo base_url()?>assets/templates/common/images/favicon.png" type="image/png" sizes="16x16">

    <style type="text/css">
        span .form-error, 
        span.form-error{
            color: rgb(237, 235, 235);
            display: inline-block;
            padding: 5px 8px;
            background-color: rgb(169, 8, 8);
            border-radius: 6px;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>

</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url(); ?>"><?php echo $this->config->item('project_name'); ?></a>
        </div><!-- /.login-logo -->

        <div class="login-box-body">
            <?php echo ($this->session->flashdata('feedback')) ? $this->session->flashdata('feedback') : ''; ?>

            <?php $this->load->view($content); ?>

        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url()?>/bower_components/admin-lte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url()?>/bower_components/admin-lte/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
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
