<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<strong>Edit user <em>(<?php echo $user->getUsername(); ?>)</em></strong>
					</h3>
				</div><!-- /.box-header -->

				<?php $this->load->view($modulePath.'user/edit_content'); ?>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->