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
                $this->load->model("User_Model");
				$this->load->library('email');
				
				$url = site_url() . 'welcome/approve/token/' . $aUserData["token"];
				
				$uFirstname = $this->input->post('frmRegisterFirstName');
				$uLastname = $this->input->post('frmRegisterLastName');
				$uEmail = $this->input->post('frmRegisterEmail');
				$uFunction = $this->input->post('frmRegisterFunction');
				$uWorkplace = $this->input->post('frmRegisterWorkplace');
				$uCountry = $this->input->post('frmRegisterCountry');
				$uPhone = $this->input->post('frmRegisterPhone');
				$uExperience = $this->input->post('frmRegisterSurgicalExperience');
				$uUsername = $this->input->post('frmRegisterUsername');
				
				$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
    <!--[if gte mso 9]><xml>
     <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-- -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">
	<!--<![endif]-->
    
    <style type="text/css" id="media-query">
      body {
  margin: 0;
  padding: 0; }

table, tr, td {
  vertical-align: top;
  border-collapse: collapse; }

.ie-browser table, .mso-container table {
  table-layout: fixed; }

* {
  line-height: inherit; }

a[x-apple-data-detectors=true] {
  color: inherit !important;
  text-decoration: none !important; }

[owa] .img-container div, [owa] .img-container button {
  display: block !important; }

[owa] .fullwidth button {
  width: 100% !important; }

[owa] .block-grid .col {
  display: table-cell;
  float: none !important;
  vertical-align: top; }

.ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
  width: 650px !important; }

.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%; }

.ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
  width: 216px !important; }

.ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
  width: 432px !important; }

.ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
  width: 325px !important; }

.ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
  width: 216px !important; }

.ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
  width: 162px !important; }

.ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
  width: 130px !important; }

.ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
  width: 108px !important; }

.ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
  width: 92px !important; }

.ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
  width: 81px !important; }

.ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
  width: 72px !important; }

.ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
  width: 65px !important; }

.ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
  width: 59px !important; }

.ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
  width: 54px !important; }

@media only screen and (min-width: 670px) {
  .block-grid {
    width: 650px !important; }
  .block-grid .col {
    vertical-align: top; }
    .block-grid .col.num12 {
      width: 650px !important; }
  .block-grid.mixed-two-up .col.num4 {
    width: 216px !important; }
  .block-grid.mixed-two-up .col.num8 {
    width: 432px !important; }
  .block-grid.two-up .col {
    width: 325px !important; }
  .block-grid.three-up .col {
    width: 216px !important; }
  .block-grid.four-up .col {
    width: 162px !important; }
  .block-grid.five-up .col {
    width: 130px !important; }
  .block-grid.six-up .col {
    width: 108px !important; }
  .block-grid.seven-up .col {
    width: 92px !important; }
  .block-grid.eight-up .col {
    width: 81px !important; }
  .block-grid.nine-up .col {
    width: 72px !important; }
  .block-grid.ten-up .col {
    width: 65px !important; }
  .block-grid.eleven-up .col {
    width: 59px !important; }
  .block-grid.twelve-up .col {
    width: 54px !important; } }

@media (max-width: 670px) {
  .block-grid, .col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important; }
  .block-grid {
    width: calc(100% - 40px) !important; }
  .col {
    width: 100% !important; }
    .col > div {
      margin: 0 auto; }
  img.fullwidth, img.fullwidthOnMobile {
    max-width: 100% !important; }
  .no-stack .col {
    min-width: 0 !important;
    display: table-cell !important; }
  .no-stack.two-up .col {
    width: 50% !important; }
  .no-stack.mixed-two-up .col.num4 {
    width: 33% !important; }
  .no-stack.mixed-two-up .col.num8 {
    width: 66% !important; }
  .no-stack.three-up .col.num4 {
    width: 33% !important; }
  .no-stack.four-up .col.num3 {
    width: 25% !important; }
  .mobile_hide {
    min-height: 0px;
    max-height: 0px;
    max-width: 0px;
    display: none;
    overflow: hidden;
    font-size: 0px; } }

    </style>
