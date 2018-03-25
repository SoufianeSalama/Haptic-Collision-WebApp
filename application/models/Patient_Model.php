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
}