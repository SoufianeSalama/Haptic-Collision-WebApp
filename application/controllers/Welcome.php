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
	
	public function passwordResetView(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $aData = array();
            $sTemplateHome = $this->load->view('templates/welcome/reset_template', $aData, true);
            $this->showView($sTemplateHome, "Reset password");
        }
    }
	
	public function passwordResetCompleteView(){
        if ($this->checkSession()){
            header( "Location: ./mypatients" );
        }else {
            $aData = array();
            $sTemplateHome = $this->load->view('templates/welcome/resetcomplete_template', $aData, true);
            $this->showView($sTemplateHome, "Reset password complete");
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
                    "approved" => 0,
					"token" => hash('md5', $this->input->post('frmRegisterEmail'))
                );
				
				$aMail = array();
				$sqlSelectMail = "SELECT email FROM docters WHERE userlevel = 1";
				$sResult = $this->db->query($sqlSelectMail);
				
				foreach ($sResult->result_array() as $uMail){
					$aMail = $uMail['email'];
					//echo $sMail['email'];
				}
				
                $this->load->model("User_Model");
				$this->load->library('email');
				
				$url = site_url() . 'welcome/approve/token/' . $aUserData["token"];

				$mailData = array('firstname' => $this->input->post('frmRegisterFirstName'),
								  'lastname' => $this->input->post('frmRegisterLastName'),
								  'email' => $this->input->post('frmRegisterEmail'),
								  'function' => $this->input->post('frmRegisterFunction'),
								  'workplace' => $this->input->post('frmRegisterWorkplace'),
								  'country' => $this->input->post('frmRegisterCountry'),
								  'phone' => $this->input->post('frmRegisterPhone'),
								  'surgical_experience' => $this->input->post('frmRegisterSurgicalExperience'),
								  'username' => $this->input->post('frmRegisterUsername'),
								  'url' => $url);

				$message = $this->load->view('mail/approval_mail', $mailData, true);

				$config['protocol']   = 'smtp';
				$config['smtp_host']  = 'uit.telenet.be';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype']   = 'html';
				$config['validation'] = TRUE;
				$this->email->initialize($config);
				$this->email->from('webappmail', 'Ortho Analyzer');
				$this->email->to($aMail);
				$this->email->subject('Account verification for ' . $this->input->post('frmRegisterEmail'));
				$this->email->message($message);
				$this->email->send();

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
	
	public function approve(){
    	$token = $this->uri->segment(4);
		$sResult = array();
		$sUsers = array();
		
		$sqlUpdate = "UPDATE docters SET approved = 1 WHERE token = ?";
        $aResult = $this->db->query($sqlUpdate, array($token));
		
		$sqlSelect = "SELECT * FROM docters WHERE token = ?";
		$sResult = $this->db->query($sqlSelect, array($token));
		$sUsers = $sResult->row();

		if (isset($sUsers))
		{
			$uMail = $sUsers->email;
			$uFirstname = $sUsers->firstname;
			$uLastname = $sUsers->lastname;
			$uUsername = $sUsers->username;
		}
		
		$this->load->library('email');

		$mailData = array('firstname' => $uFirstname,
						  'lastname' => $uLastname,
						  'email' => $uMail,
						  'username' => $uUsername);

		$message = $this->load->view('mail/approved_mail', $mailData, true);

		$config['protocol']   = 'smtp';
		$config['smtp_host']  = 'uit.telenet.be';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype']   = 'html';
		$config['validation'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('webappmail', 'Ortho Analyzer');
		$this->email->to($uMail);
		$this->email->subject('Your account for Ortho Analyzer has been approved');
		$this->email->message($message);
		$this->email->send();
		
		$aData = array();
        $sTemplateHome = $this->load->view('templates/welcome/approval_template', $aData, true);
        $this->showView($sTemplateHome, "Approve user");

    }
	
	public function forgotPassword(){
		$sResult = array();
		$sUsers = array();

		$sqlSelect = "SELECT * FROM docters WHERE email = ?";
		$sResult = $this->db->query($sqlSelect, array($this->input->post('frmPasswordEmail')));
		$sUsers = $sResult->row();

		if (isset($sUsers))
		{
			$uToken = $sUsers->token;
			$uFirstname = $sUsers->firstname;
			$uLastname = $sUsers->lastname;
		}

		$this->load->library('email');

		$url = site_url() . 'welcome/resetpassword/' . $uToken;
		
		$mailData = array('firstname' => $uFirstname,
						  'lastname' => $uLastname,
						  'url' => $url);

		$message = $this->load->view('mail/forgot_mail', $mailData, true);

		
		$config['protocol']   = 'smtp';
		$config['smtp_host']  = 'uit.telenet.be';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype']   = 'html';
		$config['validation'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('webappmail', 'Ortho Analyzer');
		$this->email->to($this->input->post('frmPasswordEmail'));
		$this->email->subject('Password forgot request for ' . $this->input->post('frmPasswordEmail'));
		$this->email->message($message);
		$this->email->send();
		
		$aData = array();
		$sTemplateHome = $this->load->view('templates/welcome/request_template', $aData, true);
		$this->showView($sTemplateHome, "Request password reset");

	}
	
	public function resetPassword(){
		echo $this->uri->segment(3);
		$this->form_validation->set_rules('frmResetPassword', 'New Password', 'required|trim');
		$this->form_validation->set_rules('frmResetPasswordConfirm', 'Confirm Password', 'required|trim|matches[frmResetPassword]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->passwordResetView();
		} else {
			$aResetData = array(
                    "password" => password_hash($this->input->post('frmResetPassword'), PASSWORD_DEFAULT),
					"token" => $this->input->post('token')
			);
			
            $this->load->model("User_Model");
			if ($this->User_Model->resetPassword($aResetData)) {
                    $this->passwordResetCompleteView();
                } else {
                    $this->passwordResetView();
                }
			
		}
    }
}
