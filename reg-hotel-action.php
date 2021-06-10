<?php
    error_reporting(E_ALL);
    session_start();


    if( isset( $_POST['hotelid']) ){
        $mode ='update';
    }
    else {
        $mode ='insert';
    }

        


    //ΕΛΕΓΧΟΙ
    if( $mode == 'insert' ) {
        if( !isset($_POST['hotelname'], $_POST['location'], $_POST['address'], $_POST['phoneNum']) ) {
            header("Location: reg-dualform.php?msg=Ελλειπή στοιχεία.");
            exit();
        }
    }

    if( $mode == 'update' ) {
        if( !isset(  $_POST['hotelid'], $_POST['hotelname'], $_POST['location'], $_POST['address'], $_POST['phoneNum'] ) ) {
            header("Location: reg-dualform.php?msg=Ελλειπή στοιχεία.");
            exit();
        }
    }
    
    $hotelName = trim( $_POST['hotelname'] );
    if ( $hotelName == '' ) {
        header("Location: reg-dualform.php?msg=Μη έγκυρη ονομασία επιχείρησης.");
        exit();
    } 

    $location = trim( $_POST['location'] );
    if ( $location == '' ) {
        header("Location: reg-dualform.php?msg=Μη έγκυρη τοποθεσία.");
        exit();
    }

    $address = trim( $_POST['address'] );
    if ( $address == '' ) {
        header("Location: reg-dualform.php?msg=Μη έγκυρη διέυθυνση.");
        exit();
    }

    $pattern = "/[^0-9]/";
    $phoneNum = trim( $_POST['phoneNum'] );
    if ( $phoneNum == '' || preg_match($pattern, $phoneNum) || strlen($phoneNum) > 15 ) {
        header("Location: reg-dualform.php?msg=Μη έγκυρος αριθμός τηλεφώνου.");
        exit();
    }

    if ( isset($_POST['rooms']) ) {
        if ( is_nan( floatval($_POST['rooms'] )) ) {
            header("Location: reg-dualform.php?msg=Μη έγκυρος αριθμός δωματίων.");
            exit();
        }
    }
    
    if ( isset($_POST['rating']) ) {
        if ( is_nan( floatval($_POST['rating'] )) || floatval($_POST['rating']) < 0  || floatval($_POST['rating']) > 5 ) {
            header("Location: reg-dualform.php?msg=Μη έγκυρη βαθμολογία.");
            exit();
        }
    }
    

    if ( isset($_POST["businessEmail"]) && $_POST["businessEmail"] != "" ) {
        $hotelemail = $_POST["businessEmail"];
        if ( !filter_var($hotelemail, FILTER_VALIDATE_EMAIL) ) {
            header("Location: reg-dualform.php?msg=Μη έγκυρο email.");
            exit();
        }
    }
    
    if ( isset($_POST['longitude'], $_POST['latitude'] ) ) {
        if ( is_nan( floatval($_POST['longitude'] )) || floatval($_POST['longitude']) < -180  || floatval($_POST['longitude']) > 180 ) {
            header("Location: reg-dualform.php?msg=Μη έγκυρο γεωγραφικό μήκος.");
            exit();
        }
        if ( is_nan( floatval($_POST['latitude']) ) || floatval($_POST['latitude']) < -90  || floatval($_POST['latitude']) > 90 ) {
            header("Location: reg-dualform.php?msg=Μη έγκυρο γεωγραφικό πλάτος.");
            exit();
        }
    }


    if ( strlen($_POST['description']) > 500 ) {
        header("Location: reg-dualform.php?msg=Η περιγραφή είναι πολύ μεγάλη. Επιτρεπτό όριο: 500 χαρακτήρες.");
        exit();
    }
    // ΤΕΛΟΣ ΕΛΕΓΧΩΝ
    $equipment="";
    if ( isset( $_POST['equipment'] )  ) {
        $equipment = implode( "," , $_POST['equipment'] );
    }

    // ΕΙΣΑΓΩΓΗ / ΤΡΟΠΟΠΟΙΗΣΗ 
    $result = false;
    require('db-parameters.php');

    try {
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if ( $mode == 'insert' ) {
            $sql = 'INSERT INTO hotels (businessTitle, location, address, telephoneNum, roomsAvailable, equipment, rating, businessEmail, longitude, latitude, description, username_FK)  
                VALUES (:businessTitle, :location, :address, :telephoneNum, :roomsAvailable, :equipment, :rating, :businessEmail, :longitude, :latitude,  :description, :username_FK)';
            $statement = $pdoObject->prepare($sql);
            $result = $statement->execute( array(    ':businessTitle'=>$hotelName,
                                               ':location'=>$location,
                                                  ':address'=>$address,
                                                  ':telephoneNum'=>$phoneNum,
                                                  ':roomsAvailable'=>$_POST['rooms'],
                                                  ':equipment'=>$equipment,
                                                  ':rating'=>$_POST['rating'],
                                                  ':businessEmail'=>$_POST['businessEmail'],
                                                  ':longitude'=>$_POST['longitude'],
                                                  ':latitude'=>$_POST['latitude'],
                                                  ':description'=>$_POST['description'],
                                                  ':username_FK'=>$_SESSION['username']   ) );
        }

        if ( $mode == 'update' ) {
           $sql = 'UPDATE hotels SET businessTitle =:businessTitle, location =:location, address =:address,
                telephoneNum =:telephoneNum, roomsAvailable =:roomsAvailable, equipment =:equipment, rating =:rating, businessEmail =:businessEmail,
                longitude =:longitude, latitude =:latitude, description =:description, username_FK =:username_FK
                WHERE hotelid =:hotelid' ;
            $statement = $pdoObject->prepare($sql);
            $result= $statement->execute( array(    ':businessTitle'=>$hotelName,
                                               ':location'=>$location,
                                                  ':address'=>$address,
                                                  ':telephoneNum'=>$phoneNum,
                                                  ':roomsAvailable'=>$_POST['rooms'],
                                                  ':equipment'=>$equipment,
                                                  ':rating'=>$_POST['rating'],
                                                  ':longitude'=>$_POST['longitude'],
                                                  ':latitude'=>$_POST['latitude'],
                                                  ':businessEmail'=>$_POST["businessEmail"],
                                                  ':description'=>$_POST['description'],
                                                  ':username_FK'=>$_SESSION['username'],   
                                                  ':hotelid'=>$_POST['hotelid']   ) );
        }
        $statement->closeCursor();
        $pdoObject = null;

    } catch ( PDOException $e ) {
        header('Location: reg-dualform.php?msg=PDO Exception: '.$e->getMessage());
        exit();
    }

    if ( $result==false ) { 
        header('Location: reg-dualform.php?msg=ERROR: failed to execute sql query');
        exit();
    } else { 
        $_SESSION['hotelid'] = $_POST['hotelid'];
        header('Location: user-page.php?msg=Επιτυχής καταχώρηση!');
        exit();
    }
?>