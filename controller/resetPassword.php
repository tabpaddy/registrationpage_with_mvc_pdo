<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../model/resetPasswords.php';
require_once '../helpers/session_helper.php';
require_once '../model/signup-modal.php';
// require php Mailer
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/SMTP.php';

class ResetPasswords{
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
        $this->resetModel = new ResetPassword;
        $this->userModel = new User;
        // setup php mailer
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = '2d5a42259b63bd';
        $this->mail->Password = '6ed9bf6cebd1b2';
    }

    public function sendEmail(){
        // Sanitize Post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $usersEmail = trim($_POST['email']);

        if(!$usersEmail){
            flash("reset", "please input email");
            redirect("../reset-password.php");
        }

        if(!filter_var($usersEmail, FILTER_VALIDATE_EMAIL)){
            flash("reset", "Invalid email");
            redirect("../reset-password.php");
        }

        // will be used to query the user from the database
        $selector = bin2hex(random_bytes(8));
        // will be  used fpr confirmation once the database entry has been matched
        $token = random_bytes(32);
        $url = ROOT_URL . '/create-new-password.php?selector=' . $selector . '&validator=' . bin2hex($token);

         // Debugging output
        echo "Generated URL: " . htmlspecialchars($url) . "<br>";
        // Expiration date will last for half an hour
        $expires = date("U") + 1800;
        if(!$this->resetModel->deleteEmail($usersEmail)){
            die("there was an error");
        }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if(!$this->resetModel->insertToken($usersEmail, $selector, $hashedToken, $expires)){
            die("there was an error");
        }
        // can send email now
        $subject = "Reset your password";
        $message = "<p>We received a password reset request.</p>";
        $message .= "<p>Here is your password reset link: </p>";
        $message .= "<a href='".$url."'>".$url."</a>";

        try {
            $this->mail->setFrom('taborota@gmail.com');
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->addAddress($usersEmail);

            $this->mail->send();
            flash('reset', 'Check your email', 'alert__message success');
            redirect("../reset-password.php");
        } catch (Exception $e) {
            flash('reset', 'Email could not be sent. Mailer Error: ' . $this->mail->ErrorInfo, 'alert__message error');
        }
        
    }

    public function resetPassword(){
        // sanitize Post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
            'selector' => trim($_POST['selector']),
            'validator' => trim($_POST['validator']),
            'password' => trim($_POST['password']),
            'cpassword' => trim($_POST['cpassword'])
        ];
        $url ='../create-new-password.php?selector='.$data['selector'].'&validator='.$data['validator'];

        if(!$_POST['password'] || !$_POST['cpassword']){
            flash('newReset', 'Please fill out all fields');
            redirect($url); 
        }elseif($data['password'] != $data['cpassword']){
            flash('newReset', 'Passwords do not match');
            redirect($url);
        }elseif(strlen($data['password']) < 6){
            flash('newReset', 'Invalid password');
            redirect($url);
        }

        $currentDate = date("U");
        if(!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)){
            flash("newReset", "Sorry. The link is no longer valid");
            redirect($url);
        }

        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->passresetToken);
        if(!$tokenCheck){
            flash("newReset", "you need to re-submit your reset request");
            redirect($url);
        }

        $tokenEmail = $row->passresetEmail;
        if(!$this->userModel->findUserByEmailOrUsername($tokenEmail, $tokenEmail)){
            flash("newReset", "There was an error");
            redirect($url);
        }

        $newPasshash = password_hash($data['password'], PASSWORD_DEFAULT);
        if(!$this->userModel->resetPassword($newPasshash, $tokenEmail)){
            flash("newReset", "There was an error");
            redirect($url);
        }

        if(!$this->resetModel->deleteEmail($tokenEmail)){
            flash("newReset", "There was an error");
            redirect($url);
        }

        flash("newReset", "Password Updated", 'alert__message success');
        redirect($url);
    }
}

$init = new ResetPasswords;

// ensure that user is sending a post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch ($_POST['type']) {
        case 'send':
            # code...
            $init->sendEmail();
            break;
        case 'reset':
            $init->resetPassword();
            break;

    }
}else{
        redirect("../index.php");
}