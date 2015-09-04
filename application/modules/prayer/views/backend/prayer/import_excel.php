<section class="content-header">
    <span><a href="<?php echo site_url('admin/prayer/downloadSample')?>" class="btn btn-primary"> <i class="fa fa-download"></i> View Sample</a></span>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-mag">
				<div class="box-header with-border">
					<h3 class="box-title">
						<strong>Load Prayer Requests with Excel</strong>
					</h3>
				</div><!-- /.box-header -->

				<form action="" method="POST" class="form-horizontal validate" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="excel_file">Choose File</label>
                            <div class="col-sm-8">
                                <input id="excel_file" type="file" name="excel_file" class="form-control" />
                                <span><strong><em>(Only Excel file)</em></strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary" name="excel_upload" value="Upload">Upload</button>
                                <a href="<?php echo site_url('admin/prayer'); ?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->