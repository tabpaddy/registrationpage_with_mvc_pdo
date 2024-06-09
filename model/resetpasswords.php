<?php
require_once '../config/database.php';

class ResetPassword{
    private $db;
     
    public function __construct()
    {
        $this->db = new Database;
    }

    public function deleteEmail($email){
        $this->db->query('DELETE FROM passreset WHERE passresetEmail=:email');
        $this->db->bind(':email', $email);
        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function insertToken($email, $selector, $hashedToken, $expires){
        $this->db->query('INSERT INTO passreset(passresetEmail, passresetSelector, passresetToken, passresetExpires) VALUES (:email, :selector, :token, :expires)');
        $this->db->bind(':email', $email);
        $this->db->bind(':selector', $selector);
        $this->db->bind(':token', $hashedToken);
        $this->db->bind(':expires', $expires);

        // execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function resetPassword($selector, $currentDate){
        $this->db->query('SELECT * FROM passreset WHERE passresetSelector=:selector AND passresetExpires >= :currentDate');
        $this->db->bind(':selector', $selector);
        $this->db->bind(':currentDate', $currentDate);
        //execute
        $row = $this->db->single();

        // check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }
}