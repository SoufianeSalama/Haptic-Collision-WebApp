<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
	    $this->loginView();
	}

    private function checkSession(){
        return $this->session->userdata('logged_in');
    }

    private function showView($sTemplateContent, $sTemplateName){

        $aData["sTemplateContent"] = $sTemplateContent;
        $aData["sTemplateName"] = $sTemplateName;
        $this->load->view('welcome_masterview', $aData);
    }

    public function loginView($bSucces = null){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $aData = array();
            $aData["bAlert"] = $bSucces;
            $sTemplateHome = $this->load->view('templates/welcome/login_template', $aData, true);
            $this->showView($sTemplateHome, "Login");
        }
    }

    public function registerView(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $aData = array();
            $sTemplateHome = $this->load->view('templates/welcome/register_template', $aData, true);
            $this->showView($sTemplateHome, "Register");
        }
    }

    public function passwordForgotView(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $aData = array();
            $sTemplateHome = $this->load->view('templates/welcome/password_template', $aData, true);
            $this->showView($sTemplateHome, "Forgot password");
        }
    }

    public function loginUserForm(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $this->form_validation->set_rules('frmLoginUsername', 'Username', 'required|trim');
            $this->form_validation->set_rules('frmLoginPassword', 'Password', 'required|trim|callback_user_check');

            if ($this->form_validation->run() == FALSE) {
                $this->loginView();
            } else {
                // Get userdata: name, userlevel
                $aUser = $this->User_Model->loginUserCheck(trim($this->input->post('frmLoginUsername')), trim($this->input->post('frmLoginPassword')));
                var_dump($aUser);

                $aLoggedInUser = array(
                    'username' => $aUser->username,
                    'userid' => $aUser->userid,
                    'firstname' => $aUser->firstname,
                    'lastname' => $aUser->lastname,
                    'email' => $aUser->email,
                    'userlevel' => $aUser->userlevel,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($aLoggedInUser);
                header("Location: ./mypatients");
            }
        }
    }
    public function user_check(){
        $this->load->model("User_Model");
        $bResult = $this->User_Model->loginUserCheck(trim($this->input->post('frmLoginUsername')), trim($this->input->post('frmLoginPassword')));

        if (!$bResult){
            // Already user with this email in database
            $this->form_validation->set_message('user_check', 'Invalid username or password');
            return false;
        }
        else{
            if (!$bResult->approved){
                $this->form_validation->set_message('user_check', 'You are not approved, please contact adminstrator');
                return false;
            }
            return true;
        }
    }

    public function registerUserForm(){
        // CALLBACKS not working in models
        //$this->load->model("User_Model");
        //$this->User_Model->registerFormVal();
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $this->form_validation->set_rules('frmRegisterFirstName', 'Firstname', 'required|trim|alpha');
            $this->form_validation->set_rules('frmRegisterLastName', 'Lastname', 'required|trim|alpha');
            $this->form_validation->set_rules('frmRegisterEmail', 'Email', 'required|trim|valid_email|callback_email_check');
            $this->form_validation->set_rules('frmRegisterFunction', 'Function', 'required|trim|alpha');
            $this->form_validation->set_rules('frmRegisterWorkplace', 'Workplace', 'required|trim|alpha');
            $this->form_validation->set_rules('frmRegisterCountry', 'Country', 'required|trim|alpha');
            $this->form_validation->set_rules('frmRegisterPhone', 'Phone', 'required|trim|numeric');
            $this->form_validation->set_rules('frmRegisterSurgicalExperience', 'Surgical experience', 'required|trim');
            $this->form_validation->set_rules('frmRegisterPassword', 'Password', 'required|trim|matches[frmRegisterConfirmPassword]');
            $this->form_validation->set_rules('frmRegisterConfirmPassword', '¨Password confirmation', 'required|trim');

            $this->form_validation->set_rules('frmRegisterUsername', 'Username', 'required|trim|callback_username_check');

            if ($this->form_validation->run() == FALSE) {
                $this->registerView();
            } else {
                $aUserData = array(
                    "firstname" => strtoupper($this->input->post('frmRegisterFirstName')),
                    "lastname" => strtoupper($this->input->post('frmRegisterLastName')),
                    "email" => $this->input->post('frmRegisterEmail'),
                    "function" => strtoupper($this->input->post('frmRegisterFunction')),
                    "workplace" => strtoupper($this->input->post('frmRegisterWorkplace')),
                    "country" => strtoupper($this->input->post('frmRegisterCountry')),
                    "phone" => $this->input->post('frmRegisterPhone'),
                    "surgical_experience" => $this->input->post('frmRegisterSurgicalExperience'),
                    "username" => $this->input->post('frmRegisterUsername'),
                    "password" => password_hash($this->input->post('frmRegisterPassword'), PASSWORD_DEFAULT),
                    "userlevel" => 0,
                    "approved" => 0
                );
                $this->load->model("User_Model");

                if ($this->User_Model->registerNewUser($aUserData)) {
                    $this->loginView(true);
                } else {
                    $this->registerView();
                }
            }
        }
    }


    public function email_check($sEmail){
        $this->load->model("User_Model");
        $bResult = $this->User_Model->registerEmailCheck($sEmail);
        if (!$bResult){
            // Already user with this email in database
            $this->form_validation->set_message('email_check', '{field} error: Already used email');
            return false;
        }
        else{ return true;}

    }

    public function username_check($sUsername){
        $this->load->model("User_Model");
        $bResult=$this->User_Model->registerUsernameCheck($sUsername);

        if (!$bResult){
            // Already user with this email in database
            $this->form_validation->set_message('username_check', '{field} error: Already used username');
            return false;
        }
        else{ return true;}

    }
}
