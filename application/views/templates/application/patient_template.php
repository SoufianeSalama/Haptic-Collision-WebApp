<?php
if (isset($bAlert) && !empty($bAlert)){
    if ($bAlert){
        echo '<div class="row">
                <div class="col-md-12 alert alert-success alert-dismissable">
                    <strong>Success!</strong> Data is added/modified.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            </div>';
    }
}
?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-xs-6">
                    <h3 class="panel-title">Patient Info</h3>
                </div>
                <div class="col col-xs-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary btn-create btn-showform"  data-toggle="modal" data-target="#modalClinicalMeas">Clinical Measurements</button>
                    <button type="button" class="btn btn-sm btn-primary btn-create btn-showform"  data-toggle="modal" data-target="#modalExcelData">Radiograph Analyze(Excel)</button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-xs-8 col-sm-3 col-lg-2">
                    <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-circle img-responsive">
                </div>
                <div class="col-md-10 col-xs-12 col-sm-9 col-lg-8" >
                    <table>
                        <tr>
                            <td style="padding-right: 50px;">EAD:</td>
                            <td><?php echo $aPatient->ead; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 50px;">Firstname:</td>
                            <td><?php echo $aPatient->firstname; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 50px;">Lastname:</td>
                            <td><?php echo $aPatient->lastname; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 50px;">Gender:</td>
                            <td><?php echo $aPatient->gender; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 50px;">Age:</td>
                            <td><?php echo $aPatient->age; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 50px;">Notes:</td>
                            <td><?php echo $aPatient->notes; ?></td>
                        </tr>
                    </table>


                </div>
            </div>

            <div class="row">
                <div class="container">
                    <h4>Clinical Measurements:</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>ICW (mm):</td>
                                <td><?php echo $aPatient->icw; ?></td>

                                <td>NAW outer (mm):</td>
                                <td><?php echo $aPatient->naw_outer; ?></td>

                                <td>NAW inner (mm):</td>
                                <td><?php echo $aPatient->naw_inner; ?></td>

                                <td>Upper lip length including lip red (mm):</td>
                                <td><?php echo $aPatient->upper_lip_length_inc; ?></td>
                            </tr>

                            <tr>
                                <td>Upper lip length excluding lip red (mm):</td>
                                <td><?php echo $aPatient->upper_lip_length_exc; ?></td>

                                <td>Lip-to-incisor at rest (mm):</td>
                                <td><?php echo $aPatient->lip_to_incisor_rest; ?></td>

                                <td>Lip-to-incisor smile (mm):</td>
                                <td><?php echo $aPatient->lip_to_incisor_smile; ?></td>

                                <td>Crown length llsd (mm):</td>
                                <td><?php echo $aPatient->crown_length_llsd; ?></td>
                            </tr>

                            <tr>
                                <td>Overjet:</td>
                                <td><?php echo $aPatient->overjet; ?></td>

                                <td>Overbite:</td>
                                <td><?php echo $aPatient->overbite; ?></td>

                                <td>Freeway-space (mm):</td>
                                <td><?php echo $aPatient->freeway_space; ?></td>

                                <td>Dental OK (mm):</td>
                                <td><?php echo $aPatient->dental_ok; ?></td>
                            </tr>

                            <tr>
                                <td>Dental BK (mm):</td>
                                <td><?php echo $aPatient->dental_bk; ?></td>

                                <td>Skeletal OK (mm):</td>
                                <td><?php echo $aPatient->skeletal_ok; ?></td>

                                <td>Skeletal BK (mm):</td>
                                <td><?php echo $aPatient->skeletal_bk; ?></td>

                                <td>Deviation midline chin (mm):</td>
                                <td><?php echo $aPatient->deviation_midline_chin; ?></td>
                            </tr>

                            <tr>
                                <td>Fullness lips:</td>
                                <td><?php echo $aPatient->fullness_lips; ?></td>

                                <td>Interlabial gap (mm):</td>
                                <td><?php echo $aPatient->interlabial_gap ; ?></td>

                                <td>Gummy smile front (mm):</td>
                                <td><?php echo $aPatient->gummy_smile_front ; ?></td>

                                <td>Gummy smile posterieur:</td>
                                <td><?php echo $aPatient->gummy_smile_posterieur ; ?></td>
                            </tr>

                            <tr>
                                <td>Lip incompetence:</td>
                                <td><?php echo $aPatient->lip_incompetence ; ?></td>

                                <td>Curling out lower lip:</td>
                                <td><?php echo $aPatient->curling_out_lower_lip  ; ?></td>

                                <td>Liptrap:</td>
                                <td><?php echo $aPatient->lip_trap; ?></td>

                                <td>Indentations on lower lip:</td>
                                <td><?php echo $aPatient->indentations_on_lower_lip  ; ?></td>
                            </tr>

                            <tr>
                                <td>Indentations in palatum:</td>
                                <td><?php echo $aPatient->indentations_in_palatum; ?></td>

                                <td>Buccal corridor:</td>
                                <td><?php echo $aPatient->buccal_corridor  ; ?></td>

                                <td>Nose description:</td>
                                <td><?php echo $aPatient->nose_decription; ?></td>

                                <td>Nasolabial angle:</td>
                                <td><?php echo $aPatient->nasolabial_angle   ; ?></td>
                            </tr>
                            <tr>
                                <td>Oribtae:</td>
                                <td><?php echo $aPatient->oribtae ; ?></td>

                                <td>Zygomata:</td>
                                <td><?php echo $aPatient->zygomata   ; ?></td>

                                <td>Pommette:</td>
                                <td><?php echo $aPatient->pommette ; ?></td>

                                <td>Paranasal fossa:</td>
                                <td><?php echo $aPatient->paranasale_fossa    ; ?></td>
                            </tr>

                            <tr>
                                <td>Chin fold :</td>
                                <td><?php echo $aPatient->chin_fold  ; ?></td>

                                <td>Mentalisstrain:</td>
                                <td><?php echo $aPatient->mentalis_strain    ; ?></td>

                                <td>Chin height:</td>
                                <td><?php echo $aPatient->chin_height  ; ?></td>

                                <td>Chin neck distance:</td>
                                <td><?php echo $aPatient->chin_neck_distance     ; ?></td>
                            </tr>

                            <tr>
                                <td>Chin neck transition:</td>
                                <td><?php echo $aPatient->chin_neck_transition; ?></td>

                                <td>Transverse ratio:</td>
                                <td><?php echo $aPatient->transverse_ratio; ?></td>

                                <td>Face length ratio:</td>
                                <td><?php echo $aPatient->face_length_ratio; ?></td>

                                <td>Profile:</td>
                                <td><?php echo $aPatient->profile; ?></td>
                            </tr>

                            <tr>
                                <td>Maxilla-advancement:</td>
                                <td><?php echo $aPatient->maxilla_advancement ; ?></td>

                                <td>Maxilla pieces:</td>
                                <td><?php echo $aPatient->maxilla_pieces ; ?></td>

                                <td>Maxilla anterior:</td>
                                <td><?php echo $aPatient->maxilla_anterior ; ?></td>

                                <td>Maxilla posterior:</td>
                                <td><?php echo $aPatient->maxilla_posterior ; ?></td>
                            </tr>

                            <tr>
                                <td>Midline rotation:</td>
                                <td><?php echo $aPatient->maxilla_midline_rotation ; ?></td>

                                <td>Mandible-advancement/setback:</td>
                                <td><?php echo $aPatient->mandible_advancement_setback  ; ?></td>

                                <td>Chin-advancement/setback:</td>
                                <td><?php echo $aPatient->chin_advancement  ; ?></td>

                                <td>Chin-intrusion/extrusion:</td>
                                <td><?php echo $aPatient->chin_intrusion_extrusion  ; ?></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <hr>

                    <h4>Radiograph Analyze:</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>I1u-NF:</td>
                                <td><?php echo $aPatient->i1u_nf ; ?></td>

                                <td>I1l-MP:</td>
                                <td><?php echo $aPatient->i1i_mp ; ?></td>

                                <td>6u-NF:</td>
                                <td><?php echo "ERROR"/*$aPatient->6u_nf*/ ; ?></td>

                                <td>6l-MP:</td>
                                <td><?php echo "ERROR" /*$aPatient->6l_mp*/ ; ?></td>
                            </tr>

                            <tr>
                                <td>ANS-PNS:</td>
                                <td><?php echo $aPatient->ans_pns ; ?></td>

                                <td>N-ANS:</td>
                                <td><?php echo $aPatient->n_ans ; ?></td>

                                <td>ANS-Gn:</td>
                                <td><?php echo $aPatient->ans_gn ; ?></td>

                                <td>ar-Go:</td>
                                <td><?php echo $aPatient->ar_go_1 ; ?></td>
                            </tr>

                            <tr>
                                <td>Go-Pog:</td>
                                <td><?php echo $aPatient->go_pog ; ?></td>

                                <td>ar-Pt:</td>
                                <td><?php echo $aPatient->ar_pt ; ?></td>

                                <td>Pt-N:</td>
                                <td><?php echo $aPatient->pt_n ; ?></td>

                                <td>N-S:</td>
                                <td><?php echo $aPatient->n_s ; ?></td>
                            </tr>

                            <tr>
                                <td>S-ar:</td>
                                <td><?php echo $aPatient->s_ar ; ?></td>

                                <td>ar-Go.:</td>
                                <td><?php echo $aPatient->ar_go_2 ; ?></td>

                                <td>Go-Me:</td>
                                <td><?php echo $aPatient->go_me ; ?></td>

                                <td>Overjet:</td>
                                <td><?php echo "Difference?"/*$aPatient->overjet*/ ; ?></td>
                            </tr>

                            <tr>
                                <td>Overbite:</td>
                                <td><?php echo "Difference?"/*$aPatient->overbite*/ ; ?></td>

                                <td>Go-Me:N-S:</td>
                                <td><?php echo $aPatient->go_me_n_s  ; ?></td>

                                <td>S-Go:N-Me:</td>
                                <td><?php echo $aPatient->s_go_n_me  ; ?></td>

                                <td>UFH:LFH:</td>
                                <td><?php echo $aPatient->ufh_lfh  ; ?></td>


                            </tr>

                            <tr>
                                <td>Ns-Pog':</td>
                                <td><?php echo $aPatient->ns_pog ; ?></td>

                                <td>Gl-Gl':</td>
                                <td><?php echo $aPatient->gl_gl   ; ?></td>

                                <td>A-Sn:</td>
                                <td><?php echo $aPatient->a_sn ; ?></td>

                                <td>Ls1u-Ls:</td>
                                <td><?php echo $aPatient->ls1u_ls   ; ?></td>
                            </tr>

                            <tr>
                                <td>Li1l-Li:</td>
                                <td><?php echo $aPatient->li1l_li ; ?></td>

                                <td>B-Sm:</td>
                                <td><?php echo $aPatient->b_sm   ; ?></td>

                                <td>Pog-Pog':</td>
                                <td><?php echo $aPatient->pog_pog ; ?></td>

                                <td>Gl'-Sn:</td>
                                <td><?php echo $aPatient->gl_sn; ?></td>
                            </tr>
                            <tr>
                                <td>Sn-Me':</td>
                                <td><?php echo $aPatient->sn_me  ; ?></td>

                                <td>Sn-sto:</td>
                                <td><?php echo $aPatient->sn_sto    ; ?></td>

                                <td>sto-Me':</td>
                                <td><?php echo $aPatient->sto_me  ; ?></td>

                                <td>LLL:</td>
                                <td><?php echo $aPatient->lll     ; ?></td>
                            </tr>

                            <tr>
                                <td>Interlab:</td>
                                <td><?php echo $aPatient->interlab   ; ?></td>

                                <td>CL:</td>
                                <td><?php echo $aPatient->cl     ; ?></td>

                                <td>Gl'-Sn:Sn-Me':</td>
                                <td><?php echo $aPatient->gl_sn_sn_me   ; ?></td>

                                <td>Sn-sto:sto-Me':</td>
                                <td><?php echo $aPatient->sn_sto_sto_me      ; ?></td>
                            </tr>

                            <tr>
                                <td>S-Go:</td>
                                <td><?php echo $aPatient->s_go ; ?></td>

                                <td>N-Me:</td>
                                <td><?php echo $aPatient->n_me ; ?></td>

                                <td>PNS-N:</td>
                                <td><?php echo $aPatient->pns_n ; ?></td>

                                <td>N-A:</td>
                                <td><?php echo $aPatient->n_a ; ?></td>
                            </tr>

                            <tr>
                                <td>N-B:</td>
                                <td><?php echo $aPatient->n_b  ; ?></td>

                                <td>N-Pog:</td>
                                <td><?php echo $aPatient->n_pog  ; ?></td>

                                <td>B-PogMP:</td>
                                <td><?php echo $aPatient->b_pogmp  ; ?></td>

                                <td>1u-NPog:</td>
                                <td><?php echo "ERROR"/*$aPatient->1u_npog*/  ; ?></td>
                            </tr>

                            <tr>
                                <td>1u-APog:</td>
                                <td><?php echo "ERROR"/*$aPatient->1u_apog*/  ; ?></td>

                                <td>1l-NPog:</td>
                                <td><?php echo "ERROR"/*$aPatient->1l_npog*/   ; ?></td>

                                <td>Ls-NsPog':</td>
                                <td><?php echo $aPatient->ls_nspog   ; ?></td>

                                <td>Li-NsPog':</td>
                                <td><?php echo $aPatient->li_nspog   ; ?></td>
                            </tr>

                            <tr>
                                <td>Pog'-Gl'Sn/Sn12°:</td>
                                <td><?php echo "ERROR"/*$aPatient->1u_apog*/  ; ?></td>

                                <td>SnPerp-Ls:</td>
                                <td><?php echo "ERROR"/*$aPatient->1l_npog*/   ; ?></td>

                                <td>SnPerp-Li:</td>
                                <td><?php echo $aPatient->ls_nspog   ; ?></td>

                                <td>SnPerp-Pog':</td>
                                <td><?php echo $aPatient->li_nspog   ; ?></td>
                            </tr>

                            <tr>
                                <td>Wits:</td>
                                <td><?php echo $aPatient->wits   ; ?></td>

                                <td>Max1-NF:</td>
                                <td><?php echo $aPatient->max1_nf    ; ?></td>

                                <td>Max1-SN:</td>
                                <td><?php echo $aPatient->max1_sn    ; ?></td>

                                <td>Upper Occ. Pl.-T.V.:</td>
                                <td><?php echo $aPatient->upper_occ_pl_tv    ; ?></td>
                            </tr>

                            <tr>
                                <td>Max1-Upper Occ. Pl.:</td>
                                <td><?php echo $aPatient->max1_upper_occ_pl    ; ?></td>

                                <td>Mand1-Lower Occ. Pl.:</td>
                                <td><?php echo $aPatient->mand1_lower_occ_pl    ; ?></td>

                                <td>Mand1-MP:</td>
                                <td><?php echo $aPatient->mand1_mp     ; ?></td>

                                <td>II:</td>
                                <td><?php echo $aPatient->ii     ; ?></td>
                            </tr>


                            <tr>
                                <td>arGoMe:</td>
                                <td><?php echo $aPatient->ar_go_me    ; ?></td>

                                <td>SNA:</td>
                                <td><?php echo $aPatient->sna    ; ?></td>

                                <td>SNB:</td>
                                <td><?php echo $aPatient->snb    ; ?></td>

                                <td>ANB:</td>
                                <td><?php echo $aPatient->anb     ; ?></td>
                            </tr>


                            <tr>
                                <td>SNGoMe:</td>
                                <td><?php echo $aPatient->s_n_go_me    ; ?></td>

                                <td>MP-HP:</td>
                                <td><?php echo $aPatient->mp_hp     ; ?></td>

                                <td>SpP-T2Me:</td>
                                <td><?php echo $aPatient->sp_p_t2me   ?></td>

                                <td>SNPog:</td>
                                <td><?php echo $aPatient->s_n_pog      ; ?></td>
                            </tr>

                            <tr>
                                <td>N-A-Pog:</td>
                                <td><?php echo $aPatient->n_a_pog    ; ?></td>

                                <td>Gl'SnPog':</td>
                                <td><?php echo $aPatient->gl_sn_pog     ; ?></td>

                                <td>CotgSnLs:</td>
                                <td><?php echo $aPatient->cotg_sn_ls     ; ?></td>

                                <td>LCT:</td>
                                <td><?php echo $aPatient->lct     ; ?></td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <hr>

                    <h4>Results Algorithm:</h4>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modify/Add Clinical Measurements Data (WIZARD)-->
