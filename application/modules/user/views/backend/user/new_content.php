<div class="box-body">
    <form class="form-horizontal validate" method="POST" action="">

        <div class="form-group">
            <label class="col-sm-2 control-label" for="username">Username</label>
            <div class="col-sm-8">
                <input class="form-control required" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" >
                <?php echo form_error('username'); ?>    
            </div>
        </div>

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
            <label class="col-sm-2 control-label" for="email">Email Address</label>
            <div class="col-sm-8">
            	<input class="form-control required" type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email Address" required>
                <?php echo form_error('email'); ?>    
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="group">Group</label>
            <div class="col-sm-8">
                <select id="group" name="group" class="form-control required" required>
                	<?php echo user_groups(set_value('group')); ?>
                </select>
            <?php echo form_error('group'); ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-info" value="Create">Create</button>
            </div>
        </div>

    </form>
</div>