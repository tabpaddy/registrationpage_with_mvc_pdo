<?php
include('./partials/header.php');
?>

    <section class="empty__page">
        <h1>Welcome <?php if(isset($_SESSION['uid'])){
            echo explode(" ", $_SESSION['username'])[0];
        }else{
            echo 'Guest';
        } ?></h1>
    </section>

 


    <?php
include('./partials/footer.php');
?>