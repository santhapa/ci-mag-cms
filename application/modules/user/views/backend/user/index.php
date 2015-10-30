<?php if(\App::isGranted('addUser')): ?>
<!-- Main content -->
<section class="content-header">
		<span><a href="<?php echo site_url('admin/user/add')?>" class="btn btn-primary">Add User</a></span>
</section>
<?php endif; ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title">List of Users</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#active" data-toggle="tab"><strong>Active</strong></a></li>
							<li><a href="#trash" data-toggle="tab"><strong>Trash</strong></a></li>							
							<li><a href="#all" data-toggle="tab"><strong>All</strong></a></li>
						</ul>
						<div class="tab-content">							
							<div class="tab-pane active" id="active">
								<?php $this->load->view($modulePath.'user/list_content', array('users'=>$users, 'status' => \user\models\User::STATUS_ACTIVE)); ?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="trash">
								<?php $this->load->view($modulePath.'user/list_content', array('users'=>$users, 'status' => \user\models\User::STATUS_TRASH)); ?>
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="all">
								<?php $this->load->view($modulePath.'user/list_content', array('users'=>$users, 'status' => null)); ?>
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
