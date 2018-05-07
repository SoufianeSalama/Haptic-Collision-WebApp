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

    public function loginAuthenticationView($sUsername = null, $sPassword =null){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            require_once "./application/third_party/GoogleAuthenticator/GoogleAuthenticator.php";
            $this->load->model("User_Model");
            $oGoogleAuth = new GoogleAuthenticator();

            $aUser = $this->User_Model->loginUserCheck($sUsername, $sPassword);
            if (!($aUser == false)) {
                if (!empty($aUser->auth_secret) && isset($aUser->auth_secret)) {
                    $_SESSION["auth_secret"] = $aUser->auth_secret;
                } else {
                    $secret = $oGoogleAuth->createSecret();
                    $_SESSION["auth_secret"] = $secret;
                    $this->User_Model->updateSecret($sUsername, $secret);
                }
            }

            $QRcode = $oGoogleAuth->getQRCodeGoogleUrl('HapticCollision', $_SESSION["auth_secret"]);
            $aData["sGoogleAuthQRSrc"] = $QRcode;
            $aData["sPatientUsername"] = $sUsername;
            $aData["sPatientPassword"] = $sPassword;
            $sTemplateHome = $this->load->view('templates/welcome/login_twofactor_template', $aData, true);
            $this->showView($sTemplateHome, "Login Authentication");
        }

    }

    public function loginAuthenticationForm(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $this->form_validation->set_rules('frmLoginAuthenticationCode', 'Authentication Code', 'required|trim|callback_loginAuthentication');
            $this->form_validation->set_rules('frmLoginAuthenticationPatientUsername', '', 'required');
            $this->form_validation->set_rules('frmLoginAuthenticationPatientPassword', '', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->loginAuthenticationView();
            } else
            {
                $this->load->model("User_Model");
                $aUser = $this->User_Model->loginUserCheck(trim($this->input->post('frmLoginAuthenticationPatientUsername')), trim($this->input->post('frmLoginAuthenticationPatientPassword')));
                if (isset($aUser) && !empty($aUser) ){
                    $aLoggedInUser = array(
                        'username'  => $aUser->username,
                        'userid'    => $aUser->userid,
                        'firstname' => $aUser->firstname,
                        'lastname'  => $aUser->lastname,
                        'email'     => $aUser->email,
                        'userlevel' => $aUser->userlevel,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($aLoggedInUser);
                    header("Location: ./mypatients");
                }

                header("Location: ./");
            }
        }
    }

    public function loginAuthentication(){
        require_once "./application/third_party/GoogleAuthenticator/GoogleAuthenticator.php";

        $oGoogleAuth = new GoogleAuthenticator();

        $sAuthenticationCode = $this->input->post('frmLoginAuthenticationCode');
        $bResult = $oGoogleAuth->verifyCode($_SESSION["auth_secret"], $sAuthenticationCode, 2);
        return $bResult;
    }

    public function loginUserForm(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $this->form_validation->set_rules('frmLoginUsername', 'Username', 'required|trim');
            $this->form_validation->set_rules('frmLoginPassword', 'Password', 'required|trim|callback_user_check');

            if ($this->form_validation->run() == FALSE) {
                $this->loginView();
            } else
            {
                // Get userdata: name, userlevel
                /*$aUser = $this->User_Model->loginUserCheck(trim($this->input->post('frmLoginUsername')), trim($this->input->post('frmLoginPassword')));

                $aLoggedInUser = array(
                    'username' => $aUser->username,
                    'userid' => $aUser->userid,
                    'firstname' => $aUser->firstname,
                    'lastname' => $aUser->lastname,
                    'email' => $aUser->email,
                    'userlevel' => $aUser->userlevel,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($aLoggedInUser);*/

                //header("Location: ./mypatients");
                $this->loginAuthenticationView(trim($this->input->post('frmLoginUsername')), trim($this->input->post('frmLoginPassword')));
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
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secret = '6LdMqlQUAAAAAPjPPtQbpvXbxk8CV0ZhGjzcShJ2';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);

                if ($responseData->success) {
                    $this->form_validation->set_rules('frmRegisterFirstName', 'Firstname', 'required|trim|alpha');
                    $this->form_validation->set_rules('frmRegisterLastName', 'Lastname', 'required|trim|alpha');
                    $this->form_validation->set_rules('frmRegisterEmail', 'Email', 'required|trim|valid_email|callback_email_check');
                    $this->form_validation->set_rules('frmRegisterFunction', 'Function', 'required|trim|alpha');
                    $this->form_validation->set_rules('frmRegisterWorkplace', 'Workplace', 'required|trim|alpha_numeric_spaces');
                    $this->form_validation->set_rules('frmRegisterCountry', 'Country', 'required|trim|alpha');
                    $this->form_validation->set_rules('frmRegisterPhone', 'Phone', 'required|trim|numeric');
                    $this->form_validation->set_rules('frmRegisterSurgicalExperience', 'Surgical experience', 'required|trim');
                    $this->form_validation->set_rules('frmRegisterPassword', 'Password', 'required|trim|matches[frmRegisterConfirmPassword]|min_length[8]|max_length[25]|xss_clean|callback_is_password_strong');
                    $this->form_validation->set_rules('frmRegisterConfirmPassword', '¨Password confirmation', 'required|trim');

                    $this->form_validation->set_rules('frmRegisterUsername', 'Username', 'required|trim|callback_username_check');

                    $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

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
            else{
                $this->form_validation->set_message('required', 'Please check the Captcha');
                $this->registerView();
            }
        }

    }

    public function is_password_strong($password)
    {
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
            return TRUE;
        }
        $this->form_validation->set_message('is_password_strong', 'Password can only contain [a-z], [A-Z] or [0-9] and minimum 8 characters');
        return FALSE;
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
