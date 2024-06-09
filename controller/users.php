<?php
require_once '../model/signup-modal.php';
require_once '../helpers/session_helper.php';

class Users{

    private $userModal;

    public function __construct()
    {
        $this->userModal = new User;
    }

    public function register(){
        // process form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'cpassword' => trim($_POST['cpassword']),
        ];

        // Validate inputs
        if(!$data['username'] || !$data['email'] || !$data['password'] || !$data['cpassword']){
            flash("register", "Please fill out all inputs");
            redirect("../signup.php");
        }

        if(!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])){
            flash("register", "Invalid username");
            redirect("../signup.php");
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            flash("register", "Invalid email");
            redirect("../signup.php");
        }

        if(strlen($data['password']) < 6){
            flash("register", "Password should be more than 6 characters");
            redirect("../signup.php");
        }elseif($data['password'] !== $data['cpassword']){
            flash("register", "Password don't match");
            redirect("../signup.php");
        }

        // User with the same email or username already exits
        if($this->userModal->findUserByEmailOrUsername($data['email'], $data['username'])){
            flash("register", "Username or email already taken");
            redirect("../signup.php");
        }

        // passed all validation checks
        // now going to hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // register User
        if($this->userModal->register($data)){
            redirect("../signing.php");
        }else{
            die("Something went wrong");
        }
    }

    public function login(){
        // sanitize Post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // init  data
        $data=[
            'username_email' => trim($_POST['username_email']),
            'password' => trim($_POST['password'])
        ];

        if(!$data['username_email'] || !$data['password']){
            flash("login", "Please fill out all input");
            redirect("../signing.php");
        }

        // Check for username or email
        if($this->userModal->findUserByEmailOrUsername($data['username_email'], $data['username_email'])){
            // user found
            $loggedInUser = $this->userModal->login($data['username_email'], $data['password']);
            if($loggedInUser){
                // create session
                $this->createUserSession($loggedInUser);
            }else{
                flash("login", "Password Incorrect");
                redirect("../signing.php");
                
            }
        }else{
            flash("login", "No user found");
            redirect("../signing.php");
        }
    }

    public function createUserSession($user){
        $_SESSION['uid'] = $user->uid;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        redirect("../index.php");
    }

    public function logout(){
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        session_destroy();
        redirect("../index.php");
    }
}

$init = new Users;

// Ensure that user is sending a POST request.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch ($_POST['type']) {
        case 'register':
            # code...
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
            default:
            redirect("../index.php");

    }
}else{
    switch($_GET['q']){
        case 'logout':
            $init->logout();
            break;
        default:
        redirect("../index.php");
    }
}