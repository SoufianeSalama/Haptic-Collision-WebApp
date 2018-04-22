<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    /*public function allPatients(){
        $iDocterId = 1;
        $this->load->model('Patient_Model');
        $aPatients = $this->Patient_Model->getMyPatients($iDocterId);
        header('Access-Control-Allow-Origin: *', false);
        echo json_encode($aPatients);
    }

    public function patientProfile($sPatientEad){
        $this->load->model('Patient_Model');
        $aPatient = $this->Patient_Model->getPatient($sPatientEad)->result();
        header('Access-Control-Allow-Origin: *', false);
        echo json_encode($aPatient);
    }*/
}