</head>
<body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #F5F5F5">
  <style type="text/css" id="media-query-bodytag">
    @media (max-width: 520px) {
      .block-grid {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

      .col {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

        .col > div {
          margin: 0 auto;
        }

      img.fullwidth {
        max-width: 100%!important;
      }
			img.fullwidthOnMobile {
        max-width: 100%!important;
      }
      .no-stack .col {
				min-width: 0!important;
				display: table-cell!important;
			}
			.no-stack.two-up .col {
				width: 50%!important;
			}
			.no-stack.mixed-two-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.mixed-two-up .col.num8 {
				width: 66%!important;
			}
			.no-stack.three-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.four-up .col.num3 {
				width: 25%!important;
			}
      .mobile_hide {
        min-height: 0px!important;
        max-height: 0px!important;
        max-width: 0px!important;
        display: none!important;
        overflow: hidden!important;
        font-size: 0px!important;
      }
    }
  </style>
  <!--[if IE]><div class="ie-browser"><![endif]-->
  <!--[if mso]><div class="mso-container"><![endif]-->
  <table class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #F5F5F5;width: 100%" cellpadding="0" cellspacing="0">
	<tbody>
	<tr style="vertical-align: top">
		<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #F5F5F5;"><![endif]-->

    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
<div style="line-height:30px;font-size:1px">&#160;</div>  <img class="center fixedwidth" align="center" border="0" src="https://www.uzleuven.be/sites/default/files/Centraal/Over_ons/Logos/logo_uzleuven_kleur_groot.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 325px" width="325">
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  <br>
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:14px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 28px; line-height: 33px;">New user account registered</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  <br>
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Dear admin</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">'.$uFirstname.' '.$uLastname.' ('.$uEmail.') has signed up with Ortho Analyzer.</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">This is the user information</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">First name: '.$uFirstname.'<br> Last name: '.$uLastname.'<br> E-mail: '.$uEmail.'<br> Function: '.$uFunction.'<br> Workplace: '.$uWorkplace.'<br> Country: '.$uCountry.'<br> Phone: '.$uPhone.'<br> Surgical Experience: '.$uExperience.'<br> Username: '.$uUsername.'</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Please click the button below to approve this account.</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    
<div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$url.'" style="height:40pt; v-text-anchor:middle; width:188pt;" arcsize="8%" strokecolor="#7ac4d5" fillcolor="#7ac4d5"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif; font-size:22px;"><![endif]-->
    <a href="'.$url.'" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #7ac4d5; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; max-width: 251px; width: 211px;width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: "Ubuntu", Tahoma, Verdana, Segoe, sans-serif;mso-border-alt: none">
      <span style="line-height:24px;font-size:12px;"><span style="font-size: 22px; line-height: 44px;" data-mce-style="font-size: 22px; line-height: 44px;">APPROVE ACCOUNT</span></span>
    </a>
  <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>

                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<span style="font-size: 18px; line-height: 32px;">Kind regards</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Orhto Analyzer</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 20px;padding-bottom: 30px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #D6D6D6;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:22px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 16px;line-height: 29px;text-align: center"><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;">QUESTIONS ABOUT THIS EMAIL?</span><br><span style="font-size: 16px; line-height: 28px;">We’re always here to help </span><br><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;"><a style="color:#7ac4d5;text-decoration: underline; color: rgb(122, 196, 213);" href="mailto:" target="_blank" rel="noopener noreferrer">hapticcollision.uzleuven@gmail.com</a></span><br></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #7ac4d5;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#7ac4d5;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#7ac4d5;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#FFFFFF; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;color:#FFFFFF;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 12px; line-height: 14px;"><span style="font-size: 12px; line-height: 14px;" id="_mce_caret" data-mce-bogus="1"><span style="background-color: rgb(122, 196, 213); font-size: 12px; line-height: 14px;"></span></span>UZ Leuven - <em>This email was automatically generated, you cannot reply on this email</em></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
		</td>
  </tr>
  </tbody>
  </table>
  <!--[if (mso)|(IE)]></div><![endif]-->


</body></html>';
				
				$config['protocol']   = 'smtp';
				$config['smtp_host']  = 'uit.telenet.be';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype']   = 'html';
				$config['validation'] = TRUE;
				$this->email->initialize($config);
				$this->email->from('webapplicationmail', 'name web application');
				$this->email->to('adminmail');
				$this->email->subject('Account verification for ' . $this->input->post('frmRegisterEmail'));
				$this->email->message($message);
				$this->email->send();
				
				//echo $this->email->print_debugger();

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

		$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
    <!--[if gte mso 9]><xml>
     <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-- -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">
	<!--<![endif]-->
    
    <style type="text/css" id="media-query">
      body {
  margin: 0;
  padding: 0; }

table, tr, td {
  vertical-align: top;
  border-collapse: collapse; }

.ie-browser table, .mso-container table {
  table-layout: fixed; }

* {
  line-height: inherit; }

a[x-apple-data-detectors=true] {
  color: inherit !important;
  text-decoration: none !important; }

[owa] .img-container div, [owa] .img-container button {
  display: block !important; }

[owa] .fullwidth button {
  width: 100% !important; }

[owa] .block-grid .col {
  display: table-cell;
  float: none !important;
  vertical-align: top; }

.ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
  width: 650px !important; }

.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%; }

.ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
  width: 216px !important; }

.ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
  width: 432px !important; }

.ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
  width: 325px !important; }

.ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
  width: 216px !important; }

.ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
  width: 162px !important; }

.ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
  width: 130px !important; }

.ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
  width: 108px !important; }

.ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
  width: 92px !important; }

.ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
  width: 81px !important; }

.ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
  width: 72px !important; }

.ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
  width: 65px !important; }

.ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
  width: 59px !important; }

.ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
  width: 54px !important; }

@media only screen and (min-width: 670px) {
  .block-grid {
    width: 650px !important; }
  .block-grid .col {
    vertical-align: top; }
    .block-grid .col.num12 {
      width: 650px !important; }
  .block-grid.mixed-two-up .col.num4 {
    width: 216px !important; }
  .block-grid.mixed-two-up .col.num8 {
    width: 432px !important; }
  .block-grid.two-up .col {
    width: 325px !important; }
  .block-grid.three-up .col {
    width: 216px !important; }
  .block-grid.four-up .col {
    width: 162px !important; }
  .block-grid.five-up .col {
    width: 130px !important; }
  .block-grid.six-up .col {
    width: 108px !important; }
  .block-grid.seven-up .col {
    width: 92px !important; }
  .block-grid.eight-up .col {
    width: 81px !important; }
  .block-grid.nine-up .col {
    width: 72px !important; }
  .block-grid.ten-up .col {
    width: 65px !important; }
  .block-grid.eleven-up .col {
    width: 59px !important; }
  .block-grid.twelve-up .col {
    width: 54px !important; } }

@media (max-width: 670px) {
  .block-grid, .col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important; }
  .block-grid {
    width: calc(100% - 40px) !important; }
  .col {
    width: 100% !important; }
    .col > div {
      margin: 0 auto; }
  img.fullwidth, img.fullwidthOnMobile {
    max-width: 100% !important; }
  .no-stack .col {
    min-width: 0 !important;
    display: table-cell !important; }
  .no-stack.two-up .col {
    width: 50% !important; }
  .no-stack.mixed-two-up .col.num4 {
    width: 33% !important; }
  .no-stack.mixed-two-up .col.num8 {
    width: 66% !important; }
  .no-stack.three-up .col.num4 {
    width: 33% !important; }
  .no-stack.four-up .col.num3 {
    width: 25% !important; }
  .mobile_hide {
    min-height: 0px;
    max-height: 0px;
    max-width: 0px;
    display: none;
    overflow: hidden;
    font-size: 0px; } }

    </style>
