<p class="login-box-msg">Reset Password</p>
<form action="" method="post">
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="confPassword" class="form-control" placeholder="Confirm Password" required/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php echo form_error('confPassword'); ?>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset and Login</button>
        </div><!-- /.col -->
    </div>
</form>
