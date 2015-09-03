<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<strong>Edit Prayer Request</strong>
					</h3>
				</div><!-- /.box-header -->

				<?php $this->load->view($modulePath.'prayer/edit_content', array('prayer'=> $prayer)); ?>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->