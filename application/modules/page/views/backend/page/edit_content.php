<script src="<?php echo base_url()?>assets/templates/backend/plugins/ckeditor/ckeditor.js"></script>

<style type="text/css">
    label{
        font-weight: normal;
    }
</style>

<form class="form-horizontal validate" action="" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Content of the Page</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="title" type="text" name="title" class="form-control required" required value="<?php echo set_value('title')?:$page->getTitle(); ?>" placeholder="Page    Title" required/>
                                <?php echo form_error('title'); ?>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control required" id="content-editor" name="content" cols="10" rows="10" placeholder="Write content here"><?php echo set_value('content')?:$page->getContent(); ?></textarea>   
                            </div>                        
                        </div>

                    </div>              
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Featured Image</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="featuredImage" type="hidden" name="featuredImage" class="form-control" value="<?php echo set_value('featuredImage')?:$page->getFeaturedImage(); ?>"/>
                                <button id="featuredImage_browse" class="btn btn-primary">Browse Server</button>                                
                                <span class="btn removeBtn" style="color: red; display:none;"><u>Remove</u></span>
                            </div>                            
                        </div>
                        <div id="preview"></div>
                    </div>              
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Page Attributes</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="checkbox" id="showComments" name="showComments" value="1" 
                                    <?php echo set_checkbox('showComments', 1); ?>
                                    <?php echo $page->getShowComments()? 'checked="checked"':''; ?>>&emsp;
                                <label for="showComments">Manage comments</label>                       
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
                <button type="submit" class="btn btn-info" name="btnSave" value="Save">Save</button>
                <?php if($page->isDraft()): ?>
                    <button type="submit" class="btn btn-primary" name="btnPublish" value="Publish">Publish</button>
                <?php endif; ?>
                <a href="<?php echo site_url('admin/page')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>


<script type="text/javascript">
    CKEDITOR.replace('content-editor',{
        filebrowserImageBrowseUrl : '<?php echo site_url("admin/media/elfinder/ckeditor"); ?>'
    });
</script>

<script type="text/javascript">
    
    $(function(){
        var featuredImage = "<?php echo set_value('featuredImage')?:$page->getFeaturedImage(); ?>";
        if(featuredImage)
        {
            preview(featuredImage);
            $('.removeBtn').show();
        } 

        //elfinder form url 
        $('#featuredImage_browse').on("click",function() {
            var input = $(this).prev('input');
            var id = $(input).attr('id');
            var url = "<?php echo site_url('admin/media/elfinder/image'); ?>";
            var param = "id="+id;

            var childWin = window.open(url+"?"+param, "popupWindow", "height=450, width=900");
            
            $('input#'+id).on('change', function(){
                var src = $(this).val();
                if(src) $('.removeBtn').show();
                preview(src);
            });

            return false;
        });

        $("body").on("click",".removeBtn",function(event){
            removeMedia();
        });
    });

    function preview(src)
    {   
        if(typeof src !== 'undefined' && src){
             $('#preview').html('<img class="img-responsive img-rounded" src="'+src+'">');
        }else{
            $('#preview').html('<small><em>Featured image not set!</em></small>');
        }
    }

    function setValue(value, element_id) {
        $((element_id ? 'input#'+ element_id : '')).val(value).change();
    }

    function removeMedia()
    {
        $('#preview').html('');
        $('input#featuredImage').val('');
        $('.removeBtn').hide();

        return false;
    }
</script>