<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <strong>Assign new group to users under <em>(<?php echo $group->getName();?>)</em></strong>
                    </h3>
                </div><!-- /.box-header -->

                <?php $this->load->view($modulePath.'group/delete_content'); ?>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->