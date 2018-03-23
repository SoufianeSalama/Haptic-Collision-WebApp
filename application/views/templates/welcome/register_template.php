<div class="panel panel-default" style="max-width: 350px; margin: auto;">
    <div class="panel-heading">
        Haptic Collision Webinterface
    </div>
    <div class="panel-body">

        <fieldset>

            <div class="row">

                <?php echo form_open('frmregister'); ?>

                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterFirstName" class="form-control" placeholder="First name" value="<?php echo set_value('frmRegisterFirstName'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterLastName" class="form-control" placeholder="Last name" value="<?php echo set_value('frmRegisterLastName'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterFunction" class="form-control" placeholder="Function" value="<?php echo set_value('frmRegisterFunction'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterWorkplace" class="form-control" placeholder="Workplace" value="<?php echo set_value('frmRegisterWorkplace'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterCountry" class="form-control" placeholder="Country" value="<?php echo set_value('frmRegisterCountry'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="number" name="frmRegisterPhone" class="form-control" placeholder="Phone" value="<?php echo set_value('frmRegisterPhone'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterSurgicalExperience" class="form-control" placeholder="Surgical Experience" value="<?php echo set_value('frmRegisterSurgicalExperience'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="email" name="frmRegisterEmail" class="form-control" placeholder="Email" value="<?php echo set_value('frmRegisterEmail'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="text" name="frmRegisterUsername" class="form-control" placeholder="Username" value="<?php echo set_value('frmRegisterUsername'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="password" name="frmRegisterPassword" class="form-control" placeholder="Password" value="<?php echo set_value('frmRegisterPassword'); ?>" >
                    </div>

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="password" name="frmRegisterConfirmPassword" class="form-control" placeholder="Confirm password" value="<?php echo set_value('frmRegisterConfirmPassword'); ?>" >
                    </div>

                    <br>

                    <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>

                    <div class="form-group">
                        <input name="frmRegisterSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Create account">
                    </div>

                </div>
                <?php echo form_close(); ?>

            </div>

        </fieldset>
    </div>
</div>