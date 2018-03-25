<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	public function index()
	{
		$this->myPatientsView();
	}

    private function showView($sTemplateContent, $sTemplateName){
        $aData["username"] = "Soufiane Salama";

        $aData["sTemplateContent"] = $sTemplateContent;
        $aData["sTemplateName"] = $sTemplateName;
        $this->load->view('application_masterview', $aData);
    }

    public function myPatientsView(){
        $iDocterId = 1;
        $this->load->model('Patient_Model');
        $aResult = $this->Patient_Model->getMyPatients($iDocterId);
        $aData = array();
        $aData["aMyPatients"] = $aResult->result();

        $sTemplateHome = $this->load->view('templates/application/mypatients_template', $aData, true);
        $this->showView($sTemplateHome, "My Patients");
    }

    public function patientProfileView($sPatientEAD, $bSucces = null){
        $this->load->model('Patient_Model');
        $aResult = $this->Patient_Model->getPatient($sPatientEAD);

        $aData = array();
        $aData["bAlert"] = $bSucces;

        if (empty($aResult->result())){
        //if ($aPatient == null){
            $aData["heading"] = "Haptic Collision Webapplication ERROR: Patient not found!";
            $aData["message"] = "";
            $this->load->view('errors/html/error_general', $aData);
        }else{
            $aData["aPatient"] = $aResult->result()[0];
            $sTemplateHome = $this->load->view('templates/application/patient_template', $aData, true);
            $this->showView($sTemplateHome, "Patient Profile");
        }

    }

    public function userSettingsView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/application/users_template', $aData, true);
        $this->showView($sTemplateHome, "Users Settings");
    }

    public function clinicalMeasDataForm(){
        $this->load->model('Patient_Model');
        if ($this->Patient_Model->clinicalMeasurementsDataFormVal()){
            $this->patientProfileView($this->input->post('frmClinicalData_ead'), true);
        }
        else{
            $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with modifying Clinical Measurements data!";
            $aData["message"] = "";
            $this->load->view('errors/html/error_general', $aData);
        }

    }
}
