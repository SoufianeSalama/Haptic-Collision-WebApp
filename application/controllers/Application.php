<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	public function index()
	{
		$this->myPatientsView();
	}

	private function checkSession(){
	    return $this->session->userdata('logged_in');
    }

    private function showView($sTemplateContent, $sTemplateName){
        $aData["username"] = $this->session->userdata('lastname') .' '. $this->session->userdata('firstname');
        $aData["sTemplateContent"] = $sTemplateContent;
        $aData["sTemplateName"] = $sTemplateName;
        $this->load->view('application_masterview', $aData);
    }

    public function myPatientsView($bSucces=null){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else{
            $iDocterId = $this->session->userdata('userid');
            $this->load->model('Patient_Model');
            $aResult = $this->Patient_Model->getMyPatients($iDocterId);
            $aData = array();
            $aData["aMyPatients"] = $aResult->result();
            $aData["bAlert"] = $bSucces;
            $sTemplateHome = $this->load->view('templates/application/mypatients_template', $aData, true);
            $this->showView($sTemplateHome, "My Patients");
        }

    }

    public function patientProfileView($sPatientEAD, $bSucces = null){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $this->load->model('Patient_Model');
            $aResult = $this->Patient_Model->getPatient($sPatientEAD);

            $aData = array();
            $aData["bAlert"] = $bSucces;

            if (empty($aResult->result())) {
                //if ($aPatient == null){
                $aData["heading"] = "Haptic Collision Webapplication ERROR: Patient not found!";
                $aData["message"] = "";
                $this->load->view('errors/html/error_general', $aData);
            } else {
                $aData["aPatient"] = $aResult->result()[0];
                $sTemplateHome = $this->load->view('templates/application/patient_template', $aData, true);
                $this->showView($sTemplateHome, "Patient Profile");
            }
        }

    }

    public function userSettingsView(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            if ($this->session->userdata('userlevel')){
                $aData = array();
                $sTemplateHome = $this->load->view('templates/application/users_template', $aData, true);
                $this->showView($sTemplateHome, "Users Settings");
            }
            else{
                header( "Location: ./mypatients" );
            }

        }
    }

    public function clinicalMeasDataForm(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $this->load->model('Patient_Model');
            if ($this->Patient_Model->clinicalMeasurementsDataFormVal()) {
                $this->patientProfileView($this->input->post('frmClinicalData_ead'), true);
            } else {
                $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with modifying Clinical Measurements data!";
                $aData["message"] = "error nr. 5";
                $this->load->view('errors/html/error_general', $aData);
            }
        }
    }

    /**
     * 1. Uploading Radiograph Analyze data (excel file)
     * 2. Save file name in database (patient)
     * 3. Parse excel file (get RadiographAnalyze data)
     * 4a. Check if there is already data of this patient in database
     * 4b. UPDATE/INSERT data in database (radiograph_analyze)
     */
    public function radiographAnalyzeData()
    {
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $this->load->model('Patient_Model');

            $aResult = uploadExcelData(); // ExcelData_Helper
            $sPatientEAD = $this->input->post('frmUploadDataEAD');

            if (!($aResult == false)) {
                $sFilePath = $aResult["upload_data"]["full_path"];
                $sFileName = $aResult["upload_data"]["file_name"];

                $this->Patient_Model->saveFileName($sPatientEAD, $sFileName);

                $oRadiographAnalyze = parseExcelData($sFilePath); // ExcelData_Helper

                if (!($oRadiographAnalyze == false)) {
                    $oRadiographAnalyze->ead = $sPatientEAD;
                    $bResult = $this->Patient_Model->addRadiographAnalyzeData($oRadiographAnalyze);
                    if ($bResult) {
                        $this->patientProfileView($sPatientEAD, true);
                    } else {
                        // Error saving data
                        $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with saving the Radiograph Analyze data in DB!";
                        $aData["message"] = "error nr. 6";
                        $this->load->view('errors/html/error_general', $aData);
                    }
                } else {
                    // Error parsing data
                    $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with parsing the Radiograph Analyze excel file!";
                    $aData["message"] = "error nr. 7";
                    $this->load->view('errors/html/error_general', $aData);
                }
            } else {
                // Error uploading data
                $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with uploading the Radiograph Analyze excel file!";
                $aData["message"] = "error nr. 8";
                $this->load->view('errors/html/error_general', $aData);
            }
        }

    }

    public function newPatientForm(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $iDocter_id = $this->session->userdata('userid');
			
            $this->form_validation->set_rules('frmNewPatientEAD', 'Patient EAD', 'required|callback_patientead_check');

            $this->form_validation->set_rules('frmNewPatientFirstName', 'Patient Firstname', 'required',
                array('required' => 'You must provide a %s.')
            );
            $this->form_validation->set_rules('frmNewPatientLastName', 'Patient Lastname', 'required',
                array('required' => 'You must provide a %s.')
            );
            $this->form_validation->set_rules('frmNewPatientBirthdate', 'Patient Birthdate', 'required',
                array('required' => 'You must provide a %s.')
            );
            $this->form_validation->set_rules('frmNewPatientGender', 'Patient Gender', 'required',
                array('required' => 'You must provide a %s.')
            );

            if ($this->form_validation->run() == FALSE) {
                return false;
            } else {
                // Add new patient
                $aPatient = array(
                    "ead" => $this->input->post('frmNewPatientEAD'),
                    "firstname" => strtoupper($this->input->post('frmNewPatientFirstName')),
                    "lastname" => strtoupper($this->input->post('frmNewPatientLastName')),
                    "birthdate" => $this->input->post('frmNewPatientBirthdate'),
                    "gender" => $this->input->post('frmNewPatientGender'),
                );
                $this->load->model('Patient_Model');
                if ($this->Patient_Model->newPatient($aPatient, $iDocter_id)) {
                    $this->myPatientsView(true);
                } else {
                    $aData["heading"] = "Haptic Collision Webapplication ERROR: Patient is not added!";
                    $aData["message"] = "10";
                    $this->load->view('errors/html/error_general', $aData);
                }
                return true;
            }
        }
    }

    /**
     * Checks if there is already a patients with this EAD
     * @param $sEad EAD of patient
     * @return bool true/false
     */
    public function patientead_check($sEad){
        $this->load->model('Patient_Model');
        return $this->Patient_Model->newPatientCheckEad($sEad);
    }

    public function userLogout()
    {
        if (!$this->checkSession()) {
            header("Location: ./");
        } else {
            $aUserdata = array('username', 'userid', 'lastname', 'email', 'userlevel', 'logged_in');
            $this->session->unset_userdata($aUserdata);
            header("Location: ./");
        }
    }
}
