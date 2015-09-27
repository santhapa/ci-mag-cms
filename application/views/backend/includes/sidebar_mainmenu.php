<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
    
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php if(\App::isGranted(array('viewUser', 'viewUserGroup'))): ?>
            <li class="treeview">
                <a href="javascript.void(0)">
                    <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(\App::isGranted('viewUserGroup')): ?>
                    <li><a href="<?php echo site_url('admin/user/group');?>"><i class="fa fa-users"></i>View Groups</a></li>
                    <?php endif; ?>
                    <?php if(\App::isGranted('addUser')): ?>
                    <li><a href="<?php echo site_url('admin/user/add');?>"><i class="fa fa-circle-o"></i> Add User</a></li>
                    <?php endif; ?>
                    <?php if(\App::isGranted('viewUser')): ?>
                    <li><a href="<?php echo site_url('admin/user');?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if(\App::isGranted('viewPost')): ?>
            <li class="treeview">
                <a href="javascript.void(0)">
                    <i class="fa fa-user"></i> <span>Posts</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(\App::isGranted('addPost')): ?>
                    <li><a href="<?php echo site_url('admin/post/add');?>"><i class="fa fa-circle-o"></i> Add Post</a></li>
                    <?php endif; ?>
                    <?php if(\App::isGranted('viewPost')): ?>
                    <li><a href="<?php echo site_url('admin/post');?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if(\App::isGranted('viewPage')): ?>
            <li class="treeview">
                <a href="javascript.void(0)">
                    <i class="fa fa-user"></i> <span>Pages</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php if(\App::isGranted('addPage')): ?>
                    <li><a href="<?php echo site_url('admin/page/add');?>"><i class="fa fa-circle-o"></i> Add Page</a></li>
                    <?php endif; ?>
                    <?php if(\App::isGranted('viewPage')): ?>
                    <li><a href="<?php echo site_url('admin/page');?>"><i class="fa fa-circle-o"></i> View All</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
        </ul>


        <?php 
            $factory = new MenuFactory();
            $menu = $factory->createItem('My menu', array('firstClass'=>"helo"));

            $menu->addChild('Pages', array('uri' => 'javascript:void(0)'));
            $menu['Pages']->addChild('Add Page', array('uri' => site_url('admin/page/add')));
            $menu['Pages']->addChild('View All', array('uri' => site_url('admin/page')));


            $menu->addChild('Posts', array('uri' => 'javascript:void(0)'));
            $menu['Posts']->addChild('Add Post', array('uri' => site_url('admin/post/add')));
            $menu['Posts']->addChild('View All', array('uri' => site_url('admin/post')));


            $renderer = new MenuRenderer(new \Knp\Menu\Matcher\Matcher());
            echo $renderer->render($menu, array('currentClass'=> 'active', 'firstClass'=>'', 'lastClass'=>'', 'branch_class'=>'treeview'));
        ?>
    </section>
    <!-- /.sidebar -->
</aside