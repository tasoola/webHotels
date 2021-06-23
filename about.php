<?php session_start(); ?>

<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php
  $title='--- να βάλω τίτλο στη νέα σελίδα ---';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

  <main id="main">
    <div class="form-container">
        <h1>Δεν πρόλαβα να φτιάξω αυτή τη σελίδα! </h1>
    </div>
    <div class="form-container" id="FAQ">
        <h1> :) </h1>
    </div>


  </main>

<?php require('footer.php'); ?>
