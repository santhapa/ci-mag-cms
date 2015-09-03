<form class="form-horizontal validate" action="" method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="group">New Group</label>
            <div class="col-sm-8">
                <select id="group" name="newGroup" class="form-control required" required>
                    <?php echo user_groups(set_value('newGroup'), true, $group->getSlug()); ?>
                </select>
            <?php echo form_error('newGroup'); ?>
            </div>
        </div>
    </div>
    
    <div class="box-footer clearfix">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary" value="Continue">Continue</button>
                <a href="<?php echo site_url('admin/user/group')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>