<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <div class="box-header with-border">
                        <h3 class="box-title">Choose a strong Password <em>(<?php echo $user->getUsername(); ?>)</em></h3>
                </div><!-- /.box-header -->
                <form method="post" action="" class="form-horizontal validate">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="oldPwd">Old Password</label>
                            <div class="col-sm-8">
                                <input id="oldPwd" type="password" name="oldPwd" class="form-control required"/>
                                <?php echo form_error('oldPwd'); ?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="newPwd">New Password</label>
                            <div class="col-sm-8">
                                <input id="newPwd" type="password" name="newPwd" class="form-control required" minlength="6"/>
                                <?php echo form_error('newPwd'); ?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="conPwd">Confirm Password</label>
                            <div class="col-sm-8">
                                <input id="conPwd" type="password" name="conPwd" class="form-control required" minlength="6"/>
                                <?php echo form_error('conPwd'); ?>  
                            </div>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary" value="Change">Change</button>
                                <a href="<?php echo site_url('admin/dashboard')?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>