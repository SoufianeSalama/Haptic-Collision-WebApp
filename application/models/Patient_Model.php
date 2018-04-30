<?php
/**
 * Created by PhpStorm.
 * User: Soufiane
 * Date: 23/03/2018
 * Time: 11:38
 */

class Patient_Model extends CI_Model
{
    public function getMyPatients($iDocter_id){
        // Get general patients info
        try{
            $sql = "SELECT * FROM patients WHERE docter_id = ? ";
            $aPatients = $this->db->query($sql, array($iDocter_id));
        }catch(SQLiteException $e){
            return false;
        }
        return $aPatients->result();
    }

    public function getPatient($sPatientsEAD){
        // Get general patient info + clinical measurments + radiograph analyze
        try{
            $sql = "SELECT * FROM patients 
                    LEFT JOIN clinical_measurements ON patients.ead = clinical_measurements.patient_ead 
                    LEFT JOIN radiograph_analyze ON patients.ead = radiograph_analyze.patient_ead 
                    WHERE patients.ead = ? ";
            $query = $this->db->query($sql, array($sPatientsEAD));
        }catch(SQLiteException $e){
            return array(false,$e);
        }
        return $query;
    }

    public function clinicalMeasurementsDataFormVal(){
        // Step 1
        $this->form_validation->set_rules('frmClinicalData_icw', 'Patient ICW', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_naw_outer', 'Patient NAW outer', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_naw_inner', 'Patient NAW inner', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_upper_lip_length_inc', 'Patient Upper lip length including lip red', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_upper_lip_length_exc', 'Patient Upper lip length excluding lip red', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_lip_to_incisor_rest', 'Patient Lip-to-incisor at rest', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_lip_to_incisor_smile', 'Patient Lip-to-incisor smile', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_crown_length_llsd', 'Patient Crown length llsd', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_overjet', 'Patient Overjet', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_overbite', 'Patient Overbite', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_freeway_space', 'Patient Freeway-space', 'trim|numeric');
        // Step 2
        $this->form_validation->set_rules('frmClinicalData_dental_ok', 'Patient Dental OK', 'trim');
        $this->form_validation->set_rules('frmClinicalData_skeletal_ok', 'Patient Skeletal OK', 'trim');
        $this->form_validation->set_rules('frmClinicalData_dental_bk', 'Patient Dental BK', 'trim');
        $this->form_validation->set_rules('frmClinicalData_skeletal_bk', 'Patient Skeletal BK', 'trim');
        $this->form_validation->set_rules('frmClinicalData_deviation_midline_chin', 'Patient Deviation midline chin', 'trim');
        $this->form_validation->set_rules('frmClinicalData_fullness_lips', 'Patient Fullness lips', 'trim');
        $this->form_validation->set_rules('frmClinicalData_interlabial_gap', 'Patient Interlabial gap', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_gummy_smile_front', 'Patient Gummy smile front', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_gummy_smile_posterieur', 'Patient Gummy smile posterieur', 'trim');
        $this->form_validation->set_rules('frmClinicalData_lip_incompetence', 'Patient Lip incompetence', 'trim');
        $this->form_validation->set_rules('frmClinicalData_curling_out_lower_lip', 'Patient Curling out lower lip', 'trim');
        // Step 3
        $this->form_validation->set_rules('frmClinicalData_lip_trap', 'Patient Liptrap', 'trim');
        $this->form_validation->set_rules('frmClinicalData_indentations_on_lower_lip', 'Patient Indentations on lower lip', 'trim');
        $this->form_validation->set_rules('frmClinicalData_indentations_in_palatum', 'Patient Indentations in palatum', 'trim');
        $this->form_validation->set_rules('frmClinicalData_buccal_corridor', 'Patient Buccal corridor', 'trim');
        $this->form_validation->set_rules('frmClinicalData_nose_decription', 'Patient Nose description', 'trim');
        $this->form_validation->set_rules('frmClinicalData_nasolabial_angle', 'Patient Nasolabial angle', 'trim');
        $this->form_validation->set_rules('frmClinicalData_oribtae', 'Patient Oribtae', 'trim');
        $this->form_validation->set_rules('frmClinicalData_zygomata', 'Patient Zygomata', 'trim');
        $this->form_validation->set_rules('frmClinicalData_pommette', 'Patient Pommette', 'trim');
        $this->form_validation->set_rules('frmClinicalData_paranasale_fossa', 'Patient Paranasal fossa', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_fold', 'Patient Chin fold', 'trim');
        // Step 4
        $this->form_validation->set_rules('frmClinicalData_mentalis_strain', 'Patient Mentalisstrain', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_height', 'Patient Chin height', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_chin_neck_distance', 'Patient Chin neck distance', 'trim|numeric');
        $this->form_validation->set_rules('frmClinicalData_chin_neck_transition', 'Patient Chin neck transition', 'trim');
        $this->form_validation->set_rules('frmClinicalData_transverse_relation', 'Patient Transverse relation', 'trim');
        $this->form_validation->set_rules('frmClinicalData_face_length_ratio', 'Patient Face length ratio', 'trim');
        $this->form_validation->set_rules('frmClinicalData_profile', 'Patient Profile', 'trim');

        // Step 6
        $this->form_validation->set_rules('frmClinicalData_notes', 'Patient Notes', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }
        else
        {
            require_once "./application/models/ClinicalMeasurements.php";

            $oClinicalMeasurements = new ClinicalMeasurements();

            $oClinicalMeasurements->s_ead = $this->input->post('frmClinicalData_ead');
            $oClinicalMeasurements->d_icw = $this->input->post('frmClinicalData_icw');
            $oClinicalMeasurements->d_naw_outer = $this->input->post('frmClinicalData_naw_outer');
            $oClinicalMeasurements->d_naw_inner = $this->input->post('frmClinicalData_naw_inner');
            $oClinicalMeasurements->d_upper_lip_length_inc = $this->input->post('frmClinicalData_upper_lip_length_inc');
            $oClinicalMeasurements->d_upper_lip_length_exc = $this->input->post('frmClinicalData_upper_lip_length_exc');
            $oClinicalMeasurements->d_lip_to_incisor_rest = $this->input->post('frmClinicalData_lip_to_incisor_rest');
            $oClinicalMeasurements->d_lip_to_incisor_smile = $this->input->post('frmClinicalData_lip_to_incisor_smile');
            $oClinicalMeasurements->d_crown_length_llsd = $this->input->post('frmClinicalData_crown_length_llsd');
            $oClinicalMeasurements->d_overjet = $this->input->post('frmClinicalData_overjet');
            $oClinicalMeasurements->d_overbite = $this->input->post('frmClinicalData_overbite');
            $oClinicalMeasurements->d_freeway_space = $this->input->post('frmClinicalData_freeway_space');

            $oClinicalMeasurements->d_dental_ok = $this->input->post('frmClinicalData_dental_ok');
            $oClinicalMeasurements->d_skeletal_ok = $this->input->post('frmClinicalData_skeletal_ok');
            $oClinicalMeasurements->d_dental_bk = $this->input->post('frmClinicalData_dental_bk');
            $oClinicalMeasurements->d_skeletal_bk = $this->input->post('frmClinicalData_skeletal_bk');
            $oClinicalMeasurements->d_deviation_midline_chin = $this->input->post('frmClinicalData_deviation_midline_chin');
            $oClinicalMeasurements->s_fullness_lips = $this->input->post('frmClinicalData_fullness_lips');
            $oClinicalMeasurements->d_interlabial_gap = $this->input->post('frmClinicalData_interlabial_gap');
            $oClinicalMeasurements->d_gummy_smile_front = $this->input->post('frmClinicalData_gummy_smile_front');
            $oClinicalMeasurements->b_gummy_smile_posterieur = $this->input->post('frmClinicalData_gummy_smile_posterieur');
            $oClinicalMeasurements->b_lip_incompetence = $this->input->post('frmClinicalData_lip_incompetence');
            $oClinicalMeasurements->b_curling_out_lower_lip = $this->input->post('frmClinicalData_curling_out_lower_lip');

            $oClinicalMeasurements->s_lip_trap = $this->input->post('frmClinicalData_lip_trap');
            $oClinicalMeasurements->b_indentations_on_lower_lip = $this->input->post('frmClinicalData_indentations_on_lower_lip');
            $oClinicalMeasurements->b_indentations_in_palatum = $this->input->post('frmClinicalData_indentations_in_palatum');
            $oClinicalMeasurements->b_buccal_corridor = $this->input->post('frmClinicalData_buccal_corridor');
            $oClinicalMeasurements->s_nose_decription = $this->input->post('frmClinicalData_nose_decription');
            $oClinicalMeasurements->s_nasolabial_angle = $this->input->post('frmClinicalData_nasolabial_angle');
            $oClinicalMeasurements->s_oribtae = $this->input->post('frmClinicalData_oribtae');
            $oClinicalMeasurements->s_zygomata = $this->input->post('frmClinicalData_zygomata');
            $oClinicalMeasurements->s_pommette = $this->input->post('frmClinicalData_pommette');
            $oClinicalMeasurements->b_paranasale_fossa = $this->input->post('frmClinicalData_paranasale_fossa');
            $oClinicalMeasurements->b_chin_fold = $this->input->post('frmClinicalData_chin_fold');

            $oClinicalMeasurements->b_mentalis_strain = $this->input->post('frmClinicalData_mentalis_strain');
            $oClinicalMeasurements->d_chin_height = $this->input->post('frmClinicalData_chin_height');
            $oClinicalMeasurements->d_chin_neck_distance = $this->input->post('frmClinicalData_chin_neck_distance');
            $oClinicalMeasurements->s_chin_neck_transition = $this->input->post('frmClinicalData_chin_neck_transition');
            $oClinicalMeasurements->s_transverse_ratio = $this->input->post('frmClinicalData_transverse_relation');
            $oClinicalMeasurements->s_face_length_ratio = $this->input->post('frmClinicalData_face_length_ratio');
            $oClinicalMeasurements->s_profile = $this->input->post('frmClinicalData_profile');

            /*$oClinicalMeasurements->d_maxilla_advancement = $this->input->post('frmClinicalData_maxilla_advancement');
            $oClinicalMeasurements->s_maxilla_pieces = $this->input->post('frmClinicalData_maxilla_pieces');
            $oClinicalMeasurements->s_maxilla_anterior = $this->input->post('frmClinicalData_maxilla_anterior');
            $oClinicalMeasurements->s_maxilla_posterior = $this->input->post('frmClinicalData_maxilla_posterior');
            $oClinicalMeasurements->s_maxilla_midline_rotation = $this->input->post('frmClinicalData_maxilla_midline_rotation');
            $oClinicalMeasurements->s_mandible_advancement_setback = $this->input->post('frmClinicalData_mandible_advancement_setback');
            $oClinicalMeasurements->d_chin_advancement = $this->input->post('frmClinicalData_chin_advancement');
            $oClinicalMeasurements->d_chin_intrusion_extrusion = $this->input->post('frmClinicalData_chin_intrusion_extrusion');*/

            $oClinicalMeasurements->s_notes = $this->input->post('frmClinicalData_notes');

            if ($this->addClinicalMeasData($oClinicalMeasurements)){
                return true;
            }
            else{
                return false;
            }
        }
    }

    private function addClinicalMeasData($oClinicalMeasurements){
        //Check if there's already data of this patient in database
        $sql = "SELECT * FROM clinical_measurements WHERE patient_ead = ?";
        try{
            $aResult = $this->db->query($sql, array($oClinicalMeasurements->s_ead));
            if ( isset($aResult->result()[0]) && !empty($aResult->result()) ){
                // Already data of this patient in database
                $sql = "UPDATE clinical_measurements SET
                  icw = ?,	naw_outer = ?,	naw_inner  = ?,	upper_lip_length_inc = ?,	upper_lip_length_exc = ?,	lip_to_incisor_rest = ?,	lip_to_incisor_smile = ?,	
                  crown_length_llsd  = ?,	overjet = ?,	overbite = ?,	freeway_space = ?,	dental_ok = ?,	skeletal_ok = ?,	dental_bk = ?,	skeletal_bk = ?,
                  deviation_midline_chin = ?,	fullness_lips = ?,	interlabial_gap = ?,	gummy_smile_front = ?,	gummy_smile_posterieur = ?,	lip_incompetence = ?,	
                  curling_out_lower_lip  = ?,	lip_trap = ?,	indentations_on_lower_lip = ?,	indentations_in_palatum = ?,	buccal_corridor = ?,
                  nose_decription = ?,	nasolabial_angle = ?,	oribtae = ?,	zygomata = ?,	pommette = ?,	paranasale_fossa = ?,	chin_fold = ?,	mentalis_strain = ?,
                  chin_height = ?,	chin_neck_distance = ?,	chin_neck_transition = ?,	transverse_ratio = ?,	face_length_ratio = ?, profile = ?,	notes = ? WHERE patient_ead = ? ";

                $this->db->query($sql, array(
                    $oClinicalMeasurements->d_icw, $oClinicalMeasurements->d_naw_outer, $oClinicalMeasurements->d_naw_inner, $oClinicalMeasurements->d_upper_lip_length_inc,$oClinicalMeasurements->d_upper_lip_length_exc,
                    $oClinicalMeasurements->d_lip_to_incisor_rest, $oClinicalMeasurements->d_lip_to_incisor_smile, $oClinicalMeasurements->d_crown_length_llsd, $oClinicalMeasurements->d_overjet, $oClinicalMeasurements->d_overbite,
                    $oClinicalMeasurements->d_freeway_space, $oClinicalMeasurements->d_dental_ok, $oClinicalMeasurements->d_skeletal_ok, $oClinicalMeasurements->d_dental_bk, $oClinicalMeasurements->d_skeletal_bk,
                    $oClinicalMeasurements->d_deviation_midline_chin, $oClinicalMeasurements->s_fullness_lips, $oClinicalMeasurements->d_interlabial_gap, $oClinicalMeasurements->d_gummy_smile_front,$oClinicalMeasurements->b_gummy_smile_posterieur,
                    $oClinicalMeasurements->b_lip_incompetence, $oClinicalMeasurements->b_curling_out_lower_lip, $oClinicalMeasurements->s_lip_trap, $oClinicalMeasurements->b_indentations_on_lower_lip,
                    $oClinicalMeasurements->b_indentations_in_palatum, $oClinicalMeasurements->b_buccal_corridor, $oClinicalMeasurements->s_nose_decription, $oClinicalMeasurements->s_nasolabial_angle,
                    $oClinicalMeasurements->s_oribtae, $oClinicalMeasurements->s_zygomata,  $oClinicalMeasurements->s_pommette, $oClinicalMeasurements->b_paranasale_fossa,  $oClinicalMeasurements->b_chin_fold,
                    $oClinicalMeasurements->b_mentalis_strain, $oClinicalMeasurements->d_chin_height, $oClinicalMeasurements->d_chin_neck_distance,  $oClinicalMeasurements->s_chin_neck_transition, $oClinicalMeasurements->s_transverse_ratio,
                    $oClinicalMeasurements->s_face_length_ratio, $oClinicalMeasurements->s_profile, $oClinicalMeasurements->s_notes, $oClinicalMeasurements->s_ead
                ));
            }
            else{
                // No data of this patient in database
                $sql = "Insert into clinical_measurements (
                  patient_ead,
                  icw ,naw_outer ,naw_inner  ,	upper_lip_length_inc ,	upper_lip_length_exc ,	lip_to_incisor_rest ,	lip_to_incisor_smile ,	
                  crown_length_llsd  ,	overjet ,	overbite ,	freeway_space ,	dental_ok,	skeletal_ok ,	dental_bk ,	skeletal_bk,
                  deviation_midline_chin ,	fullness_lips ,	interlabial_gap ,	gummy_smile_front,	gummy_smile_posterieur,	lip_incompetence ,	
                  curling_out_lower_lip  ,	lip_trap ,	indentations_on_lower_lip,	indentations_in_palatum ,	buccal_corridor ,
                  nose_decription ,	nasolabial_angle ,	oribtae ,	zygomata ,	pommette ,	paranasale_fossa,	chin_fold ,	mentalis_strain ,
                  chin_height ,	chin_neck_distance ,	chin_neck_transition ,	transverse_ratio ,	face_length_ratio , profile ,	notes) 
                   VALUES (
                   ?,
                   ?, ?, ? , ? , ? ,?, ? ,
                   ? ,? ,? , ?,  ?, ?, ? , ? , 
                   ? ,? ,?,  ?,  ?, ? ,
                   ?, ?, ? , ? , ?,
                   ? ,? ,? , ?,  ?, ?, ? , ? , 
                   ?, ?, ? , ? , ? ,?, ?                
                   )";

                $this->db->query($sql, array(
                    $oClinicalMeasurements->s_ead,
                    $oClinicalMeasurements->d_icw, $oClinicalMeasurements->d_naw_outer, $oClinicalMeasurements->d_naw_inner, $oClinicalMeasurements->d_upper_lip_length_inc,$oClinicalMeasurements->d_upper_lip_length_exc,
                    $oClinicalMeasurements->d_lip_to_incisor_rest, $oClinicalMeasurements->d_lip_to_incisor_smile, $oClinicalMeasurements->d_crown_length_llsd, $oClinicalMeasurements->d_overjet, $oClinicalMeasurements->d_overbite,
                    $oClinicalMeasurements->d_freeway_space, $oClinicalMeasurements->d_dental_ok, $oClinicalMeasurements->d_skeletal_ok, $oClinicalMeasurements->d_dental_bk, $oClinicalMeasurements->d_skeletal_bk,
                    $oClinicalMeasurements->d_deviation_midline_chin, $oClinicalMeasurements->s_fullness_lips, $oClinicalMeasurements->d_interlabial_gap, $oClinicalMeasurements->d_gummy_smile_front,$oClinicalMeasurements->b_gummy_smile_posterieur,
                    $oClinicalMeasurements->b_lip_incompetence, $oClinicalMeasurements->b_curling_out_lower_lip, $oClinicalMeasurements->s_lip_trap, $oClinicalMeasurements->b_indentations_on_lower_lip,
                    $oClinicalMeasurements->b_indentations_in_palatum, $oClinicalMeasurements->b_buccal_corridor, $oClinicalMeasurements->s_nose_decription, $oClinicalMeasurements->s_nasolabial_angle,
                    $oClinicalMeasurements->s_oribtae, $oClinicalMeasurements->s_zygomata,  $oClinicalMeasurements->s_pommette, $oClinicalMeasurements->b_paranasale_fossa,  $oClinicalMeasurements->b_chin_fold,
                    $oClinicalMeasurements->b_mentalis_strain, $oClinicalMeasurements->d_chin_height, $oClinicalMeasurements->d_chin_neck_distance,  $oClinicalMeasurements->s_chin_neck_transition, $oClinicalMeasurements->s_transverse_ratio,
                    $oClinicalMeasurements->s_face_length_ratio, $oClinicalMeasurements->s_profile, $oClinicalMeasurements->s_notes
                ));
            }
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }

    public function clinicalDecisionDataFormVal()
    {
        $this->form_validation->set_rules('frmClinicalData_maxilla_advancement', 'Patient Maxilla-advancement', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_pieces', 'Patient Maxilla pieces', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_anterior', 'Patient Maxilla anterior', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_posterior', 'Patient Maxilla posterior', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_midline_rotation', 'Patient Maxilla midline rotation', 'trim');
        $this->form_validation->set_rules('frmClinicalData_mandible_advancement_setback', 'Patient Mandible-advancement/setback', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_advancement', 'Patient Chin-advancement/setback', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_intrusion_extrusion', 'Patient Chin-intrusion/extrusion', 'trim');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            require_once "./application/models/ClinicalDecision.php";

            $oClinicalDecision = new ClinicalDecision();

            $oClinicalDecision->s_ead = $this->input->post('frmClinicalDecisionData_ead');

            $oClinicalDecision->d_maxilla_advancement = $this->input->post('frmClinicalData_maxilla_advancement');
            $oClinicalDecision->s_maxilla_pieces = $this->input->post('frmClinicalData_maxilla_pieces');
            $oClinicalDecision->s_maxilla_anterior = $this->input->post('frmClinicalData_maxilla_anterior');
            $oClinicalDecision->s_maxilla_posterior = $this->input->post('frmClinicalData_maxilla_posterior');
            $oClinicalDecision->s_maxilla_midline_rotation = $this->input->post('frmClinicalData_maxilla_midline_rotation');
            $oClinicalDecision->s_mandible_advancement_setback = $this->input->post('frmClinicalData_mandible_advancement_setback');
            $oClinicalDecision->d_chin_advancement = $this->input->post('frmClinicalData_chin_advancement');
            $oClinicalDecision->d_chin_intrusion_extrusion = $this->input->post('frmClinicalData_chin_intrusion_extrusion');

            if ($this->addClinicalDecisionData($oClinicalDecision)) {
                return true;
            } else {
                return false;
            }

        }
    }
    private function addClinicalDecisionData($oClinicalDecision){
        //Check if there's already data of this patient in database
        $sql = "SELECT * FROM clinical_measurements WHERE patient_ead = ?";
        try{
            $aResult = $this->db->query($sql, array($oClinicalDecision->s_ead));
            if ( isset($aResult->result()[0]) && !empty($aResult->result()) ){
                // Already data of this patient in database
                $sql = "UPDATE clinical_measurements SET
                  maxilla_advancement  = ?,
                  maxilla_pieces  = ?,
                  maxilla_anterior  = ?,
                  maxilla_posterior  = ?,
                  maxilla_midline_rotation  = ?,
                  mandible_advancement_setback  = ?,
                  chin_advancement  = ?,
                  chin_intrusion_extrusion  = ?,
                  
                  WHERE patient_ead = ? ";

                $this->db->query($sql, array(
                    $oClinicalDecision->d_maxilla_advancement,
                    $oClinicalDecision->s_maxilla_pieces ,
                    $oClinicalDecision->s_maxilla_anterior ,
                    $oClinicalDecision->s_maxilla_posterior ,
                    $oClinicalDecision->s_maxilla_midline_rotation ,
                    $oClinicalDecision->s_mandible_advancement_setback ,
                    $oClinicalDecision->d_chin_advancement,
                    $oClinicalDecision->d_chin_intrusion_extrusion,
                    $oClinicalDecision->s_ead
                ));
            }
            else{
                // No data of this patient in database
                $sql = "Insert into clinical_measurements (
                      patient_ead, maxilla_advancement, maxilla_pieces, maxilla_anterior, maxilla_posterior, maxilla_midline_rotation, mandible_advancement_setback, chin_advancement,chin_intrusion_extrusion
                  ) 
                   VALUES (
                   ?, ?, ? ,?, ?, ? , ? ,?, ?
                   )";

                $this->db->query($sql, array(
                    $oClinicalDecision->s_ead,
                    $oClinicalDecision->d_maxilla_advancement,
                    $oClinicalDecision->s_maxilla_pieces ,
                    $oClinicalDecision->s_maxilla_anterior ,
                    $oClinicalDecision->s_maxilla_posterior ,
                    $oClinicalDecision->s_maxilla_midline_rotation ,
                    $oClinicalDecision->s_mandible_advancement_setback ,
                    $oClinicalDecision->d_chin_advancement,
                    $oClinicalDecision->d_chin_intrusion_extrusion
                ));
            }
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }

