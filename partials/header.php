<?php
include ('config/database.php');

//fetch current user from database
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = $con->prepare("SELECT avatar FROM users WHERE user_id=?");
    $query ->execute([$id]);
    $avatar = $query->fetchAll();
}
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
     <!--start of nav bar -->
    <nav>
        <div class="container nav__container">
            <a href="<?=ROOT_URL?>index.php" class="nav__logo">PRAISE</a>
            <ul class="nav__items">
                <li><a href="<?=ROOT_URL?>blog.php">Blog</a></li>
                <li><a href="<?=ROOT_URL?>about.php">About</a></li>
                <li><a href="<?=ROOT_URL?>service.php">Service</a></li>
                <li><a href="<?=ROOT_URL?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['uid'])):?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL .'image/' . $avatar['avatar'] ?>" alt="proflie_img">
                    </div>
                    <ul>
                        <li><a href="<?=ROOT_URL?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?=ROOT_URL?>controller/users.php?q=logout">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?=ROOT_URL?>signing.php">Sign in</a></li>  
                <?php endif ?> 
            </ul>

            <button id="open_nav_btn"><i class="uil uil-bars"></i></button>
            <button id="close_nav_btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!--end of nav bar -->