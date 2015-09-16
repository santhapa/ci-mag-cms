<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <strong>Associate posts under <em>(<?php echo $postType->getName();?>)</em> to new post type</strong>
                    </h3>
                </div><!-- /.box-header -->

                <?php $this->load->view($modulePath.'post/type/delete_content'); ?>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->