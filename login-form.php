<?php session_start(); ?>
<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php
  $title='webHotels | Σύνδεση Χρήστη';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

    <main id="main">
        <script type="text/javascript">

            function highlightOn(element) {
                style = document.getElementById(element).style;
                document.getElementById(element).style.borderBottom="2px solid #1F2C9D";   
            }

            function highlightOff(element) {
                document.getElementById(element).style = style;
            }

            function validate_form() {
                var result = true;
                var username = document.getElementById("lusername").value;
                if(!username){
                    result = false;
                    alert("Χρειάζεται το username για να γίνει σύνδεση.");
                }
                //ελεγχος στην database (AJAX??)
                var password = document.getElementById("lpassword").value;
                if(!password) {
                    result = false;
                    alert("Ο κωδικός χρειάζεται για να γίνει σύνδεση.");
                }
                //έλεγχος για password

                return result;
            }


        </script>

        
        <div class="form-container">
            <h1>Σύνδεση χρήστη</h1>
            <form class="form" id="login-form" name="login-form" action="login-action.php" method="post" onsubmit="return validate_form();">
                
                <label for="lusername">Username</label>
                <br>
                <input type="text" placeholder="Εισάγετε username" name="lusername" id="lusername" size="25" maxlength="25" 
                        onfocus="highlightOn('lusername');" onblur="highlightOff('lusername');"/>
                <br><br>
                <label for="lpassword">Κωδικός</label>
                <br>
                <input type="password" placeholder="Εισάγετε κωδικό" name="lpassword" id="lpassword" size="25" maxlength="25" 
                        onfocus="highlightOn('lpassword');" onblur="highlightOff('lpassword');"/>
                <br>
                <?php
                    require("functions.php"); 
                    echo_msg(); 
                ?>
                <br>

                <button type="submit" class="btn" >Σύνδεση</button>

            </form>
            <div id="redirect-form">
                <p>Δεν έχεις λογαριασμό;      <a href="register-user-form.php">Κάνε Εγγραφή!</a> </p>
            </div>
            
        </div>
    </main>

<?php require('footer.php'); ?>