    public function addRadiographAnalyzeData($oRadiographAnalyze){
        //Check if there is already data of this patient in database
        $sql = "SELECT * FROM radiograph_analyze WHERE patient_ead = ?";
        try{
            $aResult = $this->db->query($sql, array($oRadiographAnalyze->ead));
            if ( isset($aResult->result()[0]) && !empty($aResult->result()) ){
                // Already data of this patient in database
                $sql = "UPDATE radiograph_analyze SET
                  i1u_nf = ?,	i1i_mp = ?,	d_6u_nf  = ?,	d_6l_mp = ?,	ans_pns = ?,	n_ans = ?,	ans_gn = ?,	ar_go_1  = ?,	go_pog = ?,	ar_pt = ?,	pt_n = ?,	n_s = ?,	s_ar = ?,	ar_go_2 = ?,	go_me = ?,
                  overjet2 = ?,	overbite2 = ?,	go_me_n_s = ?,	s_go_n_me = ?,	ufh_lfh = ?,	ns_pog = ?,	gl_gl  = ?,	a_sn = ?,	ls1u_ls = ?,	li1l_li = ?,	b_sm = ?,
                  pog_pog = ?,	gl_sn = ?,	sn_me = ?,	sn_sto = ?,	sto_me = ?,	lll = ?,	interlab = ?,	cl = ?,	gl_sn_sn_me = ?,	sn_sto_sto_me = ?,	s_go = ?,	n_me = ?,	pns_n = ?,
                  n_a = ?,	n_b = ?,	n_pog = ?,	b_pogmp = ?,	d_1u_npog = ?,	d_1u_apog = ?,	d_1l_npog = ?,	ls_nspog = ?,	li_nspog = ?,	pog_gl_sn_sn12 = ?,
                  sn_perp_ls = ?,	sn_perp_li = ?,	snperp_pog = ?,	wits = ?,	max1_nf = ?,	max1_sn = ?, upper_occ_pl_tv = ?,	max1_upper_occ_pl = ?,	mand1_lower_occ_pl = ?,
                  mand1_mp = ?,	ii  = ?,	ar_go_me = ?,	sna = ?,	snb = ?,	anb = ?,	s_n_go_me = ?,	mp_hp = ?,	sp_p_t2me = ?,	s_n_pog = ?,	n_a_pog = ?,	gl_sn_pog = ?,	cotg_sn_ls = ?,	lct = ?
                  WHERE patient_ead = ? ";

                $this->db->query($sql, array(
                    $oRadiographAnalyze->i_i1u_nf ,  $oRadiographAnalyze->i_i1i_mp ,
                    $oRadiographAnalyze->d_6u_nf , $oRadiographAnalyze->d_6l_mp ,
                    $oRadiographAnalyze->d_ans_pns, $oRadiographAnalyze->d_n_ans ,
                    $oRadiographAnalyze->d_ans_gn,$oRadiographAnalyze->d_ar_go_1 ,
                    $oRadiographAnalyze->d_go_pog , $oRadiographAnalyze->d_ar_pt ,
                    $oRadiographAnalyze->d_pt_n , $oRadiographAnalyze->d_n_s ,
                    $oRadiographAnalyze->d_s_ar , $oRadiographAnalyze->d_ar_go_2,
                    $oRadiographAnalyze->d_go_me , $oRadiographAnalyze->d_overjet2 ,
                    $oRadiographAnalyze->d_overbite2,$oRadiographAnalyze->d_go_me_n_s ,
                    $oRadiographAnalyze->d_s_go_n_me ,$oRadiographAnalyze->d_ufh_lfh,
                    $oRadiographAnalyze->d_ns_pog,  $oRadiographAnalyze->d_gl_gl ,
                    $oRadiographAnalyze->d_a_sn , $oRadiographAnalyze->d_ls1u_ls ,
                    $oRadiographAnalyze->d_li1l_li,    $oRadiographAnalyze->d_b_sm ,
                    $oRadiographAnalyze->d_pog_pog ,  $oRadiographAnalyze->d_gl_sn ,
                    $oRadiographAnalyze->d_sn_me , $oRadiographAnalyze->d_sn_sto ,
                    $oRadiographAnalyze->d_sto_me,  $oRadiographAnalyze->d_lll ,
                    $oRadiographAnalyze->d_interlab , $oRadiographAnalyze->d_cl ,
                    $oRadiographAnalyze->d_gl_sn_sn_me ,  $oRadiographAnalyze->d_sn_sto_sto_me ,
                    $oRadiographAnalyze->d_s_go ,$oRadiographAnalyze->d_n_me ,
                    $oRadiographAnalyze->d_pns_n,   $oRadiographAnalyze->d_n_a ,
                    $oRadiographAnalyze->d_n_b ,     $oRadiographAnalyze->d_n_pog ,
                    $oRadiographAnalyze->d_b_pogmp ,   $oRadiographAnalyze->d_1u_npog ,
                    $oRadiographAnalyze->d_1u_apog ,  $oRadiographAnalyze->d_1l_npog ,
                    $oRadiographAnalyze->d_ls_nspog ,   $oRadiographAnalyze->d_li_nspog,
                    $oRadiographAnalyze->d_pog_gl_sn_sn12,   $oRadiographAnalyze->d_sn_perp_ls ,
                    $oRadiographAnalyze->d_sn_perp_li,   $oRadiographAnalyze->d_snperp_pog,
                    $oRadiographAnalyze->d_wits ,   $oRadiographAnalyze->d_max1_nf ,
                    $oRadiographAnalyze->d_max1_sn ,    $oRadiographAnalyze->d_upper_occ_pl_tv ,
                    $oRadiographAnalyze->d_max1_upper_occ_pl ,  $oRadiographAnalyze->d_mand1_lower_occ_pl,
                    $oRadiographAnalyze->d_mand1_mp,  $oRadiographAnalyze->d_ii ,
                    $oRadiographAnalyze->d_ar_go_me,     $oRadiographAnalyze->d_sna ,
                    $oRadiographAnalyze->d_snb ,    $oRadiographAnalyze->d_anb ,
                    $oRadiographAnalyze->d_s_n_go_me, $oRadiographAnalyze->d_mp_hp,
                    $oRadiographAnalyze->d_sp_p_t2me,   $oRadiographAnalyze->d_s_n_pog ,
                    $oRadiographAnalyze->d_n_a_pog ,$oRadiographAnalyze->d_gl_sn_pog,
                    $oRadiographAnalyze->d_cotg_sn_ls ,$oRadiographAnalyze->d_lct,
                    $oRadiographAnalyze->ead
                ));
            }
            else{
                // No data of this patient in database
                $sql = "Insert into radiograph_analyze (
                  patient_ead,i1u_nf,	i1i_mp,	d_6u_nf,	d_6l_mp,	ans_pns,	n_ans,	ans_gn,	ar_go_1,	go_pog,	ar_pt,	pt_n,	n_s,	s_ar,	ar_go_2,	go_me,
                  overjet2,	overbite2,	go_me_n_s,	s_go_n_me,	ufh_lfh,	ns_pog,	gl_gl,	a_sn,	ls1u_ls,	li1l_li,	b_sm,
                  pog_pog,	gl_sn,	sn_me,	sn_sto,	sto_me,	lll,	interlab,	cl,	gl_sn_sn_me,	sn_sto_sto_me,	s_go,	n_me,	pns_n,
                  n_a,	n_b,	n_pog,	b_pogmp,	d_1u_npog,	d_1u_apog,	d_1l_npog,	ls_nspog,	li_nspog,	pog_gl_sn_sn12,
                  sn_perp_ls,	sn_perp_li,	snperp_pog,	wits,	max1_nf,	max1_sn, upper_occ_pl_tv,	max1_upper_occ_pl,	mand1_lower_occ_pl,
                  mand1_mp,	ii,	ar_go_me,	sna,	snb,	anb,	s_n_go_me,	mp_hp,	sp_p_t2me,	s_n_pog,	n_a_pog,	gl_sn_pog,	cotg_sn_ls,	lct) 
                   VALUES (
                   ?, ?, ? , ? , ? ,?, ? , ? , ? ,?, ?, ?, ? , ? , ? ,?,
                   ? ,? ,? , ?,  ?, ?, ? , ? , ? ,?, ? , 
                   ? ,? ,?,  ?,  ?, ? ,? , ? , ?, ? ,? , ? ,?,
                   ?, ?, ? , ? , ? ,?, ? , ? , ?, ?,
                   ?, ?, ? , ? , ? ,?, ? , ? , ?,
                   ?, ?, ? , ? , ? ,?, ? , ? , ? ,? ,?, ?, ? ,?                  
                   )";

                $this->db->query($sql, array(
                    $oRadiographAnalyze->ead,
                    $oRadiographAnalyze->i_i1u_nf ,  $oRadiographAnalyze->i_i1i_mp ,
                    $oRadiographAnalyze->d_6u_nf , $oRadiographAnalyze->d_6l_mp ,
                    $oRadiographAnalyze->d_ans_pns, $oRadiographAnalyze->d_n_ans ,
                    $oRadiographAnalyze->d_ans_gn,$oRadiographAnalyze->d_ar_go_1 ,
                    $oRadiographAnalyze->d_go_pog , $oRadiographAnalyze->d_ar_pt ,
                    $oRadiographAnalyze->d_pt_n , $oRadiographAnalyze->d_n_s ,
                    $oRadiographAnalyze->d_s_ar , $oRadiographAnalyze->d_ar_go_2,
                    $oRadiographAnalyze->d_go_me , $oRadiographAnalyze->d_overjet2 ,
                    $oRadiographAnalyze->d_overbite2,$oRadiographAnalyze->d_go_me_n_s ,
                    $oRadiographAnalyze->d_s_go_n_me ,$oRadiographAnalyze->d_ufh_lfh,
                    $oRadiographAnalyze->d_ns_pog,  $oRadiographAnalyze->d_gl_gl ,
                    $oRadiographAnalyze->d_a_sn , $oRadiographAnalyze->d_ls1u_ls ,
                    $oRadiographAnalyze->d_li1l_li,    $oRadiographAnalyze->d_b_sm ,
                    $oRadiographAnalyze->d_pog_pog ,  $oRadiographAnalyze->d_gl_sn ,
                    $oRadiographAnalyze->d_sn_me , $oRadiographAnalyze->d_sn_sto ,
                    $oRadiographAnalyze->d_sto_me,  $oRadiographAnalyze->d_lll ,
                    $oRadiographAnalyze->d_interlab , $oRadiographAnalyze->d_cl ,
                    $oRadiographAnalyze->d_gl_sn_sn_me ,  $oRadiographAnalyze->d_sn_sto_sto_me ,
                    $oRadiographAnalyze->d_s_go ,$oRadiographAnalyze->d_n_me ,
                    $oRadiographAnalyze->d_pns_n,   $oRadiographAnalyze->d_n_a ,
                    $oRadiographAnalyze->d_n_b ,     $oRadiographAnalyze->d_n_pog ,
                    $oRadiographAnalyze->d_b_pogmp ,   $oRadiographAnalyze->d_1u_npog ,
                    $oRadiographAnalyze->d_1u_apog ,  $oRadiographAnalyze->d_1l_npog ,
                    $oRadiographAnalyze->d_ls_nspog ,   $oRadiographAnalyze->d_li_nspog,
                    $oRadiographAnalyze->d_pog_gl_sn_sn12,   $oRadiographAnalyze->d_sn_perp_ls ,
                    $oRadiographAnalyze->d_sn_perp_li,   $oRadiographAnalyze->d_snperp_pog,
                    $oRadiographAnalyze->d_wits ,   $oRadiographAnalyze->d_max1_nf ,
                    $oRadiographAnalyze->d_max1_sn ,    $oRadiographAnalyze->d_upper_occ_pl_tv ,
                    $oRadiographAnalyze->d_max1_upper_occ_pl ,  $oRadiographAnalyze->d_mand1_lower_occ_pl,
                    $oRadiographAnalyze->d_mand1_mp,  $oRadiographAnalyze->d_ii ,
                    $oRadiographAnalyze->d_ar_go_me,     $oRadiographAnalyze->d_sna ,
                    $oRadiographAnalyze->d_snb ,    $oRadiographAnalyze->d_anb ,
                    $oRadiographAnalyze->d_s_n_go_me, $oRadiographAnalyze->d_mp_hp,
                    $oRadiographAnalyze->d_sp_p_t2me,   $oRadiographAnalyze->d_s_n_pog ,
                    $oRadiographAnalyze->d_n_a_pog ,$oRadiographAnalyze->d_gl_sn_pog,
                    $oRadiographAnalyze->d_cotg_sn_ls ,$oRadiographAnalyze->d_lct
                ));
            }
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }

