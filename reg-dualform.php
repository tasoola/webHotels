<?php
    error_reporting(E_ALL);
    session_start(); 
?>

<?php
    require('db-parameters.php');
    // έλεγχος mode
    if( $_SESSION['mode'] == 'insert' ) { 
        $mode = 'insert';
        $title='webHotels | Καταχώρηση Ξενοδοχείου';
    } elseif( $_SESSION['mode'] == 'update' ) {
        $mode = 'update';
        $title='webHotels | Τροποποίηση Ξενοδοχείου';
    } else {
        header("Location: user-page.php?msg=Μη προβλεπόμενη κλήση σελίδας.");
        exit();
    }


    if ( $mode == 'insert' ) {
        $hotelname = '';
        $location = '';
        $address = '';
        $phoneNum = '';
        $rooms = null;
        $rating = null;
        $equipment_ckecked = array('','','','','');
        $equipments = array( 'Πισίνα','Εστιατόριο - Μπαρ','Κινηματογράφος','Γυμναστήριο','Παιδικές Δραστηριότητες' );
        $businessEmail = '';
        $latitude = null;
        $longitude = null;
        $descr='';
    } 

    // MODE == UPDATE
    if ( $mode == 'update' ) {
        $hotelid = $_SESSION['hotelid'];

        try {
            $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "SELECT * FROM hotels WHERE hotelid=:hotelid";
            $statement = $pdoObject -> prepare($sql);
            $statement->execute( array(':hotelid'=>$hotelid));

            if ( $record = $statement -> fetch() ) {
                $record_exists = true;

                $hotelname = $record['businessTitle'];
                $location = $record['location'];
                $address = $record['address'];
                $phoneNum = $record['telephoneNum'];
                $rooms = $record['roomsAvailable'];
                $rating = $record['rating'];
                $equipment_ckecked = array('','','','','');
                $check = explode(",", $record['equipment'] );
                $i = 0;
                foreach ( $check as $ec ) {
                    $equipment_ckecked[$i] = $ec; 
                    $i++;
                }


                $equipments = array( 'Πισίνα','Εστιατόριο - Μπαρ','Κινηματογράφος','Γυμναστήριο','Παιδικές Δραστηριότητες' );
                $businessEmail = $record['businessEmail'];
                $longitude = $record['longitude'];
                $latitude = $record['latitude'];
                $descr = $record['description'];
  
            } else $record_exists = false; 
            $statement->closeCursor();
            $pdoObject = null;
    
        } catch ( PDOException $e ) {
            header('Location: user-page.php?msg=PDO Exception:'.$e->getMessage());
            exit();
        }

        if (!$record_exists) {
            header('Location: user-page.php?msg=Record does not exist.');
            exit();
          
        }


    }


?>

