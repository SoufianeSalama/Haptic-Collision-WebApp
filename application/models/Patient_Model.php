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
            $query = $this->db->query($sql, array($iDocter_id));
        }catch(SQLiteException $e){
            return array(false,$e);
        }
        return $query;
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
        // Step 5
        $this->form_validation->set_rules('frmClinicalData_maxilla_advancement', 'Patient Maxilla-advancement', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_pieces', 'Patient Maxilla pieces', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_anterior', 'Patient Maxilla anterior', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_posterior', 'Patient Maxilla posterior', 'trim');
        $this->form_validation->set_rules('frmClinicalData_maxilla_midline_rotation', 'Patient Maxilla midline rotation', 'trim');
        $this->form_validation->set_rules('frmClinicalData_mandible_advancement_setback', 'Patient Mandible-advancement/setback', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_advancement', 'Patient Chin-advancement/setback', 'trim');
        $this->form_validation->set_rules('frmClinicalData_chin_intrusion_extrusion', 'Patient Chin-intrusion/extrusion', 'trim');

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

            $oClinicalMeasurements->d_maxilla_advancement = $this->input->post('frmClinicalData_maxilla_advancement');
            $oClinicalMeasurements->s_maxilla_pieces = $this->input->post('frmClinicalData_maxilla_pieces');
            $oClinicalMeasurements->s_maxilla_anterior = $this->input->post('frmClinicalData_maxilla_anterior');
            $oClinicalMeasurements->s_maxilla_posterior = $this->input->post('frmClinicalData_maxilla_posterior');
            $oClinicalMeasurements->s_maxilla_midline_rotation = $this->input->post('frmClinicalData_maxilla_midline_rotation');
            $oClinicalMeasurements->s_mandible_advancement_setback = $this->input->post('frmClinicalData_mandible_advancement_setback');
            $oClinicalMeasurements->d_chin_advancement = $this->input->post('frmClinicalData_chin_advancement');
            $oClinicalMeasurements->d_chin_intrusion_extrusion = $this->input->post('frmClinicalData_chin_intrusion_extrusion');

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
                  chin_height = ?,	chin_neck_distance = ?,	chin_neck_transition = ?,	transverse_ratio = ?,	face_length_ratio = ?, profile = ?,	maxilla_advancement = ?,
                  maxilla_pieces = ?,	maxilla_anterior = ?,	maxilla_posterior = ?,	maxilla_midline_rotation = ?, mandible_advancement_setback = ?,	chin_advancement = ?,	
                  chin_intrusion_extrusion = ?,	notes = ? WHERE patient_ead = ? ";

                $this->db->query($sql, array(
                    $oClinicalMeasurements->d_icw, $oClinicalMeasurements->d_naw_outer, $oClinicalMeasurements->d_naw_inner, $oClinicalMeasurements->d_upper_lip_length_inc,$oClinicalMeasurements->d_upper_lip_length_exc,
                    $oClinicalMeasurements->d_lip_to_incisor_rest, $oClinicalMeasurements->d_lip_to_incisor_smile, $oClinicalMeasurements->d_crown_length_llsd, $oClinicalMeasurements->d_overjet, $oClinicalMeasurements->d_overbite,
                    $oClinicalMeasurements->d_freeway_space, $oClinicalMeasurements->d_dental_ok, $oClinicalMeasurements->d_skeletal_ok, $oClinicalMeasurements->d_dental_bk, $oClinicalMeasurements->d_skeletal_bk,
                    $oClinicalMeasurements->d_deviation_midline_chin, $oClinicalMeasurements->s_fullness_lips, $oClinicalMeasurements->d_interlabial_gap, $oClinicalMeasurements->d_gummy_smile_front,$oClinicalMeasurements->b_gummy_smile_posterieur,
                    $oClinicalMeasurements->b_lip_incompetence, $oClinicalMeasurements->b_curling_out_lower_lip, $oClinicalMeasurements->s_lip_trap, $oClinicalMeasurements->b_indentations_on_lower_lip,
                    $oClinicalMeasurements->b_indentations_in_palatum, $oClinicalMeasurements->b_buccal_corridor, $oClinicalMeasurements->s_nose_decription, $oClinicalMeasurements->s_nasolabial_angle,
                    $oClinicalMeasurements->s_oribtae, $oClinicalMeasurements->s_zygomata,  $oClinicalMeasurements->s_pommette, $oClinicalMeasurements->b_paranasale_fossa,  $oClinicalMeasurements->b_chin_fold,
                    $oClinicalMeasurements->b_mentalis_strain, $oClinicalMeasurements->d_chin_height, $oClinicalMeasurements->d_chin_neck_distance,  $oClinicalMeasurements->s_chin_neck_transition, $oClinicalMeasurements->s_transverse_ratio,
                    $oClinicalMeasurements->s_face_length_ratio, $oClinicalMeasurements->s_profile,$oClinicalMeasurements->d_maxilla_advancement, $oClinicalMeasurements->s_maxilla_pieces, $oClinicalMeasurements->s_maxilla_anterior,
                    $oClinicalMeasurements->s_maxilla_posterior, $oClinicalMeasurements->s_maxilla_midline_rotation, $oClinicalMeasurements->s_mandible_advancement_setback,  $oClinicalMeasurements->d_chin_advancement,
                    $oClinicalMeasurements->d_chin_intrusion_extrusion, $oClinicalMeasurements->s_notes, $oClinicalMeasurements->s_ead
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
                  chin_height ,	chin_neck_distance ,	chin_neck_transition ,	transverse_ratio ,	face_length_ratio , profile ,	maxilla_advancement ,
                  maxilla_pieces,	maxilla_anterior ,	maxilla_posterior ,	maxilla_midline_rotation, mandible_advancement_setback ,	chin_advancement ,	
                  chin_intrusion_extrusion ,	notes) 
                   VALUES (
                   ?,
                   ?, ?, ? , ? , ? ,?, ? ,
                   ? ,? ,? , ?,  ?, ?, ? , ? , 
                   ? ,? ,?,  ?,  ?, ? ,
                   ?, ?, ? , ? , ?,
                   ? ,? ,? , ?,  ?, ?, ? , ? , 
                   ?, ?, ? , ? , ? ,?, ?,
                   ?, ?, ? , ? , ? ,?,
                    ? ,?                  
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
                    $oClinicalMeasurements->s_face_length_ratio, $oClinicalMeasurements->s_profile,$oClinicalMeasurements->d_maxilla_advancement, $oClinicalMeasurements->s_maxilla_pieces, $oClinicalMeasurements->s_maxilla_anterior,
                    $oClinicalMeasurements->s_maxilla_posterior, $oClinicalMeasurements->s_maxilla_midline_rotation, $oClinicalMeasurements->s_mandible_advancement_setback,  $oClinicalMeasurements->d_chin_advancement,
                    $oClinicalMeasurements->d_chin_intrusion_extrusion, $oClinicalMeasurements->s_notes
                ));
            }
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }
}