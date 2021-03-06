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
        $sql = "SELECT * FROM users WHERE email = ?";
        $aResult = $this->db->query($sql, array($sEmail));
        $aUsers = $aResult->result();
        if ( isset($aUsers) && !empty($aUsers)){
            // Already user with this email in database
            return false;
        }
        else{ return true;}

    }
    public function registerUsernameCheck($sUsername){
        $sql = "SELECT * FROM users WHERE username = ?";
        $aResult = $this->db->query($sql, array($sUsername));
        $aUsers = $aResult->result();

        if ( isset($aUsers) && !empty($aUsers)){
            // Already user with this username in database
            return false;
        }
        else{ return true;}

    }
    public function registerNewUser($aUserData){
        try {
            $sql = "Insert into users (firstname, lastname, email, function, workplace, country,phone, surgical_experience, username, password,userlevel, approved )
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

    public function loginUserCheck($sUsername, $sPassword){

        try {
            $sql = "SELECT * FROM users WHERE username = ?";
            $aResult = $this->db->query($sql, array($sUsername));
            $aUsers = $aResult->result();
        }
        catch (Exception $e){ return false; }

        if (!empty($aUsers)){
            // The user with this username exist
            $sHashedPassword = $aUsers[0]->password;

            if (password_verify($sPassword, $sHashedPassword)){
                return $aUsers[0];
            }
            else{ return false;}

        }
        else{ return false;}
    }

    public function getAllUsers(){
        try{
            $sql = "SELECT * FROM users WHERE userlevel BETWEEN  ? AND ?";
            $query = $this->db->query($sql, array(0,3));
        }
        catch(Exception $e){
            return false;
        }
        return $query;
    }

    public function modifyUser($aUser){
        $sSQL = "UPDATE users SET userlevel = ?, approved = ? WHERE userid = ?";
        try{
            $this->db->query($sSQL, array($aUser["userlevel"],$aUser["approved"],$aUser["userid"]));
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }

    public function deleteUser($sUserId){
        $sSQL = "DELETE FROM users WHERE userid = ?";
        try{
            $this->db->query($sSQL, array($sUserId));
        }
        catch (Exception $e){
            return false;
        }
        return true;
    }
    public function updateSecret($sUsername, $sAuth_Secret){
        $sSQL = "UPDATE users SET auth_secret = ? WHERE username = ?";
        try{
            $this->db->query($sSQL, array($sAuth_Secret ,$sUsername));
        }
        catch (Exception $e){
            return false;
        }
        return true;

    }




}