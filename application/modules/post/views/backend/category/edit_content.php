<form class="form-horizontal validate" action="" method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name" >Category Name</label>
            <div class="col-sm-8">
                <input id="name" type="text" name="name" class="form-control required" value="<?php echo set_value('name')?:$category->getName(); ?>" placeholder="Category Name" required/>
                <?php echo form_error('name'); ?>
            </div>                            
        </div>
    </div>
    
    <div class="box-footer clearfix">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary" value="Update">Update</button>
                <a href="<?php echo site_url('admin/post/category')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>