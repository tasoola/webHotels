<?php session_start(); ?>
<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php
  $title='webHotels | Σελίδα Χρήστη';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>


    <main id="main">
        <div class="userpage-wrap">
            <h1>Γεια σου <?php echo $_SESSION['username'] ?>!</h1>
            <?php
                require("functions.php"); 
                echo_msg(); 
            ?>
            <br><br><br>
            <?php if( isset( $_SESSION['hotelid'] ) ) {    
                echo '<a class="btn" href="hotel-info-page.php?viewMode=user&srhotelid='.$_SESSION['hotelid'].'">Προβολή Ξενοδοχείου</a>' ?>
                <br><br><br>
                <a class="btn" href="upload-image.php">Gallery Ξενοδοχείου</a>
                <br><br><br>
            <?php } ?>
            
            <?php if( !isset( $_SESSION['hotelid'] ) ) {   ?>                 
                <a class="btn" href="reg-dualform.php">Καταχώρηση Ξενοδοχείου</a>
            <?php } else {  ?>
                <a class="btn" href="reg-dualform.php">Τροποποίηση Ξενοδοχείου</a>
                <br><br><br>
                <a class="btn" href="del-hotel.php">Διαγραφή Ξενοδοχείου</a>
            <?php } ?>
            <br><br><br>
            <a class="btn" href="logout.php">Αποσύνδεση</a>
            <br><br><br>
            <br><br><br>
            
        </div>
    </main>
<?php require('footer.php'); ?>