<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php require('header.php'); ?>
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
                var hotelname = document.getElementByID("hotelname").value;
                if( !hotelname ) {
                    result = false;
                    alert("Η ονομασία επιχείρησης είναι υποχρεωτικό πεδίο.");
                }

                var location = document.getElementByID("location").value;
                if( !location ) {
                    result = false;
                    alert("Η τοποθεσία επιχείρησης είναι υποχρεωτικό πεδίο.");
                }

                var address = document.getElementByID("address").value;
                if( !address ) {
                    result = false;
                    alert("Η διεύθυνση επιχείρησης είναι υποχρεωτικό πεδίο.");
                }
                
                var phoneNum = document.getElementById("phoneNum").value;
                if( !phoneNum ) {
                    result = false;
                    alert("Το τηλέφωνο είναι υποχρεωτικό πεδίο.");
                }

                var nonDigits = /\D/;
                if( phoneNum.length > 15 || phoneNum.length < 0 || nonDigits.test(phoneNum) ) {
                    result = false;
                    alert("Μη έγκυρος αριθμός τηλεφώνου.");
                }

                var rooms = document.getElementById("rooms").value;
                if( nonDigits.test(rooms) ) {
                    result = false;
                    alert("Μη έγκυρος αριθμός δωματίων.");
                }

                var rating = document.getElementById("rating").value;
                if( nonDigits.test(rating) && ( rating.length > 5 || rating.length < 0 ) ) {
                    result = false;
                    alert("Μη έγκυρη βαθμολογία ξενοδοχείου.");
                }

                var longitude = document.getElementById("longitude").value;
                var latitude = document.getElementById("latitude").value;
                if ( longitude > 180 || longitude < -180 ) {
                    if ( latitude > 90 || latitude < -90 ) {
                        result = false;
                        alert("Μη έγκυρες συντεταγμένες");
                    }
                }

                var descr = document.getElementById("description").value;
                if ( descr.length > 500 ) {
                    result = false;
                    alert("H περιγραφή είναι πολύ μεγάλη. Επιτρεπτό όριο: 500 χαρακτήρες.");
                }

                return result;
            }
        </script>



        <div id="dualform-wrap" class="form-container">
            <?php if( $mode == 'insert' ) { ?>
                <h1>Καταχώρηση Ξενοδοχείου</h1>
            <?php } elseif ($mode == 'update') { ?>
                <h1>Τροποποίηση Ξενοδοχείου</h1>
            <?php } ?>
            <br><br>
            <?php
                require("functions.php"); 
                echo_msg(); 
            ?>
            
            <p style="margin: 0 0 0 25px; font-size:14px">Τα πεδία με * είναι υποχρεωτικά</p>
            <form class="form" id="register-hotel-form" name="register-hotel-form" action="reg-hotel-action.php" method="post" onsubmit="return validate_form();">
                <label for="hotelname">Ονομασία Επιχείρησης *</label>
                <br>
                <input type="text" placeholder="Εισάγετε ονομασία επιχείρησης" name="hotelname" id="hotelname" size="50" 
                    value="<?php echo $hotelname;?>" onfocus="highlightOn('hotelname');" onblur="highlightOff('hotelname');"/>
                <br><br>

                <label for="location">Τοποθεσία *</label>
                <br>
                <input type="text" placeholder="Εισάγετε περιοχή επιχείρησης" name="location" id="location" size="50" 
                    value="<?php echo $location;?>" onfocus="highlightOn('location');" onblur="highlightOff('location');"/>
                <br><br>

                <label for="address">Διέυθυνση *</label>
                <br>
                <input type="text" placeholder="Εισάγετε τη διεύθυνση επιχείρησης" name="address" id="address" size="50" 
                    value="<?php echo $address;?>" onfocus="highlightOn('address');" onblur="highlightOff('address');"/>
                <br><br>

                <label for="phoneNum">Τηλέφωνο *</label>
                <br>
                <input type="text" placeholder="Εισάγετε τηλέφωνο επιχείρησης" name="phoneNum" id="phoneNum" size="30" maxlength="15"
                    value="<?php echo $phoneNum;?>" onfocus="highlightOn('phoneNum');" onblur="highlightOff('phoneNum');"/>
                <br><br>

                <label for="rooms">Αριθμός δωματίων</label>
                <br>
                <input type="number" placeholder="Δωμάτια" name="rooms" id="rooms" size="10" 
                    value="<?php echo $rooms; ?>" onfocus="highlightOn('rooms');" onblur="highlightOff('rooms');"/>
                <br><br>

                <label for="rating">Βαθμολογία</label>
                <br>
                <input type="number" placeholder="Αστέρια" name="rating" id="rating" size="10" 
                    value="<?php echo $rating;?>" onfocus="highlightOn('rating');" onblur="highlightOff('rating');"/>
                <br><br>

                <label for="equipment">Το ξενοδοχείο διαθέτει:</label>
                <br>
                <?php foreach ( $equipments as $eq ) {
                    if( $eq == $equipment_ckecked[0] || $eq == $equipment_ckecked[1] || $eq == $equipment_ckecked[2] || 
                        $eq == $equipment_ckecked[3] || $eq == $equipment_ckecked[4]  ) { ?>
                        <input checked="checked" type="checkbox" name="equipment[]" value="<?php echo $eq; ?>"/>
                        <label for="equipment"> <span class="check"><?php echo $eq; ?></span> </label>
                    <?php } else { ?>
                        <input type="checkbox" name="equipment[]" value="<?php echo $eq; ?>"/>
                        <label for="equipment"> <span class="check"><?php echo $eq; ?></span> </label>
                    <?php } } ?>
                
                <br><br>
                <label for="businessEmail">Email Επιχείρησης</label>
                <br>
                <input type="email" placeholder="Εισάγετε email επιχείρησης" name="businessEmail" id="businessEmail" size="50" 
                    value="<?php echo $businessEmail;?>" onfocus="highlightOn('businessEmail');" onblur="highlightOff('businessEmail');"/>
                <br><br>

                <label for="coordinates">Συντεταγμένες Επιχείρησης</label>
                <br>
                <input type="number" step="0.000001" placeholder="Γεωγραφικό πλάτος" name="latitude" id="latitude" size="20" 
                    value="<?php echo $latitude;?>" onfocus="highlightOn('latitude');" onblur="highlightOff('latitude');"/>
                <input type="number" step="0.000001" placeholder="Γεωγραφικό μήκος" name="longitude" id="longitude" size="20" 
                    value="<?php echo $longitude;?>" onfocus="highlightOn('longitude');" onblur="highlightOff('longitude');"/>
                <br><br>
                

                <label for="description">Περιγραφή</label>
                <br>
                <textarea rows=10 cols=45 name="description" id="description" form="register-hotel-form"
                    placeholder="Γράψε μία περιγραφή για το ξενοδοχείο σου"><?php echo $descr;?></textarea>
                <br><br>

                <?php if ( $mode == 'update' ) { ?>
                    <p>Κωδικός: <input name="hotelid" value="<?php echo $hotelid; ?>" readonly="readonly" /></p>
                <?php } ?>

                <input type="submit" class="btn" value="Καταχώρηση"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" class="btn" value="Επαναφορά"/>
        
            </form>

        </div>


    </main>
<?php require('footer.php'); ?>