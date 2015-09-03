<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<strong>Reset Password <em>(<?php echo $user->getUsername(); ?>)</em></strong>
					</h3>
				</div><!-- /.box-header -->

				<div class="box-body">
				    <form class="form-horizontal validate" method="POST" action="">

				        <div class="form-group">
				            <label class="col-sm-2 control-label" for="password">Password</label>
				            <div class="col-sm-8">
				                <input class="form-control required" type="password" id="password" name="password" value="" placeholder="Password" required>
				                <?php echo form_error('password'); ?>    
				            </div>
				        </div>

				        <div class="form-group">
				            <label class="col-sm-2 control-label" for="confPassword">Confirm Password</label>
				            <div class="col-sm-8">
				                <input class="form-control required" type="password" id="confPassword" name="confPassword" value="" placeholder="Confirm Password" required>
				                <?php echo form_error('confPassword'); ?>    
				            </div>
				        </div>

				        <div class="form-group">
				            <div class="col-sm-offset-2 col-sm-8">
				                <button type="submit" class="btn btn-info" value="Reset">Reset</button>
				            </div>
				        </div>

				    </form>
				</div>

			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->