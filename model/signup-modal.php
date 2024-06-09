<?php

require_once '../config/database.php';

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // find user by email or username
    public function findUserByEmailOrUsername($email, $username){
        $this->db->query('SELECT * FROM registration WHERE username= :username OR email = :email');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    // Register user
    public function register($data){
        $this->db->query('INSERT INTO registration (username, email, password) VALUES (:username, :email, :password)');

        // bin values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        // Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // login user
    public function login($username_email, $password){
        $row = $this->findUserByEmailOrUsername($username_email, $username_email);

        if($row == false){
            return false;
        } else{
            $hashedPassword = $row->password;
                    // Debugging statement
        // echo "User found: <br>";
        // echo "Username: " . $row->username . "<br>";
        // echo "Email: " . $row->email . "<br>";
        // echo "Stored Hash: " . $hashedPassword . "<br>";
        // echo "Input Password: " . $password . "<br>";
            
            if(password_verify($password, $hashedPassword)){
                echo "Password verification succeeded.<br>";
                return $row;
            }else{
                echo "Password verification failed.<br>";
                return false;
            }
        }   
    }

    // reset Password
    public function resetPassword($newPasshash, $tokenEmail){
        $this->db->query('UPDATE registration SET password=:pass WHERE email=:email');
        $this->db->bind(':pass', $newPasshash);
        $this->db->bind(':email', $tokenEmail);

        // Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}