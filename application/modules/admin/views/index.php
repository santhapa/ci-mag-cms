<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <strong>Manage your Dashboard</strong>
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <h3>Welcome to Dashboard!</h3>
                    <?=$this->session->userId; ?>
                    <?php
                        if(\App::isSuperUser())
                        {
                            echo "yess I am Super.";
                        }
                        echo \App::user()->getUsername();
                     ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
 
      