    /**
     * Update the patients row in DB with filename of the uploaded excel file
     * @param $sPatientEAD EAD of patient
     * @param $sFileName Filename of the uploaded Excel File
     */
    public function saveFileName($sPatientEAD, $sFileName){
        $sql = "UPDATE patients SET excel_filename = ? WHERE ead = ? ";
        $this->db->query($sql, array($sFileName,$sPatientEAD ));
    }

    public function getFileName($sPatientEAD){
        try{
            $sql = "SELECT excel_filename FROM patients WHERE ead = ?";
            $aResult = $this->db->query($sql, array($sPatientEAD));
            return $aResult->result()[0]->excel_filename;
        }
        catch (Exception $e){
            return false;
        }
    }

    public function newPatientCheckEad($sEad){
        $sql = "SELECT * FROM patients WHERE 'EAD' = ?";
        $aResult = $this->db->query($sql, array($sEad));
        if (!empty($aResult->results)){
            return false;
        }
        else{
            return true;
        }
    }

    public function newPatient($aPatient, $iDocter_id){
        try {
            $sql = "Insert into patients (ead, firstname, lastname, gender, birthdate, docter_id) VALUES (?, ?, ? , ? , ? ,?)";
            $this->db->query($sql, array($aPatient["ead"], $aPatient["firstname"], $aPatient["lastname"], $aPatient["birtdate"], $aPatient["gender"], $iDocter_id));
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }

    public function checkClinincalMeasRow($sPatientEAD){
        try{
            $sql = "SELECT patient_ead FROM clinical_measurements WHERE patient_ead = ? ";
            $aPatient = $this->db->query($sql, array($sPatientEAD));
        }catch(SQLiteException $e){
            return false;
        }
        if ($aPatient->result() !=null){
            return true;
        }
        else{
            return false;
        }
    }

    public function checkRadiographAnalyzeRow($sPatientEAD){
        try{
            $sql = "SELECT patient_ead FROM radiograph_analyze WHERE patient_ead = ? ";
            $aPatient = $this->db->query($sql, array($sPatientEAD));
        }catch(SQLiteException $e){
            return false;
        }
        if ($aPatient->result() !=null){
            return true;
        }
        else{
            return false;
        }
    }
    public function getResultAlgorithm($sPatientEAD){
        try{
            $sql = "SELECT 
                    maxilla_advancement,maxilla_pieces, maxilla_anterior, maxilla_posterior,
                    maxilla_midline_rotation, mandible_advancement_setback, chin_advancement, chin_intrusion_extrusion
                    FROM clinical_measurements WHERE patient_ead = ? ";
            $aPatient = $this->db->query($sql, array($sPatientEAD));
        }catch(SQLiteException $e){
            return false;
        }
        if ($aPatient->result() !=null){
            return $aPatient->result();
        }
        else{
            return false;
        }
    }
}