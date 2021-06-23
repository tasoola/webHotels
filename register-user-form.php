<?php session_start(); ?>
<style type="text/css">
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
                var username = document.getElementById("rusername").value;
                //έλεγχος εάν έχει συμπληρωθεί το username
                if ( !username ) {
                    alert("Το πεδίο username είναι υποχρεωτικό.");
                }
                
                var email = document.getElementById("remail").value;
                //έλεγχος εάν έχει συμπληρωθεί το email
                if ( !email ) {
                    alert("Το πεδίο email είναι υποχρεωτικό.");
                }
                //έλεγχος αν το email χρησιμοποιήθηκε ως username
                if ( email == username ) {
                    result = false;
                    document.getElementById("remail").style.borderBottom="2px solid red";
                    alert("Παρακαλώ μην χρησιμοποιείτε το email σας για username");
                }
                
                var conf_email = document.getElementById("rcemail").value;
                //έλεγχος εάν έχει συμπληρωθεί το confirm email
                if ( !conf_email ) {
                    alert("Παρακαλώ επιβεβαιώστε το email σας.");
                }
                //έλεγχος αν το email είναι ίδιο με το email επιβεβαίωσης
                if ( conf_email != email ) {
                    result = false;
                    document.getElementById("remail").style.borderBottom="2px solid red";
                    document.getElementById("rcemail").style.borderBottom="2px solid red";
                    alert("Τα δύο email δεν είναι ίδια");
                }

                var password = document.getElementById("rpassword").value;
                //έλεγχος εάν έχει συμπληρωθεί το password
                if ( !password ) {
                    alert("Το πεδίο password είναι υποχρεωτικό.");
                }
                //έλεγχος αν ο κωδικός είναι έγκυρος ( >8 + [0-9A-Za-z_])
                var illegalChars = /\W/;
                if ( password.length < 8 ) {
                    result = false;
                    document.getElementById("rpassword").style.borderBottom="2px solid red";
                    alert("Ο κωδικός πρέπει να έχει μήκος τουλάχιστον 8 χαρακτήρες");
                }

                if ( illegalChars.test(password) ) {
                    result = false;
                    document.getElementById("rpassword").style.borderBottom="2px solid red";
                    alert("Επιτρεπτοί χαρακτήρες είναι: κεφαλαία και πεζά λατινικά γράμματα, τα 10 αριθμητικά ψηφία και η κάτω παύλα");
                }

                return result;
            }

            function initAJAX(){
			    if (window.XMLHttpRequest) { // all modern browsers
				    return xmlhttp=new XMLHttpRequest();
			    } else if (window.ActiveXObject) { //for IE5, IE6
				    return xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			    } else {//AJAX not supported
				    alert("Your browser does not support AJAX calls!");
			    return false;
			    }
		    }

		    function dbcheck(val,ch) {
			    var ajaxObject = initAJAX();
			    if ( ajaxObject ) {
				    if ( ch == 'u' )
					    var url = "ajax-action.php?val="+val+"&ch="+ch;
				    if ( ch == 'e' )
					    var url = "ajax-action.php?val="+val+"&ch="+ch;
				    ajaxObject.open("GET",url,true);
				    ajaxObject.send();
				    ajaxObject.onreadystatechange=function(){
					    if ( ajaxObject.readyState==4 && ajaxObject.status==200 ) {
						    checkDiv = document.getElementById(ch+'dbcheck');
						    checkDiv.innerHTML = ajaxObject.responseText;
					    }
				    }
			    }
		    }

        </script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>



        <div class="form-container">
            <h1>Εγγραφή χρήστη</h1>
            <form class="form" id="register-form" name="register-form" action="reg-user-action.php" method="post" onsubmit="return validate_form();">
        

                <label for="rusername">Username</label>
                <br>
                <input type="text" placeholder="Εισάγετε username" name="rusername" id="rusername" size="25" maxlength="25" 
                    onfocus="highlightOn('rusername');" onblur="highlightOff('rusername');" onkeyup="dbcheck(this.value,'u');" />
                <br>
                <div id="udbcheck" class="dbcheck"></div>
                <br>

                <label for="remail">Email</label>
                <br>
                <input type="email" placeholder="Εισάγετε email" name="remail" id="remail" size="25" maxlength="100" 
                    onfocus="highlightOn('remail');" onblur="dbcheck(this.value,'e');highlightOff('remail');"/>
                <br>
                <div id="edbcheck" class="dbcheck"></div>
                <br>

                <label for="rcemail">Επιβεβαίωση email</label>
                <br>
                <input type="email" placeholder="Επιβεβαιώστε το email" name="rcemail" id="rcemail" size="25" maxlength="100" 
                    onfocus="highlightOn('rcemail');" onblur="highlightOff('rcemail');"/>
                <br><br>

                <label for="rpassword">Password</label>
                <br>
                <input type="password" placeholder="Εισάγετε κωδικό" name="rpassword" id="rpassword" size="25" maxlength="50" 
                    onfocus="highlightOn('rpassword');" onblur="highlightOff('rpassword');"/>
                <br>
                <?php
                    require("functions.php"); 
                    echo_msg(); 
                ?>
                <br>

                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                <br/>

                <button type="submit" class="btn">Εγγραφή</button>
    
            </form>
            <div id="redirect-form">
                <p>Έχεις ήδη λογαριασμό;      <a href="login-form.php">Συνδέσου!</a> </p>
            </div>
        </div>
    </main>

<?php require('footer.php'); ?>