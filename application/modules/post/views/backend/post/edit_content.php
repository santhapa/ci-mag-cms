<script src="<?php echo base_url()?>/bower_components/tagmanager/tagmanager.js"></script>
<link href="<?php echo base_url()?>/bower_components/tagmanager/tagmanager.css" rel="stylesheet" type="text/css" />

<form class="form-horizontal validate" action="" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Content of the Post</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title" >Title</label>
                            <div class="col-sm-10">
                                <input id="title" type="text" name="title" class="form-control required" value="<?php echo set_value('title')?:$post->getTitle(); ?>" placeholder="Posts Title" required/>
                                <?php echo form_error('title'); ?>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="content" cols="10" rows="10" placeholder="Write content here"><?php echo set_value('content')?:$post->getContent(); ?></textarea>   
                            </div>                        
                        </div>

                    </div>              
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Post Media<small>&emsp;<em>(<span id="meta-option"></span>)</em>)</small></strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                    </div>
                </div><!-- /.box -->

            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Post Type</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php foreach ($postTypes as $pt): ?>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="radio" id="<?php echo $pt->getName().$pt->getId(); ?>" class="required" name="postType" 
                                        <?php echo set_radio('postType', $pt->getId()); ?> value="<?php echo $pt->getId(); ?>"
                                        <?php echo ($post->getPostType()->getId() == $pt->getId())?'checked="checked"' : ''; ?>>&emsp;
                                    <label for="<?php echo $pt->getName().$pt->getId(); ?>"><?php echo ucfirst($pt->getName()); ?></label>                       
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>              
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Category</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php foreach ($categorys as $cat): ?>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="checkbox" id="<?php echo $cat->getName().$cat->getId(); ?>" class="required" name="category[]" 
                                        <?php echo set_checkbox('category[]', $cat->getId()); ?> value="<?php echo $cat->getId(); ?>">&emsp;
                                    <label for="<?php echo $cat->getName().$cat->getId(); ?>"><?php echo ucfirst($cat->getName()); ?></label>                       
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>              
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Tags</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="tags" type="text" class="form-control tag-input" value="" placeholder="Tags"/>
                                <?php echo form_error('tags'); ?>
                            </div>                            
                        </div>
                    </div>              
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    
    <div class="box-footer clearfix">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-info" name="update" value="Update">Update</button>
                <a href="<?php echo site_url('admin/post')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function(){
        var tags = "<?php echo set_value('tags')?:$oldTags; ?>";
        var preSet = Array();
        preSet = tags.split(',');
    
        $("#tags").tagsManager({
            prefilled: preSet,
            CapitalizeFirstLetter: false,
            hiddenTagListName: 'tags',
            deleteTagsOnBackspace: true,
            tagsContainer: null,
            tagCloseIcon: '×',
            tagClass: 'tag-input'
        });
    });
</script>