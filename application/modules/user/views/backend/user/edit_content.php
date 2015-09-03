<div class="box-body">
    <form class="form-horizontal validate" method="POST" action="">

        <div class="form-group">
            <label class="col-sm-2 control-label" for="username">Username</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="username" value="<?php echo $user->getUsername(); ?>" placeholder="Username" readonly="readonly">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="firstname">First Name</label>
            <div class="col-sm-3">
                <input class="form-control required" type="text" id="firstname" name="firstname" value="<?php echo set_value('firstname')?:$user->getFirstname(); ?>" placeholder="First Name" required>
                <?php echo form_error('firstname'); ?>    
            </div>
            <label class="col-sm-2 control-label" for="lastname">Last Name</label>
            <div class="col-sm-3">
                <input class="form-control required" type="text" id="lastname" name="lastname" value="<?php echo set_value('lastname')?:$user->getLastname(); ?>" placeholder="Last Name" required>
                <?php echo form_error('lastname'); ?>    
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">Email Address</label>
            <div class="col-sm-8">
            	<input class="form-control" type="email" id="email" value="<?php echo $user->getEmail(); ?>" placeholder="Email Address" readonly="readonly"> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="group">Group</label>
            <div class="col-sm-8">
                <select id="group" name="group" class="form-control required" required>
                	<?php echo user_groups(set_value('group')?:$user->getGroup()->getId()); ?>
                </select>
            <?php echo form_error('group'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-info" value="Update">Update</button>
            </div>
        </div>

    </form>
</div>