</head>
<body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #F5F5F5">
  <style type="text/css" id="media-query-bodytag">
    @media (max-width: 520px) {
      .block-grid {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

      .col {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

        .col > div {
          margin: 0 auto;
        }

      img.fullwidth {
        max-width: 100%!important;
      }
			img.fullwidthOnMobile {
        max-width: 100%!important;
      }
      .no-stack .col {
				min-width: 0!important;
				display: table-cell!important;
			}
			.no-stack.two-up .col {
				width: 50%!important;
			}
			.no-stack.mixed-two-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.mixed-two-up .col.num8 {
				width: 66%!important;
			}
			.no-stack.three-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.four-up .col.num3 {
				width: 25%!important;
			}
      .mobile_hide {
        min-height: 0px!important;
        max-height: 0px!important;
        max-width: 0px!important;
        display: none!important;
        overflow: hidden!important;
        font-size: 0px!important;
      }
    }
  </style>
  <!--[if IE]><div class="ie-browser"><![endif]-->
  <!--[if mso]><div class="mso-container"><![endif]-->
  <table class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #F5F5F5;width: 100%" cellpadding="0" cellspacing="0">
	<tbody>
	<tr style="vertical-align: top">
		<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #F5F5F5;"><![endif]-->

    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
<div style="line-height:30px;font-size:1px">&#160;</div>  <img class="center fixedwidth" align="center" border="0" src="https://www.uzleuven.be/sites/default/files/Centraal/Over_ons/Logos/logo_uzleuven_kleur_groot.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 325px" width="325">
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  <br>
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:14px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 28px; line-height: 33px;">Your account has been approved</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  <br>
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Dear '.$uFirstname.' '.$uLastname.'</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;"><br data-mce-bogus="1"></span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">The admin has approved your account request.</span><br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">You can now login into the Ortho Analyzer webinterface using your username ('.$uUsername.') and password.</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<span style="font-size: 18px; line-height: 32px;">Kind regards</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Orhto Analyzer</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 20px;padding-bottom: 30px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #D6D6D6;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:22px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 16px;line-height: 29px;text-align: center"><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;">QUESTIONS ABOUT THIS EMAIL?</span><br><span style="font-size: 16px; line-height: 28px;">We’re always here to help </span><br><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;"><a style="color:#7ac4d5;text-decoration: underline; color: rgb(122, 196, 213);" href="mailto:" target="_blank" rel="noopener noreferrer">hapticcollision.uzleuven@gmail.com</a></span><br></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #7ac4d5;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#7ac4d5;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#7ac4d5;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#FFFFFF; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;color:#FFFFFF;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 12px; line-height: 14px;"><span style="font-size: 12px; line-height: 14px;" id="_mce_caret" data-mce-bogus="1"><span style="background-color: rgb(122, 196, 213); font-size: 12px; line-height: 14px;"></span></span>UZ Leuven - <em>This email was automatically generated, you cannot reply on this email</em></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
		</td>
  </tr>
  </tbody>
  </table>
  <!--[if (mso)|(IE)]></div><![endif]-->


</body></html>';

		$config['protocol']   = 'smtp';
		$config['smtp_host']  = 'uit.telenet.be';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype']   = 'html';
		$config['validation'] = TRUE;
		$this->email->initialize($config);
		$this->email->set_crlf( "\r\n" );
		$this->email->from('web application email', 'web application name');
		$this->email->to($uMail);
		$this->email->subject('Your account request for Ortho Analyzer has been approved');
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

		$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
    <!--[if gte mso 9]><xml>
     <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-- -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">
	<!--<![endif]-->
    
    <style type="text/css" id="media-query">
      body {
  margin: 0;
  padding: 0; }

table, tr, td {
  vertical-align: top;
  border-collapse: collapse; }

.ie-browser table, .mso-container table {
  table-layout: fixed; }

* {
  line-height: inherit; }

a[x-apple-data-detectors=true] {
  color: inherit !important;
  text-decoration: none !important; }

[owa] .img-container div, [owa] .img-container button {
  display: block !important; }

[owa] .fullwidth button {
  width: 100% !important; }

[owa] .block-grid .col {
  display: table-cell;
  float: none !important;
  vertical-align: top; }

.ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
  width: 650px !important; }

.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%; }

.ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
  width: 216px !important; }

.ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
  width: 432px !important; }

.ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
  width: 325px !important; }

.ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
  width: 216px !important; }

.ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
  width: 162px !important; }

.ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
  width: 130px !important; }

.ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
  width: 108px !important; }

.ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
  width: 92px !important; }

.ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
  width: 81px !important; }

.ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
  width: 72px !important; }

.ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
  width: 65px !important; }

.ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
  width: 59px !important; }

.ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
  width: 54px !important; }

@media only screen and (min-width: 670px) {
  .block-grid {
    width: 650px !important; }
  .block-grid .col {
    vertical-align: top; }
    .block-grid .col.num12 {
      width: 650px !important; }
  .block-grid.mixed-two-up .col.num4 {
    width: 216px !important; }
  .block-grid.mixed-two-up .col.num8 {
    width: 432px !important; }
  .block-grid.two-up .col {
    width: 325px !important; }
  .block-grid.three-up .col {
    width: 216px !important; }
  .block-grid.four-up .col {
    width: 162px !important; }
  .block-grid.five-up .col {
    width: 130px !important; }
  .block-grid.six-up .col {
    width: 108px !important; }
  .block-grid.seven-up .col {
    width: 92px !important; }
  .block-grid.eight-up .col {
    width: 81px !important; }
  .block-grid.nine-up .col {
    width: 72px !important; }
  .block-grid.ten-up .col {
    width: 65px !important; }
  .block-grid.eleven-up .col {
    width: 59px !important; }
  .block-grid.twelve-up .col {
    width: 54px !important; } }

@media (max-width: 670px) {
  .block-grid, .col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important; }
  .block-grid {
    width: calc(100% - 40px) !important; }
  .col {
    width: 100% !important; }
    .col > div {
      margin: 0 auto; }
  img.fullwidth, img.fullwidthOnMobile {
    max-width: 100% !important; }
  .no-stack .col {
    min-width: 0 !important;
    display: table-cell !important; }
  .no-stack.two-up .col {
    width: 50% !important; }
  .no-stack.mixed-two-up .col.num4 {
    width: 33% !important; }
  .no-stack.mixed-two-up .col.num8 {
    width: 66% !important; }
  .no-stack.three-up .col.num4 {
    width: 33% !important; }
  .no-stack.four-up .col.num3 {
    width: 25% !important; }
  .mobile_hide {
    min-height: 0px;
    max-height: 0px;
    max-width: 0px;
    display: none;
    overflow: hidden;
    font-size: 0px; } }

    </style>
