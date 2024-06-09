```markdown
# PDO Login System with Password Reset

This project is a PHP-based login system with password reset functionality using PHPMailer and PDO for database interactions. The system allows users to reset their passwords via email verification.

## Features

- User Registration
- User Login
- Password Reset via Email
- Secure password hashing
- Input validation and sanitization

## Technologies Used

- PHP
- PDO (PHP Data Objects)
- PHPMailer
- MySQL
- HTML/CSS
- JavaScript

## Prerequisites

- PHP 7.4 or higher
- MySQL
- Composer (for dependency management)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/tabpaddy/registrationpage_with_mvc_pdo.git
cd registrationpage_with_mvc_pdo
```

### 2. Install Dependencies

Install PHPMailer via Composer:

```bash
composer require phpmailer/phpmailer
```

### 3. Configure Database

Create a MySQL database and import the following table structure:

```sql
CREATE TABLE registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE passreset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    passresetEmail VARCHAR(255) NOT NULL,
    passresetSelector CHAR(16) NOT NULL,
    passresetToken CHAR(64) NOT NULL,
    passresetExpires BIGINT NOT NULL
);
```

### 4. Configure Database Connection

Edit `config/database.php` and update the database credentials:

```php
<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'your_database_name';
    private $username = 'your_username';
    private $password = 'your_password';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
```

### 5. Configure PHPMailer

Edit `controller/resetPassword.php` and update the PHPMailer configuration:

```php
use PHPMailer\PHPMailer\PHPMailer;

require_once '../model/resetPasswords.php';
require_once '../helpers/session_helper.php';
require_once '../model/signup-modal.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/SMTP.php';

class ResetPasswords {
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct() {
        $this->resetModel = new ResetPassword;
        $this->userModel = new User;
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = 'your_mailtrap_username';
        $this->mail->Password = 'your_mailtrap_password';
    }
    
    // Rest of the code...
}
```

### 6. Start the Server

Run the PHP built-in server:

```bash
php -S localhost:8080
```

### 7. Access the Application

Open your web browser and navigate to:

```
http://localhost:8080
```

## Usage

### Password Reset Workflow

1. Go to the reset password page and enter your email.
2. You will receive an email with a password reset link.
3. Click on the link to open the password reset form.
4. Enter your new password and submit.

## File Structure

```
pdo-login-system/
├── config/
│   └── database.php
│   └── constant.php
├── controller/
│   └── resetPassword.php
│   └── users.php
├── helpers/
│   └── session_helper.php
├── model/
│   ├── resetPasswords.php
│   └── signup-modal.php
├── PHPMailer/
│   ├── src/
│   │   ├── Exception.php
│   │   ├── PHPMailer.php
│   │   └── SMTP.php
├── view/
│   ├── reset-password.php
│   └── create-new-password.php
├── css/
│   └── style.css
├── js/
│   └── main.js
├── index.php
└── README.md
```

## License

This project is licensed under the MIT License.

## Acknowledgments

- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)

```

### Notes:
- Replace placeholders like `your_database_name`, `your_username`, `your_password`, `your_mailtrap_username`, and `your_mailtrap_password` with your actual database and Mailtrap credentials.
- Ensure you have Composer installed to manage dependencies.
- Adjust the project structure and file paths as needed based on your actual project setup.

