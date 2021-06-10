<?php session_start(); ?>
<style>
  <?php require('style.css'); ?>
</style>

<?php
  $title='webHotels | Εγγραφή Χρήστη';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

<script>

  function highlightOn(element) {
    style = document.getElementById(element).style;
    document.getElementById(element).style.borderBottom="2px solid #1F2C9D";   
  }
</script>

<script>
  function highlightOff(element) {
    document.getElementById(element).style = style;
  }
</script>

<script>
  function validate_form() {
    var result = true;
    var time = document.getElementByID("timer").value;
    if( time == "EXPIRED" ) {
      result = false;
      alert("Ο κωδικός έχει λήξει.");
    }
    
    //AJAX ελεγχος για κωδικό
  }

</script>

<script>

  //TIMER
  var fiveMins = new Date().getTime() + 300000;

  var countDownTime = new Date(fiveMins).getTime();

  var x = setInterval(function() {

    var now = new Date().getTime();

    var distance = countDownTime - now;

    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";

    if (distance < 0) {
      clearInterval(x);
      document.getElementById("timer").innerHTML = "EXPIRED";
    }
  }, 1000);
</script>


  <main id="main">
    
    <div class="form-container" style="text-align:center;">
      <h1>Επιβεβαίωσε το λογαριασμό σου</h1>
      <p>Για την επιβεβαίωση του λογαριασμού σου στείλαμε έναν κωδικό στο email που δήλωσες.</p>

      <form class="form" id="register-form" name="user-val" action="val-user-action.php" method="post" onsubmit="return validate_form();">
        <label for="val-code">Συμπλήρωσε τον κωδικό που παρέλαβες</label>
        <br><br>
        <input type="text" name="val-code" id="val-code" size="5" maxlength="5" 
            onfocus="highlightOn('val-code');" onblur="highlightOff('val-code');"/>
        <br><br>
        <button type="submit" name="submitButton" class="btn" >Επιβεβαίωση</button>
      </form>
      <form class="form" id="resend" name="resend" action="resend-button.php" method="post">
        <button type="submit" name="resendButton" class="btn">Ξαναστείλε μου κωδικό</button>
      </form>
      
      <p> Ο κωδικός που στάλθηκε λήγει σε </p><span id="timer"></span>

    </div>
  </main>

<?php require('footer.php'); ?>