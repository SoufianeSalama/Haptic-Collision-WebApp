<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	    $this->loginView();
	}

    private function showView($sTemplateContent, $sTemplateName){

        $aData["sTemplateContent"] = $sTemplateContent;
        $aData["sTemplateName"] = $sTemplateName;
        $this->load->view('welcome_masterview', $aData);
    }

    public function loginView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/welcome/login_template', $aData, true);
        $this->showView($sTemplateHome, "Login");
    }

    public function registerView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/welcome/register_template', $aData, true);
        $this->showView($sTemplateHome, "Register");
    }

    public function passwordForgotView(){
        $aData = array();
        $sTemplateHome = $this->load->view('templates/welcome/password_template', $aData, true);
        $this->showView($sTemplateHome, "Forgot password");
    }
}
