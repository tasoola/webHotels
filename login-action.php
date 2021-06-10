<?php 
    error_reporting(E_ALL);

    session_start();
    if ( !isset($_SESSION['username']) && isset($_POST['lusername'], $_POST['lpassword']) ) {
        
        $username = $_POST['lusername'];
        $password = $_POST['lpassword'];

        
        require('db-parameters.php');
        require('functions.php');
        $authorised = false;
        try{
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "SELECT * FROM users WHERE username=:username";

            $statement = $pdoObject->prepare($sql);
            $statement->execute( array( 'username'=>$username ) );
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $count = $statement->rowCount();
            

            if ( $count > 0 ) {
                if ( $username = $row["username"] ) {
                    if ( $row["verified"] == 1 ) {
                        if ( crypt($password, $row["password"]) == $row["password"] ) {
                            $authorised = true;
                            $_SESSION['username'] = $username;

                            $sql1 = "SELECT hotelid FROM hotels WHERE username_FK=:username_FK";
                            $statement1 = $pdoObject->prepare($sql1);
                            $statement1->execute( array( 'username_FK'=>$username ) );
                            $hotel = $statement1->fetch(PDO::FETCH_ASSOC);
                            $hotelCount = $statement1->rowCount();
                            if ( $hotelCount > 0 ) {
                                $_SESSION['hotelid'] = $hotel['hotelid'];
                                $_SESSION['mode'] = 'update';
                            } else { $_SESSION['mode'] = 'insert'; }

                        } else {
                            header("Location: login-form.php?msg=Λαθος κωδικός");
                        }
                    } else {
                        header("Location: login-form.php?msg=Ο λογαριασμός δεν έχει επιβεβαιωθεί.");
                    }
                } else {
                    header("Location: login-form.php?msg=Λάθος username.");
                }
            } else {
                header("Location: login-form.php?msg=Λάθος username.");
            }

            $statement->closeCursor();
            $pdoObject = null;
            
        } catch (PDOException $e) {
            header('Location: login-form.php?msg=PDO Exception: '.$e->getMessage() );
            exit();
        }

        if ( $authorised == true ) {
            header("Location: user-page.php");
            exit();
        } else {
            header("Location: login-form.php?msg=Η σύνδεση δεν πραγματοποιήθηκε.");
            exit();
        }

    } else {
        
        session_destroy();
        header("Location: login-form.php?msg=Παρουσιάστηκε κάποιο πρόβλημα. Δοκιμάστε ξανά.");
    }
?>