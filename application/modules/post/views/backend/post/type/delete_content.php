<form class="form-horizontal validate" action="" method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="group">New Post Type</label>
            <div class="col-sm-8">
                <select id="group" name="newPostType" class="form-control required" required>
                    <?php echo user_groups(set_value('newPostType'), true, $postType->getSlug()); ?>
                </select>
            <?php echo form_error('newPostType'); ?>
            </div>
        </div>
    </div>
    
    <div class="box-footer clearfix">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary" value="Continue">Continue</button>
                <a href="<?php echo site_url('admin/post/type')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>