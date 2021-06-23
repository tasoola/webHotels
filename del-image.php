<?php 
    error_reporting(E_ALL);
    session_start();

    require('db-parameters.php');

    if ( !isset( $_GET['file']) || $_GET['file']=='' ) {
        header('Location: index.php?msg=ERROR: Ανεπαρκή δεδομένα για διαγραφή!');
        exit();
    }

    $filepath = "uploaded-pictures/";
    if ( !file_exists($filePath.$_GET['file']) ) {
        header('Location: index.php?msg=ERROR: Δεν υπάρχει τέτοιο αρχείο στον φάκελο!');
        exit();    
    }

    $delResult = unlink($filePath.$_GET['file']);
    if ( $delResult ) {

        try {
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'DELETE FROM images WHERE hotel_FK=:hotel_FK';
    
            $statement = $pdoObject->prepare($sql);
            $result= $statement->execute( array( ':hotel_FK'=> $_SESSION['hotelid'] )  );
    
    
            $statement->closeCursor();
            $pdoObject = null;
    
            if ($result==true) {
                header('Location: upload-image.php?msg=Επιτυχής Διαγραφή!');
                exit();
            } else {
                header('Location: upload-image.php?msg=DB_ERROR: Δεν έγινε διαγραφή!');
                exit();
            }

        } catch (PDOException $e) {
            echo 'PDO Exception: '.$e->getMessage();
        }

    } else {
        header("Location: upload-image.php?msg=FILE_ERROR: Το αρχείο δεν διαγράφηκε.");
        exit();
    }



?>