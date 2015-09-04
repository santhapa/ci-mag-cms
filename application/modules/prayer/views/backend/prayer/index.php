<?php if(\App::isGranted('addPrayer')): ?>
<!-- Main content -->
<section class="content-header">
		<span><a href="<?php echo site_url('admin/prayer/add')?>" class="btn btn-primary">Add Prayer Request</a></span>
		&emsp;
		<span><a href="<?php echo site_url('admin/prayer/import')?>" class="btn btn-primary">Import</a></span>
</section>
<?php endif; ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title">List of Prayer Requests</h3>
				</div><!-- /.box-header -->
				
				<!-- box body -->
				<?php $this->load->view($modulePath.'prayer/list_content', array('prayers'=>$prayers)); ?>
				
				<?php if(isset($pagination)):?>
					<div class="box-footer clearfix">
						<?php echo $pagination; ?>
					</div>
				<?php endif;?>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
