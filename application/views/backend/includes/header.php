<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($pageTitle)? $pageTitle." :: ".$pageTitleSuffix : $pageTitleSuffix; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php get_styles(); ?>
</head>
<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <?php get_mainmenu(); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>