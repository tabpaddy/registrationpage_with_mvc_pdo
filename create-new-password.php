<?php
    if(!isset($_GET['selector']) || !isset($_GET['validator'])){
        echo 'Could not validate your request!, missing parameters';
    }else{
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];

        if(ctype_xdigit($selector) && ctype_xdigit($validator)){
?>
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
        <h2>Enter password</h2>
        <?php flash('newReset') ?>
        <form action="<?=ROOT_URL?>controller/resetPassword.php" method="post">
            <input type="hidden" name="type" value="reset">
            <input type="hidden" name="selector" value="<?=$selector?>">
            <input type="hidden" name="validator" value="<?=$validator?>">
            <input type="password" name="password" id="" placeholder="Enter Password" value="">
            <input type="password" name="cpassword" id="" placeholder="Re-enter Password" value="">
            <button type="submit" class="btn" name="submit">Receive Email</button>
        </form>
    </div>
</section>




<script src="js/main.js"></script>
</body>
</html>

<?php
}else{
    echo 'Could not validate your request, wrong format';
}
    }
?>