
<div class="panel panel-default" style="max-width: 35%; margin: auto;">
    <div class="panel-heading">
        Haptic Collision Webinterface
    </div>
    <div class="panel-body">

        <fieldset>

            <div class="row">
                <?php echo form_open('register'); ?>

                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div>
                        <p>We will send you an email with your password</p>
                    </div></vi>
                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="email" name="frmPasswordEmail" class="form-control" placeholder="Email" value="<?php echo set_value('frmPasswordEmail'); ?>">
                    </div>

                    <br>

                    <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>

                    <div class="form-group">
                        <input name="frmRegisterSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Reset password">
                    </div>

                </div>
                <?php echo form_close(); ?>

            </div>

        </fieldset>
    </div>
</div>