<?php 
    error_reporting(E_ALL);
    session_start();

    require('db-parameters.php');
    try {
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $sql = 'DELETE FROM hotels WHERE hotelid=:hotelid';

        $statement = $pdoObject->prepare($sql);
        $result= $statement->execute( array( ':hotelid'=> $_SESSION['hotelid'] )  );


        $statement->closeCursor();
        $pdoObject = null;

        if ($result==true) {
            unset($_SESSION['hotelid']);
            $_SESSION['mode'] = 'insert';
            header('Location: user-page.php?msg=Επιτυχής Διαγραφή!');
            exit();
        } else {
            header('Location: user-page.php?msg=ERROR: Δεν έγινε διαγραφή!');
            exit();
        }
    } catch (PDOException $e) {
        echo 'PDO Exception: '.$e->getMessage();
    }


?>