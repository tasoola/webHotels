<?php
    error_reporting(E_ALL);
    


    require('db-parameters.php');
    $valTime = time();
    session_start();
    if ( $valTime - $_SESSION['sendTime'] < 300 ) {
        if ( isset( $_POST['val-code'] ) ) {
            if( $_SESSION['valCode'] == $_POST['val-code'] ) {
                try {
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject -> exec('set names utf8');

                    $sql = "UPDATE users SET verified=1 WHERE username=:username";

                    $statement = $pdoObject->prepare($sql);
                    $result= $statement->execute( array( ':username'=>$_SESSION['username'] ) );
        
                    $statement->closeCursor();
                    $pdoObject = null;



                } catch(PDOException $e) {
                    echo "<script>alert('PDO Exception: '.$e->getMessage());</script>";
                    exit();
                }
                session_destroy();
                header('Location: login-form.php?msg=Ο λογαριασμός επαληθέυτηκε μα επιτυχία. Μπορείτε να συνδεθείτε! :)');
            } else {
                echo '<script>alert("Μη έγκυρος κωδικός.");</script>';
            }
        }
                
    } else {
        echo '<script>alert("Ο κωδικός έληξε.");</script>';
    }
?>