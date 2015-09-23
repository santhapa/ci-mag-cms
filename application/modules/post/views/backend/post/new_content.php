<script src="<?php echo base_url()?>/bower_components/tagmanager/tagmanager.js"></script>
<link href="<?php echo base_url()?>/bower_components/tagmanager/tagmanager.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url()?>assets/templates/backend/plugins/ckeditor/ckeditor.js"></script>

<style type="text/css">
    label{
        font-weight: normal;
    }
</style>

<form class="form-horizontal validate" action="<?php echo site_url('admin/post/add'); ?>" method="post">
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
                            <div class="col-sm-12">
                                <input id="title" type="text" name="title" class="form-control required" required value="<?php echo set_value('title'); ?>" placeholder="Posts Title" required/>
                                <?php echo form_error('title'); ?>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control required" id="content-editor" name="content" cols="10" rows="10" placeholder="Write content here"></textarea>   
                            </div>                        
                        </div>

                    </div>              
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <strong>Media Manager</strong>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="meta" type="hidden" name="meta" class="form-control" value="<?php echo set_value('title'); ?>"/>
                                <button id="elfinder_browse" class="btn btn-primary">Browse Server</button>
                            </div>                            
                        </div>
                        <div id="preview"></div>
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
                                    <input type="radio" id="<?php echo $pt->getName(); ?>" name="postType" 
                                        <?php echo set_radio('postType', $pt->getId()); ?> value="<?php echo $pt->getId(); ?>">&emsp;
                                    <label for="<?php echo $pt->getName(); ?>"><?php echo ucfirst($pt->getName()); ?></label>                       
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
                                    <input type="checkbox" id="<?php echo $cat->getName().$cat->getId(); ?>" name="category[]" 
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
                <button type="submit" class="btn btn-info" name="btnSave" value="Save">Save</button>
                <button type="submit" class="btn btn-primary" name="btnPublish" value="Publish">Publish</button>
                <a href="<?php echo site_url('admin/post')?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function(){
        var tags = "<?php echo set_value('tags'); ?>";
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

<script type="text/javascript">
    CKEDITOR.replace('content-editor',{
        filebrowserImageBrowseUrl : '<?php echo site_url("admin/media/elfinder/ckeditor"); ?>'
    });
</script>

<script type="text/javascript">
    
    $(function(){
        postType =  'general';
        prevSrc = {general:'', audio:'', video:'', gallery:''};

        $('input[name=postType]').change(function(){
            postType = $(this).attr('id');
            $('input#meta').val(prevSrc[postType]);

            preview(postType, prevSrc[postType]);
        });

        //elfinder form url 
        $('#elfinder_browse').on("click",function() {
            var input = $(this).prev('input');
            var id = $(input).attr('id');
            var url = "<?php echo site_url('admin/media/elfinder/image'); ?>";
            var param = "id="+id;
            switch(postType)
            {
                case 'general':{
                    url = "<?php echo site_url('admin/media/elfinder/image'); ?>";
                    break;
                }
                case 'audio':{
                    url = "<?php echo site_url('admin/media/elfinder/audio'); ?>";
                    break;
                }
                case 'video':{
                    url = "<?php echo site_url('admin/media/elfinder/video'); ?>";
                    break;
                }
                case 'gallery':{
                    url = "<?php echo site_url('admin/media/elfinder/image'); ?>";
                    param = "id="+id+"&multiple=true";
                    break;
                }
                default:{
                    url = "<?php echo site_url('admin/media/elfinder/image'); ?>";
                    break;
                }
            }

            var childWin = window.open(url+"?"+param, "popupWindow", "height=450, width=900");
            
            $('input#'+id).on('change', function(){
                var src = $(this).val();
                prevSrc[postType] = src;

                preview(postType, src);
            });

            return false;
        });
    });

    function preview(pt, src)
    {   
        if(typeof src !== 'undefined' && src){
            if(pt == 'general'){
                $('#preview').html('<img class="img-responsive img-rounded" src="'+src+'">');
            }else if(pt == 'audio'){
                $('#preview').html('<audio controls="controls"><source src="'+src+'" type="audio/mpeg"></audio>');
            }else if(pt == 'video'){
                 $('#preview').html('<video width="320" height="240" controls><source src="'+src+'"type="video/mp4"></video>');
            }else if(pt == 'gallery'){
                var previewImgs ='';
                var imgs = src.split(',');
                for(var i=0; i< imgs.length; i++)
                {
                    previewImgs+='<img style="width: 120px; margin:10px" class="img-responsive img-thumbnail" src="'+imgs[i]+'">';
                }
                $('#preview').html(previewImgs);
            }else{
                $('#preview').html('<small><em>Preview not available!</em></small>');
            }
        }else{
            $('#preview').html('<small><em>Preview not available!</em></small>');
        }
        
    }

    function setValue(value, element_id) {
        $((element_id ? 'input#'+ element_id : '')).val(value).change();
    }
</script>