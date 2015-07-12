<div class="login-box-body">
    <?php echo ($this->session->flashdata('feedback')) ? $this->session->flashdata('feedback') : ''; ?>
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="" method="post">
        <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username or Email" value="<?php echo (isset($username))? $username: ''; ?>" required/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">    
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
    </form>

    <a href="#">I forgot my password</a><br>
</div><!-- /.login-box-body -->