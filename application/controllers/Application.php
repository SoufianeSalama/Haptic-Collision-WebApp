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
            $aMyPatients = $this->Patient_Model->getMyPatients($iDocterId);
            $aData = array();
            $aData["aMyPatients"] = $aMyPatients;
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
                $aData["message"] = "Patient not found! <br/> ERROR NUMBER: 1";
                $this->load->view('errors/html/error_general', $aData);
            } else {
                $aData["aPatient"] = $aResult->result()[0];
                $sTemplateHome = $this->load->view('templates/application/patient_template', $aData, true);
                $this->showView($sTemplateHome, "Patient Profile");
            }
        }

    }

    public function userSettingsView($bSucces=null){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            if ($this->session->userdata('userlevel') == 2){
                $this->load->model('User_Model');
                $aResult = $this->User_Model->getAllUsers();

                $aData = array();
                $aData["bAlert"] = $bSucces;
                $aData["aUsers"] =$aResult->result();
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
                $aData["heading"] = "Haptic Collision Webapplication ERROR:";
                $aData["message"] = " Problem with modifying Clinical Measurements data! <br/> ERROR NUMBER: 5";
                $this->load->view('errors/html/error_general', $aData);
            }
        }
    }

    public function clinicalDecisionDataForm(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $this->load->model('Patient_Model');
            if ($this->Patient_Model->clinicalDecisionDataFormVal()) {
                $this->patientProfileView($this->input->post('frmClinicalDecisionData_ead'), true);
            } else {
                $aData["message"] = "Problem with modifying Clinical Decision data! <br/> ERROR NUMBER: 6";
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
                        $aData["message"] = "Problem with saving the Radiograph Analyze data in DB!  <br />ERROR NUMBER: 6";
                        $this->load->view('errors/html/error_general', $aData);
                    }
                } else {
                    // Error parsing data
                    $aData["message"] = "Problem with parsing the Radiograph Analyze excel file! <br />ERROR NUMBER: 7";
                    $this->load->view('errors/html/error_general', $aData);
                }
            } else {
                // Error uploading data
                $aData["message"] = "Problem with uploading the Radiograph Analyze excel file! <br/>ERROR NUMBER: 8";
                $this->load->view('errors/html/error_general', $aData);
            }
        }

    }

    public function downloadRadiographAnalyzedata(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $sPatientEAD = $this->input->post('frmDownloadDataEAD');

            $this->load->model('Patient_Model');
            $sFileName = $this->Patient_Model->getFileName($sPatientEAD);
            downloadExcelData($sFileName); // ExcelData_Helper
        }
    }

    public function newPatientForm(){
        if (!$this->checkSession()){
            header( "Location: ./" );
        }else {
            $iDocter_id = 1;

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
                    "birtdate" => $this->input->post('frmNewPatientBirthdate'),
                    "gender" => $this->input->post('frmNewPatientGender'),
                );
                $this->load->model('Patient_Model');
                if ($this->Patient_Model->newPatient($aPatient, $iDocter_id)) {
                    $this->myPatientsView(true);
                } else {
                    $aData["message"] = "Patient is not added!<br/> ERROR NUMBER: 15";
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

    public function modifyUserForm(){
        $aUser = array(
            "userid" => $this->input->post('frmModifyUserId'),
            "userlevel" => $this->input->post('frmModifyUserLevel'),
            "approved" => $this->input->post('frmModifyUserApproved')
        );
        //var_dump($aUser);
        $this->load->model('User_Model');
        if ($this->User_Model->modifyUser($aUser)){
            $this->userSettingsView(true);
        }else{
            $aData["message"] = "User is not modified! <br/> ERROR NUMBER: 25";
            $this->load->view('errors/html/error_general', $aData);
        }

    }

    public function deleteUserForm(){
        $sUserId = $this->input->post('frmDeleteUserId');
        $this->load->model('User_Model');
        if ($this->User_Model->deleteUser($sUserId)){
            $this->userSettingsView(true);
        }else{
            $aData["message"] = "User is not deleted! <br/> ERROR NUMBER: 26";
            $this->load->view('errors/html/error_general', $aData);
        }
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
