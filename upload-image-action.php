<?php 
    session_start();
    function guid( $opt = false ){
        if( function_exists('com_create_guid') ){
            if( $opt ){ return com_create_guid(); }   
            else { return trim( com_create_guid(), '{}' ); } 
        } else {
            mt_srand( (double)microtime() * 10000 );  
            $charid = strtoupper( md5(uniqid(rand(), true)) ); 
            $hyphen = chr( 45 );
            $left_curly = $opt ? chr(123) : "";
            $right_curly = $opt ? chr(125) : "";
            $uuid = $left_curly
                . substr( $charid, 0, 8 ) . $hyphen
                . substr( $charid, 8, 4 ) . $hyphen
                . substr( $charid, 12, 4 ) . $hyphen
                . substr( $charid, 16, 4 ) . $hyphen
                . substr( $charid, 20, 12 )
                . $right_curly;
        return $uuid;
        }
    }



    if ( !isset($_FILES['imagefile']) || $_FILES['imagefile']['name']=='') {
        header('Location: upload-image.php?msg=Ελλιπή δεδομένα!');
        exit();
    } else $filename= $_FILES['imagefile']['name'];

    if ( $_FILES['imagefile']['type'] != 'image/jpeg' && $_FILES['imagefile']['type'] != 'image/jpg' ) {
        header('Location: upload-image.php?msg=Μη αποδεκτός τύπος αρχείου!');
        exit();
    }

    $max_size=307200;
    $size=filesize($_FILES['imagefile']['tmp_name']);
    if ( $size > $max_size ) {
        header('Location: upload-image.php?msg=ERROR: Το αρχείο είναι πολύ μεγάλο!');
        exit();
    }

    $ext = strtolower(substr($filename, -3));
    $new_filename = guid().'.'.$ext;
    
    $copy = copy($_FILES['imagefile']['tmp_name'], 'uploaded-pictures/'.$new_filename);



    //database actions
    require('db-parameters.php');
    $result = false;
    $imagePath = 'uploaded-pictures/'.$new_filename;
    $imageDescr = "";
    if( isset($_POST['image-descr']) ) {
        $imageDescr = $_POST['image-descr'];
    }

    try{
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject -> exec('set names utf8');
        $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $sql = 'INSERT INTO images (imageName, description, type, user_FK, hotel_FK) 
            VALUES (:imageName, :description, :type, :user_FK, :hotel_FK )';

        $statement = $pdoObject->prepare($sql);
        $result= $statement->execute( array( ':imageName'=>$imagePath, ':description'=>$imageDescr,
                                    ':type'=>$ext, ':user_FK'=>$_SESSION['username'] , ':hotel_FK'=>$_SESSION['hotelid'] ) );

        $statement->closeCursor();
        $pdoObject = null;
    } catch (PDOException $e) {
        echo "<script>alert('PDO Exception: '.$e->getMessage());</script>";
        exit();
    }

    if ( !$result || !$copy ) {
        header("Location: upload-image.php?msg=Failed to execute query.");
        exit();
    } else {
        header("Location: upload-image.php?msg=Επιτυχής καταχώρηση εικόνας!");
    }

    

?>