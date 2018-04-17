
<div class="panel panel-default" style="max-width: 450px; margin: auto;">
    <div class="panel-heading">
        Ortho Analyzer Webinterface
    </div>
    <div class="panel-body">

        <fieldset>
            <div class="row" style="margin-bottom:25px; margin-top:15px;">
                <div class="center-block" style="text-align: center;">
                    <img src="<?php echo base_url() ?>img/logo_uzleuven.jpg" alt="logo" width="200px" height="80px"/>
                </div>
            </div>

            <div class="row">
                <?php echo form_open('frmreset'); ?>

                <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>


                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="password" name="frmResetPassword" class="form-control" placeholder="New Password" value="<?php echo set_value('frmResetPassword'); ?>">
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="password" name="frmResetPasswordConfirm" class="form-control" placeholder="Confirm Password" value="<?php echo set_value('frmResetPasswordConfirm'); ?>">
                    </div>
					
					<div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="hidden" name="token" value="<?php echo set_value('token', $this->uri->segment(3)); ?>">
                    </div>

                    <div class="form-group">
                        <input name="frmResetSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Reset password">
                    </div>

                </div>
                <?php echo form_close(); ?>

            </div>

        </fieldset>
    </div>
</div>