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
    <!-- ΑΥΤΗ Η ΣΕΛΙΔΑ ΕΙΝΑΙ TEMPLATE - ΔΕΝ ΧΡΗΣΙΜΟΠΟΙΕΙΤΑΙ ΑΥΤΟΥΣΙΑ ΚΑΠΟΥ -->
    <!-- Κάθε φορά που θέλουμε νέα σελίδα στο site την κλωνοποιούμε! -->

  </main>

<?php require('footer.php'); ?>
