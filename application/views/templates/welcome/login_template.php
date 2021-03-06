
<div class="panel panel-default" style="max-width: 450px; margin: auto;">
    <div class="panel-heading">
        Haptic Collision Webinterface
    </div>
    <div class="panel-body">

        <fieldset>
            <div class="row" style="margin-bottom:25px; margin-top:15px;">
                <div class="center-block" style="text-align: center;">
                    <img src="<?php echo base_url() ?>img/logo_uzleuven.jpg" alt="logo" width="200px" height="80px"/>
                </div>
            </div>

            <?php
            if (isset($bAlert) && !empty($bAlert)){
                if ($bAlert){
                    echo '
                                <div class="col-md-12 alert alert-success alert-dismissable">
                                     You are <strong>successfully</strong> added to the system, check your email to set up the two-factor authentication. The Administator has to approve you before you can login.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>';
                }
            }
            ?>

            <div class="row">
                <?php echo form_open('frmlogin'); ?>

                <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>


                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmLoginUsername" class="form-control" placeholder="Username" value="<?php echo set_value('frmLoginUsername'); ?>" required>
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="password" name="frmLoginPassword" class="form-control" placeholder="Password" value="<?php echo set_value('frmLoginPassword'); ?>" required>
                    </div>

                    <div class="form-group">
                        <input name="frmLoginSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Log in">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6" >
                                <a href="register">Register</a>
                            </div>
                            <div class="col-sm-6"style="text-align: right;">
                                <a href="password">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </fieldset>
    </div>
</div>