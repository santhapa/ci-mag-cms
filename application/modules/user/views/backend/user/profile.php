<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-mag">
                <form method="post" name="user_profile" action="" id="user_profile" class="form-horizontal validate" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="box box-solid box-mag">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <strong>Personal Information</strong>
                                        </h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="firstname">First Name</label>
                                            <div class="col-sm-3">
                                                <input class="form-control required" type="text" id="firstname" name="firstname" value="<?php echo set_value('firstname')?:$user->getFirstname(); ?>" placeholder="First Name" required>
                                                <?php echo form_error('firstname'); ?>    
                                            </div>
                                            <label class="col-sm-2 control-label" for="lastname">Last Name</label>
                                            <div class="col-sm-3">
                                                <input class="form-control required" type="text" id="lastname" name="lastname" value="<?php echo set_value('lastname')?:$user->getLastname(); ?>" placeholder="Last Name" required>
                                                <?php echo form_error('lastname'); ?>    
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="email">Email Address</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="email" id="email" value="<?php echo $user->getEmail(); ?>" placeholder="Email Address" readonly="readonly"> 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="dateOfBirth">Date of Birth</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo set_value('dateOfBirth')?:($user->getDateOfBirth())?$user->getDateOfBirth()->format('Y-m-d'):''; ?>"> 
                                                <?php echo form_error('dateOfBirth'); ?>
                                            </div>                          
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="gender">Gender</label>
                                            <div class="col-xs-4">
                                                <input class="required" type="radio" id="gender" name="gender" value="Male" <?php echo $user->getGender()=='Male'?'checked':''; ?> required>&emsp;Male
                                                 
                                            </div>
                                            <div class="col-xs-4">
                                                <input class="required" type="radio" id="gender" name="gender" value="Female" <?php echo $user->getGender()=='Female'?'checked':''; ?> required>&emsp;Female
                                                <?php echo form_error('gender'); ?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="phoneNumber">Phone Number</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="phoneNumber" name="phoneNumber" value="<?php echo set_value('phoneNumber')?:$user->getPhoneNumber(); ?>" placeholder="Phone Number"> 
                                                <?php echo form_error('phoneNumber'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="mobileNumber">Mobile Number</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="mobileNumber" name="mobileNumber" value="<?php echo set_value('mobileNumber')?:$user->getMobileNumber(); ?>" placeholder="Mobile Number" > 
                                                <?php echo form_error('mobileNumber'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="address">Address</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="address" name="address" value="<?php echo set_value('address')?:$user->getAddress(); ?>" placeholder="Type your address here"> 
                                                <?php echo form_error('address'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="biography">Biography</label>
                                            <div class="col-xs-8">
                                                <textarea class="form-control" id="biography" name="biography" placeholder="Write about you!"><?php echo set_value('biography')?:$user->getBiography(); ?></textarea> 
                                                <?php echo form_error('biography'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="website">Website</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="website" name="website" value="<?php echo set_value('website')?:$user->getWebsite(); ?>" placeholder="Personal site"> 
                                                <?php echo form_error('website'); ?>
                                            </div>                          
                                        </div>
                                    </div>              
                                </div><!-- /.box -->
                            </div><!-- /.col -->

                            <div class="col-sm-6 col-xs-12">
                                <div class="box box-solid box-mag">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <strong>Social Information</strong>
                                        </h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="facebookId">Facebook</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="facebookId" name="facebookId" value="<?php echo set_value('facebookId')?:$user->getFacebookId(); ?>" placeholder="Your facebook url"> 
                                                <?php echo form_error('facebookId'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="gplusId">Google Plus</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="gplusId" name="gplusId" value="<?php echo set_value('gplusId')?:$user->getGplusId(); ?>" placeholder="Your google plus url"> 
                                                <?php echo form_error('gplusId'); ?>
                                            </div>                          
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-2 control-label" for="twitterId">Twitter</label>
                                            <div class="col-xs-8">
                                                <input class="form-control" type="text" id="twitterId" name="twitterId" value="<?php echo set_value('twitterId')?:$user->getTwitterId(); ?>" placeholder="Your twitter url"> 
                                                <?php echo form_error('twitterId'); ?>
                                            </div>                          
                                        </div>
                                    </div>              
                                </div><!-- /.box -->

                                <div class="box box-solid box-mag">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <strong>Confirm</strong>
                                        </h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                         <div class="form-group">
                                            <label class="col-sm-2 control-label" for="username">Username</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" id="username" value="<?php echo $user->getUsername(); ?>" placeholder="Username" readonly="readonly">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-2 control-label" for="password">Current Password</label>
                                            <div class="col-sm-8">
                                                <input class="form-control required" type="password" id="password" name="current_password" placeholder="Current Password" required>
                                                <?php echo form_error('current_password'); ?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="box-footer clearfix">
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <button type="submit" class="btn btn-primary" value="Update">Update</button>
                                                <a href="<?php echo site_url()?>" class="btn btn-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </div>            
                                </div><!-- /.box -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>