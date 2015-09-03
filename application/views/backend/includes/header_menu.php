<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin/dashboard')?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo $this->config->item('project_name_short'); ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo $this->config->item('project_name'); ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php echo \App::user()->getName(); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo \App::user()->getName(); ?>
                                <small>Member since <?php echo \App::user()->getCreatedAt()->format('F d, Y'); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-5 text-center">
                                <a href="<?php echo site_url('admin/user/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="col-xs-7 text-center">
                                <a href="<?php echo site_url('admin/user/changePassword'); ?>" class="btn btn-default btn-flat">Change Password</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="<?php echo site_url('user/logout');?>" class="btn btn-danger btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>