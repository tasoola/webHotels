<?php 
    error_reporting(E_ALL);
    session_start(); 

    require('db-parameters.php');

    if ( $_GET['viewMode'] == 'search' ) {
        $viewMode = 'search';
    } elseif ( $_GET['viewMode'] == 'user' ) {
        $viewMode = 'user';
    } else {
        header("Location: search-page.php?msg=ModeError");
    }

    if ( !isset($_GET['srhotelid']) ) {
        header("Location: search-page.php?msg=Ανύπαρκτο ID.");
        exit();
    } else {
        $srhotelid = $_GET['srhotelid'];

        try {
            $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject -> exec('set names utf8');
            $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "SELECT * FROM hotels WHERE hotelid=:hotelid";
            $statement = $pdoObject -> prepare($sql);
            $statement->execute( array(':hotelid'=>$srhotelid));

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
            header('Location: search-page.php?msg=PDO Exception:'.$e->getMessage());
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

<script>
    
    function initMap() {
    
        const hotelposition = { lat: <?php echo $latitude; ?> , lng: <?php echo $longitude; ?> };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: hotelposition,
        });
        const marker = new google.maps.Marker({
            position: hotelposition,
            map: map,
        });
    }
</script>

<?php
  $title='webHotels | Hotel Info';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

    <main id="main">
        <div class="hotel-info-page-wrap" id="hotel-info-page-wrap">
        
            <div class="info-container">
                <?php if ( $viewMode == 'user' ) { ?>
                    <h1> <?php echo $hotelname; ?> <a href="reg-dualform.php"><img src="images/pencil.png" style="width:25px;"/></a></h1>
                <?php } else { ?>
                    <h1> <?php echo $hotelname; ?> </h1>
                <?php } ?>
                <h3> <?php echo $location; ?> - <?php echo $address; ?> </h3>
                <p> <?php echo $rating; ?> <img src="images/star.png" style="width:18px;"/> </p>
                <div class="descr-list">
                    <?php if ( $descr != "" ) { ?>
                        <div class="descr"> <p> <?php echo $descr ?> </p> </div>
                    <?php } ?>
                    <div class="list">
                        <h4> Το ξενοδοχείο διαθέτει: </h4>
                        <ul>
                        <?php foreach ( $equipments as $eq ) {
                            if( $eq == $equipment_ckecked[0] || $eq == $equipment_ckecked[1] || $eq == $equipment_ckecked[2] || 
                                $eq == $equipment_ckecked[3] || $eq == $equipment_ckecked[4]  ) { ?>
                                <li> <?php echo $eq ?> </li>
                        <?php } } ?>
                        </ul>
                    </div>
                </div>
                <div class="hotel-contact-info">
                    <h4> Contact Info </h4>
                    <ul>
                        <li> Τηλέφωνο: <?php echo $phoneNum ?> </li>
                        <li> Email: <?php echo $businessEmail ?> </li>
                    </ul>
                </div>
                <br><br>
                <div id="map"></div>
                <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1s2DFazZfgQmdoojea9ESn2ghuNgr79A&callback=initMap&libraries=&v=weekly"
                    async
                ></script>
                
            </div>

            <div class="gallery-container">
                <fieldset id="gallery-container">
                    <legend>Eικόνες</legend>
                    <?php
                        require('functions.php');
                        $fileArray= scandir('uploaded-pictures');
                        $filesInFolder= count($fileArray);
                        //print_r($fileArray);
                        if ( $filesInFolder>2 ) {
                            for ($i=2; $i<=$filesInFolder-1;  $i++) {
                                if (!is_dir('uploaded-pictures/'.$fileArray[$i])) {
                                    $descr = getImageDescr('uploaded-pictures/'.$fileArray[$i]);
                                    if ( $viewMode == 'user' ) {
                                        echo "  <div class=\"thumbnail-container\">
                                                <a href='uploaded-pictures/$fileArray[$i]'>
                                                    <img class=\"gallery-images\" src=\"uploaded-pictures/$fileArray[$i]\" alt=\"".$descr."\"/>
                                                </a> <br>
                                                <div class=\"overlay\">
                                                    <a href='del-image.php?file=uploaded-pictures/$fileArray[$i]'>
                                                        <img style=\"width:30px;\" src=\"images/delete.png\"/>
                                                    </a>".$descr."
                                                </div>
                                            </div>
                                            ";
                                    } else {
                                        echo "  <div class=\"thumbnail-container\">
                                                <a href='uploaded-pictures/$fileArray[$i]'>
                                                    <img class=\"gallery-images\" src=\"uploaded-pictures/$fileArray[$i]\" alt=\"".$descr."\"/>
                                                </a>
                                                <div class=\"overlay\">
                                                    ".$descr."
                                                </div> <br>
                                            </div>
                                            ";
                                    }
                                    
                                }
                            }
                        } else {
                            echo '<p>-- Δεν υπάρχουν ανεβασμένες εικόνες! --</p>';
                        }
                    ?>                        
                </fieldset>
            </div>

        </div>
    </main>

<?php require('footer.php'); ?>
