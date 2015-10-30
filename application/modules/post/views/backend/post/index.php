<?php if(\App::isGranted('addPost')): ?>
<!-- Main content -->
<section class="content-header">
		<span><a href="<?php echo site_url('admin/post/add')?>" class="btn btn-primary">Add Post</a></span>
</section>
<?php endif; ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title">List of Posts</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#published" data-toggle="tab"><strong>Published</strong></a></li>
							<li><a href="#draft" data-toggle="tab"><strong>Draft</strong></a></li>
							<li><a href="#trash" data-toggle="tab"><strong>Trash</strong></a></li>
							<li><a href="#all" data-toggle="tab"><strong>All</strong></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="published">
								<?php $this->load->view($modulePath.'post/list_content', array('posts'=>$posts, 'status' => \post\models\Post::STATUS_ACTIVE)); ?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="draft">
								<?php $this->load->view($modulePath.'post/list_content', array('posts'=>$posts, 'status' => \post\models\Post::STATUS_DRAFT)); ?>
							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="trash">
								<?php $this->load->view($modulePath.'post/list_content', array('posts'=>$posts, 'status' => \post\models\Post::STATUS_TRASH)); ?>
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="all">
								<?php $this->load->view($modulePath.'post/list_content', array('posts'=>$posts, 'status' => null)); ?>
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div>
				</div>
				<?php if(isset($pagination)):?>
					<div class="box-footer clearfix">
						<?php echo $pagination; ?>
					</div>
				<?php endif;?>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