<div id="modalClinicalMeas" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Clinical Measurements</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('clinicalmeasdata'); ?>
                <input type="hidden" name="frmClinicalData_ead" class="form-control" value="<?php echo $aPatient->ead; ?>" >

                <div id="step1">
                    <h3 style="margin-top: 5px;">Step 1/6</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ICW (mm):</label>
                                <input type="number" name="frmClinicalData_icw" class="form-control" value="<?php echo $aPatient->icw; ?>" >
                            </div>
                            <div class="form-group">
                                <label>NAW outer (mm):</label>
                                <input type="number" name="frmClinicalData_naw_outer" class="form-control" value="<?php echo $aPatient->naw_outer ; ?>" >
                            </div>
                            <div class="form-group">
                                <label>NAW inner (mm):</label>
                                <input type="number" name="frmClinicalData_naw_inner" class="form-control" value="<?php echo $aPatient->naw_inner  ?>" >
                            </div>
                            <div class="form-group">
                                <label>Upper lip length including lip red (mm):</label>
                                <input type="number" name="frmClinicalData_upper_lip_length_inc" class="form-control" value="<?php echo $aPatient->upper_lip_length_inc ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Upper lip length excluding lip red (mm):</label>
                                <input type="number" name="frmClinicalData_upper_lip_length_exc" class="form-control" value="<?php echo $aPatient->upper_lip_length_exc; ?>">
                            </div>
                            <div class="form-group">
                                <label>Lip-to-incisor at rest (mm):</label>
                                <input type="number" name="frmClinicalData_lip_to_incisor_rest" class="form-control" value="<?php echo $aPatient->lip_to_incisor_rest ; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Lip-to-incisor smile (mm):</label>
                                <input type="text" name="frmClinicalData_lip_to_incisor_smile" class="form-control" value="<?php echo $aPatient->lip_to_incisor_smile ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Crown length llsd (mm):</label>
                                <input type="text" name="frmClinicalData_crown_length_llsd" class="form-control" value="<?php echo $aPatient->crown_length_llsd; ?>">
                            </div>
                            <div class="form-group">
                                <label>Overjet (mm):</label>
                                <input type="text" name="frmClinicalData_overjet" class="form-control" value="<?php echo $aPatient->overjet ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Overbite (mm):</label>
                                <input type="text" name="frmClinicalData_overbite" class="form-control" value="<?php echo $aPatient->overbite ; ?>" >
                            </div>
                            <div class="form-group">
                                <label>Freeway-space (mm):</label>
                                <input type="text" name="frmClinicalData_freeway_space" class="form-control" value="<?php echo $aPatient->freeway_space ; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <!--<input type="button" class="btn btn-lg btn-primary btn-block" value="Previous"  />-->
                        </div>
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Next" id="frmClinicalDataStep1Next" />
                        </div>
                    </div>
                </div>

                <div id="step2">
                    <h3 style="margin-top: 5px;">Step 2/6</h3>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Dental OK (mm):</label>
                                <input type="number" name="frmClinicalData_dental_ok" class="form-control" value="<?php echo $aPatient->dental_ok  ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Skeletal OK (mm):</label>
                                <input type="number" name="frmClinicalData_skeletal_ok" class="form-control" value="<?php echo $aPatient->skeletal_ok  ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Dental BK (mm):</label>
                                <input type="number" name="frmClinicalData_dental_bk" class="form-control" value="<?php echo $aPatient->dental_bk ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Skeletal BK (mm):</label>
                                <input type="number" name="frmClinicalData_skeletal_bk" class="form-control" value="<?php echo $aPatient->skeletal_bk  ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Deviation midline chin (mm):</label>
                                <input type="number" name="frmClinicalData_deviation_midline_chin" class="form-control" value="<?php echo $aPatient->deviation_midline_chin  ; ?>" >
                            </div>
                            <div class="form-group">
                                <label>Fullness lips (thin/normal/full):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_fullness_lips" value="thin">Thin</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_fullness_lips" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_fullness_lips" value="full">Full</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Interlabial gap  (mm):</label>
                                <input type="number" name="frmClinicalData_interlabial_gap" class="form-control"  value="<?php echo $aPatient->interlabial_gap   ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Gummy smile front (mm):</label>
                                <input type="number" name="frmClinicalData_gummy_smile_front" class="form-control" value="<?php echo $aPatient->gummy_smile_front   ; ?>">
                            </div>
                            <div class="form-group">
                                <label>Gummy smile posterieur (yes/no):</label>

                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_gummy_smile_posterieur" value="1" <?php if($aPatient->gummy_smile_posterieur =='1'){ echo "checked";}; ?>>Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_gummy_smile_posterieur" value="0" <?php if($aPatient->gummy_smile_posterieur =='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Lip incompetence (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_lip_incompetence" value="1" <?php if($aPatient->lip_incompetence  =='1'){ echo "checked";}; ?> >Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_lip_incompetence" value="0" <?php if($aPatient->lip_incompetence  =='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Curling out lower lip  (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_curling_out_lower_lip" value="1" <?php if($aPatient->curling_out_lower_lip   =='1'){ echo "checked";}; ?>>Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_curling_out_lower_lip" value="0" <?php if($aPatient->curling_out_lower_lip   =='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Previous" id="frmClinicalDataStep2Previous" />
                        </div>
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Next" id="frmClinicalDataStep2Next" />
                        </div>
                    </div>
                </div>

                <div id="step3">
                    <h3 style="margin-top: 5px;">Step 3/6</h3>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label >Liptrap (lying back/normal/reversed):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_lip_trap" value="lying_back" >Lying back</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_lip_trap" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_lip_trap" value="reversed">Reversed</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Indentations on lower lip (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_indentations_on_lower_lip" value="1" <?php if($aPatient->indentations_on_lower_lip=='1'){ echo "checked";}; ?> >Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_indentations_on_lower_lip" value="0" <?php if($aPatient->indentations_on_lower_lip=='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Indentations in palatum (deck bite) (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_indentations_in_palatum" value="1" <?php if($aPatient->indentations_in_palatum=='1'){ echo "checked";}; ?>>Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_indentations_in_palatum" value="0" <?php if($aPatient->indentations_in_palatum=='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Buccal corridor (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_buccal_corridor" value="1" <?php if($aPatient->buccal_corridor=='1'){ echo "checked";}; ?>>Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_buccal_corridor" value="0" <?php if($aPatient->buccal_corridor=='0'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Nose description (snub/straight/hump):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nose_decription" value="snub_nose" >Snub</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nose_decription" value="straight">Straight</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nose_decription" value="hump">Hump</label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label >Nasolabial angle (stub/sharp/straight):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nasolabial_angle" value="stub" >Stub</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nasolabial_angle" value="sharp">Sharp</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_nasolabial_angle" value="straight">Straight</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label >Oribtae (normal/lying back/..):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_oribtae" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_oribtae" value="lying_back">Lying back</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Zygomata (normal/lying back/..):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_zygomata" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_zygomata" value="lying_back">Lying back</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Pommette (red/not divergent/divergent):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_pommette" value="red">Red</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_pommette" value="not_divergent">Not divergent</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_pommette" value="divergent">Divergent</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Paranasal fossa (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_paranasale_fossa" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_paranasale_fossa" value="lying_back">Lying back</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_paranasale_fossa" value="flattened">Flattened</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Chin fold (normal/distinct/flattened):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_chin_fold" value="normal">Normal</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_chin_fold" value="distinct">Distinct</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_chin_fold" value="flattened">Flattened</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Previous" id="frmClinicalDataStep3Previous" />
                        </div>
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Next" id="frmClinicalDataStep3Next" />
                        </div>
                    </div>
                </div>

                <div id="step4">
                    <h3 style="margin-top: 5px;">Step 4/6</h3>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mentalisstrain (yes/no):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_mentalis_strain" value="1" <?php if($aPatient->mentalis_strain =='1'){ echo "checked";}; ?>>Yes</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_mentalis_strain" value="0" <?php if($aPatient->mentalis_strain =='0'){ echo "checked";}; ?> >No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chin height (mm):</label>
                                <input type="number" name="frmClinicalData_chin_height" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>Chin neck distance (mm):</label>
                                <input type="number" name="frmClinicalData_chin_neck_distance" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>Chin neck transition (straight/blunt):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_chin_neck_transition" value="straight">Straight</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_chin_neck_transition" value="blunt">Blunt</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Transverse ratio:</label>
                                <div class="radio">
                                    <input type="text" name="frmClinicalData_transverse_relation" class="form-control">
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Face length ratio(.../.../...):</label>
                                <input type="text" name="frmClinicalData_face_length_ratio" class="form-control" placeholder=".../.../..." >
                            </div>
                            <div class="form-group">
                                <label >Profile (straight/convex/cancave):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_profile" value="straight">Straight</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_profile" value="convex">Convex</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_profile" value="concave">Concave</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Previous" id="frmClinicalDataStep4Previous" />
                        </div>
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Next" id="frmClinicalDataStep4Next" />
                        </div>
                    </div>


                </div>

                <div id="step5">
                    <h3 style="margin-top: 5px;">Step 5/6</h3>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Maxilla-advancement (mm):</label>
                                <input type="number" name="frmClinicalData_maxilla_advancement" class="form-control" value="<?php echo $aPatient->maxilla_advancement  ; ?>" >
                            </div>
                            <div class="form-group">
                                <label>Pieces (1/3):</label>
                                <div class="radio">
                                   <label><input type="radio" name="frmClinicalData_maxilla_pieces" value="1">1 piece</label>
                                </div>
                                <div class="radio">
                                   <label><input type="radio" name="frmClinicalData_maxilla_pieces" value="2">2 pieces</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_pieces" value="3">3 pieces</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_pieces" value="no">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Anterior (intrusion/extrusion):</label>
                                <!--<div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_anterior" value="intrusion">Intrusion</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_anterior" value="extrusion">Extrusion</label>
                                </div>-->
                                <input type="text" name="frmClinicalData_maxilla_anterior" class="form-control" value="<?php echo $aPatient->maxilla_anterior  ; ?>" placeholder="extrusion 3 mm">
                            </div>
                            <div class="form-group">
                                <label>Posterior (intrusion/extrusion):</label>
                                <!--<div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_posterior" value="intrusion">Intrusion</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_maxilla_posterior" value="extrusion">Extrusion</label>
                                </div>-->
                                <input type="text" name="frmClinicalData_maxilla_posterior" class="form-control" value="<?php echo $aPatient->maxilla_posterior   ; ?>" placeholder="extrusion 3 mm">

                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Midline rotation (no/rotation to...):</label>
                                <input type="text" name="frmClinicalData_maxilla_midline_rotation" class="form-control" value="<?php echo $aPatient->maxilla_midline_rotation    ; ?>">
                            </div>

                            <div class="form-group">
                                <label>Mandible-advancement/setback (advancement/setback):</label>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_mandible_advancement_setback" value="advancement" <?php if($aPatient->gummy_smile_posterieur =='advancement'){ echo "checked";}; ?>>Advancement</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_mandible_advancement_setback" value="setback" <?php if($aPatient->gummy_smile_posterieur =='setback'){ echo "checked";}; ?>>Setback</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="frmClinicalData_mandible_advancement_setback" value="no" <?php if($aPatient->gummy_smile_posterieur =='no'){ echo "checked";}; ?>>No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chin-advancement/setback (mm):</label>
                                <input type="number" name="frmClinicalData_chin_advancement" class="form-control" value="<?php echo $aPatient->chin_advancement; ?>">
                            </div>
                            <div class="form-group">
                                <label>Chin-intrusion/extrusion:</label>
                                <input type="number" name="frmClinicalData_chin_intrusion_extrusion" class="form-control" value="<?php echo $aPatient->chin_intrusion_extrusion; ?>" placeholder="extrusion 3 mm">>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Previous" id="frmClinicalDataStep5Previous" />
                        </div>
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Next" id="frmClinicalDataStep5Next" />
                        </div>
                    </div>


                </div>

                <div id="step6">
                    <h3 style="margin-top: 5px;">Step 6/6</h3>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Notes:</label>
                                <textarea name="frmClinicalData_notes" class="form-control" style="resize:none;height:100px;"><?php echo $aPatient->notes; ?></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="button" class="btn btn-lg btn-primary btn-block" value="Previous" id="frmClinicalDataStep6Previous" />
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit" id="frmClinicalDataStep6Submit" />
                        </div>
                    </div>


                </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript for Clinical Measurements Data Modal (WIZARD)-->
<script>
    $(document).ready(function(){
        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#step6").hide();

        $("#frmClinicalDataStep1Next").click(function(){
            $("#step1").hide();
            $("#step2").show();
        });

        $("#frmClinicalDataStep2Previous").click(function(){
            $("#step1").show();
            $("#step2").hide();
        });

        $("#frmClinicalDataStep2Next").click(function(){
            $("#step2").hide();
            $("#step3").show();
        });

        $("#frmClinicalDataStep3Previous").click(function(){
            $("#step2").show();
            $("#step3").hide();
        });

        $("#frmClinicalDataStep3Next").click(function(){
            $("#step3").hide();
            $("#step4").show();
        });

        $("#frmClinicalDataStep4Previous").click(function(){
            $("#step3").show();
            $("#step4").hide();
        });

        $("#frmClinicalDataStep4Next").click(function(){
            $("#step4").hide();
            $("#step5").show();
        });

        $("#frmClinicalDataStep5Previous").click(function(){
            $("#step4").show();
            $("#step5").hide();
        });

        $("#frmClinicalDataStep5Next").click(function(){
            $("#step5").hide();
            $("#step6").show();
        });

        $("#frmClinicalDataStep6Previous").click(function(){
            $("#step6").hide();
            $("#step5").show();
        });

    });
</script>

<!-- Modal: Upload/Download Radiograph Analyze (excel) Data -->
<div id="modalExcelData" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Radiograph Analyze Data (excel)</h4>
            </div>
            <div class="modal-body">
                <h4>Upload Data</h4>
                <div class="row">
                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                        <?php
                        echo form_open_multipart('upload');?>
                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="hidden" name="frmUploadDataEAD" value="<?php echo $aPatient->ead; ?>">
                            <input type="file" name="frmUploadData" class="form-control" size="20">
                        </div>

                        <div class="form-group" style="width: 100%; margin-top: 15px;">
                            <input type="submit" name="frmUploadDataSubmit" class="btn btn-lg btn-primary btn-block" value="Upload">
                        </div>
                        </form>
                    </div>
                </div>
                <?php if (isset($aPatient->excel_filename) && !empty($aPatient->excel_filename)){
                    ?>
                    <hr/>
                    <h4>Download Data</h4>
                    <div class="row">
                        <div class="col-sm-12 col-md-10  col-md-offset-1">

                            <?php
                            echo form_open_multipart('download');?>

                            <div class="form-group" style="width: 100%; margin-top: 15px;">
                                <input type="hidden" name="frmDownloadDataEAD" class="btn btn-lg btn-primary btn-block" value="<?php echo $aPatient->ead; ?>">

                                <input type="submit" name="frmUploadDataSubmit" class="btn btn-lg btn-primary btn-block" value="Download">
                            </div>

                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
