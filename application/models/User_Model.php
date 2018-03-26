<?php
/**
 * Created by PhpStorm.
 * User: Soufiane
 * Date: 26/03/2018
 * Time: 11:38
 */

class User_Model extends CI_Model
{
    public function registerEmailCheck($sEmail){
        $sql = "SELECT * FROM docters WHERE email = ?";
        $aResult = $this->db->query($sql, array($sEmail));
        $aUsers = $aResult->result();
        if ( isset($aUsers) && !empty($aUsers)){
            // Already user with this email in database
            $this->form_validation->set_message('email_check', '{field} error: Already used email');
            return false;
        }
        else{ return true;}

    }
    public function registerUsernameCheck($sUsername){
        $sql = "SELECT * FROM docters WHERE username = ?";
        $aResult = $this->db->query($sql, array($sUsername));
        $aUsers = $aResult->result();

        if ( isset($aUsers) && !empty($aUsers)){
            // Already user with this username in database
            $this->form_validation->set_message('username_check', '{field} error: Already used username');
            return false;
        }
        else{ return true;}

    }

    public function registerNewUser($aUserData){
        try {
            $sql = "Insert into docters (firstname, lastname, email, function, workplace, country,phone, surgical_experience, username, password,userlevel, approved )
                      VALUES (?, ?, ? , ? , ? ,?, ?, ?, ? , ? , ? ,?)";
            $this->db->query($sql, array($aUserData["firstname"], $aUserData["lastname"], $aUserData["email"], $aUserData["function"],
                $aUserData["workplace"], $aUserData["country"], $aUserData["phone"], $aUserData["surgical_experience"], $aUserData["username"]
            , $aUserData["password"], $aUserData["userlevel"], $aUserData["approved"]));
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }

}