<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <strong>Edit Group <em>(<?php echo $group->getName();?>)</em></strong>
                    </h3>
                </div><!-- /.box-header -->

                <?php $this->load->view($modulePath.'group/edit_content'); ?>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->