<?php if(\App::isGranted('addPage')): ?>
<!-- Main content -->
<section class="content-header">
		<span><a href="<?php echo site_url('admin/page/add')?>" class="btn btn-primary">Add Page</a></span>
</section>
<?php endif; ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title">List of Pages</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#all" data-toggle="tab"><strong>All</strong></a></li>
							<li><a href="#draft" data-toggle="tab"><strong>Draft</strong></a></li>
							<li><a href="#trash" data-toggle="tab"><strong>Trash</strong></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="all">
								<?php $this->load->view($modulePath.'page/list_content', array('pages'=>$pages, 'status' => null)); ?>
							</div><!-- /.tab-pane -->
							
							<div class="tab-pane" id="draft">
								<?php $this->load->view($modulePath.'page/list_content', array('pages'=>$pages, 'status' => \page\models\Page::STATUS_DRAFT)); ?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="trash">
								<?php $this->load->view($modulePath.'page/list_content', array('pages'=>$pages, 'status' => \page\models\Page::STATUS_TRASH)); ?>
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
