<form class="form-horizontal validate" action="<?php echo site_url('admin/post/type/add'); ?>" method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name" >Post Type</label>
            <div class="col-sm-8">
                <input id="name" type="text" name="name" class="form-control required" value="<?php echo set_value('name'); ?>" placeholder="Post Type Name" required/>
                <?php echo form_error('name'); ?>
            </div>                            
        </div>
    </div>
    
    <div class="box-footer clearfix">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary" value="Create">Create</button>
                <a href="<?php echo site_url('admin/post/type')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>