</head>
<body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #F5F5F5">
  <style type="text/css" id="media-query-bodytag">
    @media (max-width: 520px) {
      .block-grid {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

      .col {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

        .col > div {
          margin: 0 auto;
        }

      img.fullwidth {
        max-width: 100%!important;
      }
			img.fullwidthOnMobile {
        max-width: 100%!important;
      }
      .no-stack .col {
				min-width: 0!important;
				display: table-cell!important;
			}
			.no-stack.two-up .col {
				width: 50%!important;
			}
			.no-stack.mixed-two-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.mixed-two-up .col.num8 {
				width: 66%!important;
			}
			.no-stack.three-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.four-up .col.num3 {
				width: 25%!important;
			}
      .mobile_hide {
        min-height: 0px!important;
        max-height: 0px!important;
        max-width: 0px!important;
        display: none!important;
        overflow: hidden!important;
        font-size: 0px!important;
      }
    }
  </style>
  <!--[if IE]><div class="ie-browser"><![endif]-->
  <!--[if mso]><div class="mso-container"><![endif]-->
  <table class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #F5F5F5;width: 100%" cellpadding="0" cellspacing="0">
	<tbody>
	<tr style="vertical-align: top">
		<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #F5F5F5;"><![endif]-->

    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
<div style="line-height:30px;font-size:1px">&#160;</div>  <img class="center fixedwidth" align="center" border="0" src="https://www.uzleuven.be/sites/default/files/Centraal/Over_ons/Logos/logo_uzleuven_kleur_groot.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 325px" width="325">
<!--[if mso]></td></tr></table><![endif]-->
</div>

          <br>        
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:14px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 28px; line-height: 33px;">Your password request</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
         
		 <br>
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Dear '.$uFirstname.' '.$uLastname.'</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">You requested a new password.</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Please click on the button below to reset your password</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    
<div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$url.'" style="height:40pt; v-text-anchor:middle; width:174pt;" arcsize="8%" strokecolor="#7ac4d5" fillcolor="#7ac4d5"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif; font-size:22px;"><![endif]-->
    <a href="'.$url.'" target="_blank" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #7ac4d5; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; max-width: 232px; width: 192px;width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: "Ubuntu", Tahoma, Verdana, Segoe, sans-serif;mso-border-alt: none">
      <span style="line-height:24px;font-size:12px;"><span style="font-size: 22px; line-height: 44px;" data-mce-style="font-size: 22px; line-height: 44px;">RESET PASSWORD</span></span>
    </a>
  <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>

                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 5px;">	
		<div style="line-height:22px;font-size:12px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">If you did not ask a new password, this email can be ignored</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px">&#160;<br></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Kind regards</span></p><p style="margin: 0;line-height: 22px;text-align: center;font-size: 12px"><span style="font-size: 18px; line-height: 32px;">Orhto Analyzer</span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 20px;padding-bottom: 30px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #D6D6D6;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;"><![endif]-->
	<div style="line-height:180%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#555555; padding-right: 25px; padding-left: 25px; padding-top: 25px; padding-bottom: 25px;">	
		<div style="font-size:12px;line-height:22px;color:#555555;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 16px;line-height: 29px;text-align: center"><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;">QUESTIONS ABOUT THIS EMAIL?</span><br><span style="font-size: 16px; line-height: 28px;">We’re always here to help </span><br><span style="color: rgb(122, 196, 213); font-size: 16px; line-height: 28px;"><a style="color:#7ac4d5;text-decoration: underline; color: rgb(122, 196, 213);" href="mailto:" target="_blank" rel="noopener noreferrer">hapticcollision.uzleuven@gmail.com</a></span><br></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 650px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #7ac4d5;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#7ac4d5;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 650px;"><tr class="layout-full-width" style="background-color:#7ac4d5;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="650" style=" width:650px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 650px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
	<div style="line-height:120%;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;color:#FFFFFF; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;color:#FFFFFF;font-family:"Ubuntu", Tahoma, Verdana, Segoe, sans-serif;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><span style="font-size: 12px; line-height: 14px;"><span style="font-size: 12px; line-height: 14px;" id="_mce_caret" data-mce-bogus="1"><span style="background-color: rgb(122, 196, 213); font-size: 12px; line-height: 14px;"></span></span>UZ Leuven - <em>This email was automatically generated, you cannot reply on this email</em></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
		</td>
  </tr>
  </tbody>
  </table>
  <!--[if (mso)|(IE)]></div><![endif]-->


</body></html>';

		
		$config['protocol']   = 'smtp';
		$config['smtp_host']  = 'uit.telenet.be';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype']   = 'html';
		$config['validation'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('web application email', 'web application name');
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
