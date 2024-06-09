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
        <h2>Sign Up</h2>
        <?php flash('register') ?>
        <form action="<?=ROOT_URL?>controller/users.php" enctype="multipart/form-data" method="post">
            <input type="hidden" name="type"  value="register">
            <input type="text" name="username" id="" placeholder="Username" value="">
            <input type="email" name="email" id="" placeholder="Email" value="">
            <input type="password" name="password" id="" placeholder="Create Password" value="">
            <input type="password" name="cpassword" id="" placeholder="Confirm Password" value="">
            <button type="submit" class="btn" name="submit">Sign Up</button>
            <small>Already have an account? <a href="<?=ROOT_URL?>signing.php">Sign In</a></small>
        </form>
    </div>
</section>




<script src="js/main.js"></script>
</body>
</html>