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
            $aData["message"] = "error nr. 5";
            $this->load->view('errors/html/error_general', $aData);
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
        $this->load->model('Patient_Model');

        $aResult = uploadExcelData(); // ExcelData_Helper
        $sPatientEAD = $this->input->post('frmUploadDataEAD');

        if (!($aResult==false)){
            $sFilePath = $aResult["upload_data"]["full_path"];
            $sFileName = $aResult["upload_data"]["file_name"];

            $this->Patient_Model->saveFileName($sPatientEAD, $sFileName);

            $oRadiographAnalyze = parseExcelData($sFilePath); // ExcelData_Helper

            if (!($oRadiographAnalyze==false)){
                $oRadiographAnalyze->ead = $sPatientEAD;
                $bResult = $this->Patient_Model->addRadiographAnalyzeData($oRadiographAnalyze);
                if ($bResult){
                    $this->patientProfileView($sPatientEAD, true);
                }
                else{
                    // Error saving data
                    $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with saving the Radiograph Analyze data in DB!";
                    $aData["message"] = "error nr. 6";
                    $this->load->view('errors/html/error_general', $aData);
                }
            }else{
                // Error parsing data
                $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with parsing the Radiograph Analyze excel file!";
                $aData["message"] = "error nr. 7";
                $this->load->view('errors/html/error_general', $aData);
            }
        }
        else{
            // Error uploading data
            $aData["heading"] = "Haptic Collision Webapplication ERROR: Problem with uploading the Radiograph Analyze excel file!";
            $aData["message"] = "error nr. 8";
            $this->load->view('errors/html/error_general', $aData);
        }

    }
}
