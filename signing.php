<?php
include ('config/database.php');
include './helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <!-- custom css -->
    <link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
    <!-- icon scout -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    
    <section class="form__section">
    <div class="container form__selection-container">
        <h2>Sign In</h2>
        <?php flash('login') ?>
        <form action="<?=ROOT_URL?>controller/users.php" method="post">
            <input type="hidden" name="type" value="login">
            <input type="text" name="username_email" id="" placeholder="Username or Email" value="">
            <input type="password" name="password" id="" placeholder="Enter Password" value="">
            <button type="submit" class="btn" name="submit">Sign in</button>
            <small>Already have an account? <a href="<?=ROOT_URL?>signup.php">Sign Up</a></small>
            <div class=""><a href="<?=ROOT_URL?>reset-password.php">Forgotten Password</a></div>
        </form>
    </div>
</section>




<script src="js/main.js"></script>
</body>
</html>