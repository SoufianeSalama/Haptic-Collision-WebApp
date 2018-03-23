<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
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
        $aData = array();
        $sTemplateHome = $this->load->view('templates/application/mypatients_template', $aData, true);
        $this->showView($sTemplateHome, "My Patients");
    }

    public function patientProfileView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/application/patient_template', $aData, true);
        $this->showView($sTemplateHome, "Patient Profile");
    }

    public function userSettingsView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/application/users_template', $aData, true);
        $this->showView($sTemplateHome, "Users Settings");
    }
}
