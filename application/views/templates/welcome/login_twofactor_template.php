
<div class="panel panel-default" style="max-width: 450px; margin: auto;">
    <div class="panel-heading">
        Haptic Collision Webinterface
    </div>
    <div class="panel-body">

            <div class="row">
                <?php echo form_open('frmloginauthentication'); ?>

                <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <?php echo validation_errors('<div class="row"><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div></div>'); ?>
                    <h5>Use the "Google Authenticator" application to scan this QR code and fill your code in.</h5>
                    <div class="row" style="margin-bottom:25px; margin-top:15px;">
                        <div class="center-block" style="text-align: center;">
                            <img src="<?php echo $sGoogleAuthQRSrc; ?>" alt="two-factor QR" width="50%" height="20%"/>
                        </div>
                    </div>

                    <input type="hidden" name="frmLoginAuthenticationPatientUsername" value="
                    <?php
                        if (isset($sPatientUsername) && !empty($sPatientUsername)){
                            echo $sPatientUsername;
                        }
                        else{
                            echo set_value("frmLoginAuthenticationPatientUsername");
                        }
                    ?>">
                    <input type="hidden" name="frmLoginAuthenticationPatientPassword" value="
                    <?php
                        if (isset($sPatientPassword) && !empty($sPatientPassword)){
                            echo $sPatientPassword;
                        }
                        else{
                            echo set_value("frmLoginAuthenticationPatientPassword");
                        }
                    ?>">

                    <div class="form-group" style="width: 100%; margin-top: 15px;">
                        <input type="number" name="frmLoginAuthenticationCode" class="form-control" placeholder="CODE" value="<?php echo set_value('frmLoginAuthenticationCode'); ?>" required>
                    </div>

                    <div class="form-group">
                        <input name="frmLoginAuthenticationSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Log in">
                    </div>


                </div>
                <?php echo form_close(); ?>

            </div>

    </div>
</div>