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
