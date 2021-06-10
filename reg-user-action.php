<?php
    error_reporting(E_ALL);
    
    if ( !isset( $_POST['rusername'], $_POST['remail'], $_POST['rcemail'], $_POST['rpassword'] ) ) {
        header("Location: register-user-form.php?msg=Ελλειπή στοιχεία.");
        exit();
    }

    $rusername = trim($_POST['rusername']);
    $remail = $_POST['remail'];
    $rcemail = $_POST['rcemail'];
    $rpassword = trim($_POST['rpassword']);
    session_start();
    $_SESSION['username'] = $rusername;
    $_SESSION['email'] = $remail;
    
    if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
        header("Location: register-user-form.php?msg=Μη έγυρο email.");
        exit();
    }

    if ( $rusername == $remail ) {
        header("Location: register-user-form.php?msg=Μην χρησιμοποιείτε το email σας ως username.");
        exit();
    }
    
    if ( $remail != $rcemail ) {
        header("Location: register-user-form.php?msg=Το email επιβεβαίωσης δεν είναι ίδιο με το email. ");
        exit();
    }

    $illegalChars = "/\W/";
    if ( $rpassword == '' || strlen($rpassword) < 8 || preg_match($illegalChars, $rpassword) ) {
        header("Location: register-user-form.php?msg=Μη έγκυρος κωδικός. ");
        exit();
    }

    $result = false;
    require('db-parameters.php');
    require('functions.php');
    try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');

        $sql = 'INSERT INTO users (username, password, email) VALUES (BINARY :username, BINARY :password, BINARY :email)';

        $salt = '$6$'.randString(16);
        $encryptedPassword = crypt($rpassword,$salt);

        $statement = $pdoObject->prepare($sql);
        $result= $statement->execute( array( ':username'=>$rusername,
                                            ':password'=>$encryptedPassword, ':email'=>$remail  ) );
        
        $statement->closeCursor();
        $pdoObject = null;
    } catch (PDOException $e) {
        echo "<script>alert('PDO Exception: '.$e->getMessage());</script>";
        exit();
    }

    if ( !$result ) {  
        echo '<script>alert("Failed to execute sql query");</script>';
        header('Location: register-user-form.php');
        exit();
    } else {   
        $valCode = rand(10000,99999);
        $_SESSION['valCode'] = $valCode;
        sendValMail($remail, $rusername, $valCode);
        $sendTime = time();
        $_SESSION['sendTime'] = $sendTime;
        header('Location: validate-user.php'); 
        exit();
    }

?>