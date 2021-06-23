<?php session_start(); ?>

<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php
  $title='webHotels | Search for Hotels';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

    <main id="main">
        <div id="search-page-wrap" class="search-page-wrap">
            <div class="form-container" style="border-right: 2px solid #848383; padding-bottom:20px;" >
                <h1>Αναζήτηση Ξενοδοχείων</h1><br>
                <form class="form" id="search-form" name="search-form" action="search-page.php" method="get">
                    <label for="search-name">Ονομασία:</label>
                    <input type="text" name="search[name]" id="search-name" size="40" onfocus="highlightOn('search-name');" 
                        onblur="highlightOff('searchname');"/>
                    <br><br>
                    <label for="search-location">Τοποθεσία:</label>
                    <input type="text" name="search[location]" id="search-location" size="25" onfocus="highlightOn('search-location');" 
                        onblur="highlightOff('search-location');"/>
                    <br><br>
                    <label for="search-rating">Αστέρια:</label>
                    <input type="number" name="search[rating]" id="search-rating" size="5" onfocus="highlightOn('search-rating');" 
                        onblur="highlightOff('search-rating');"/>
                    <br><br>
                    <label for="sequipment">Διαθέσιμα στο ξενοδοχείο:</label><br>
                    <input type="checkbox" name="search[equipment][]" value="Πισίνα"/>
                    <label for="search-equipment"><span class="check">Πισίνα</span></label>&nbsp;&nbsp;
                    <input type="checkbox" name="search[equipment][]" value="Κινηματογράφος"/>
                    <label for="search-equipment"><span class="check"> Κινηματογράφος</span></label>&nbsp;&nbsp;
                    <input type="checkbox" name="search[equipment][]" value="Γυμναστήριο"/>
                    <label for="search-equipment"><span class="check">Γυμναστήριο</span></label>&nbsp;&nbsp;
                    <br>
                    <input type="checkbox" name="search[equipment][]" value="Εστιατόριο-Μπαρ"/>
                    <label for="search-equipment"><span class="check">Εστιατόριο - Μπαρ</span></label>&nbsp;&nbsp;
                    <input type="checkbox" name="search[equipment][]" value="Παιδικές Δραστηριότητες"/>
                    <label for="search-equipment"><span class="check">Παιδικές Δραστηριότητες</span></label>
                    <br><br>
                    <button type="submit" class="btn" name="submit-search">Αναζήτηση</button>
                </form>
            </div>

            <div class="results">
                <h1>Αποτελέσματα</h1><br>
                <?php
                    require("functions.php"); 
                    echo_msg(); 
                ?>
                <?php
                    $recordsPerPage = 5;
                    $record1 = null;
                    require('db-parameters.php');

                    if (isset($_GET['page']))   
                        $curPage = $_GET['page']; 
                    else                 
                        $curPage = 1;
                        $startIndex = ($curPage-1) * $recordsPerPage;
  
                    try {
      
                        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
                        $pdo -> exec('set names utf8');
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                        $emptySearch = false;
                        $query = "";
                        //echo $emptySearch;
                        if ( empty($_GET['search']['name']) && empty($_GET['search']['location']) 
                            && empty($_GET['search']['rating']) && empty($_GET['search']['equipment']) ) {
                                $emptySearch = true;
                        }
                        
                        if( !isset( $_GET['search'] ) || $emptySearch ) {

                            $sql = "SELECT COUNT(hotelid) as recCount FROM hotels";

                            $statement = $pdo->query($sql);
                            $record = $statement->fetch(PDO::FETCH_ASSOC);

                            $pages = ceil($record['recCount']/$recordsPerPage);  //ceil -> στογγύλεμα προς τα πάνω
                            $statement->closeCursor();  

                            $record=null;
                            $sql = "SELECT * FROM hotels LIMIT $startIndex, $recordsPerPage";
                            $statement = $pdo->query($sql);

                        } else {
                            

                            $queryCases = array( 'name', 'location', 'rating', 'equipment');
                            foreach ( $_GET['search'] as $k=>$v ) {
                                if ( !empty($v) ) {
                                    if ( in_array($k,$queryCases) ) {
                                        if ( !empty($query) ) {
                                            $query .= " AND ";
                                        }
                                    }

                                    switch($k) {
                                        case "name":
                                            $query .= "businessTitle LIKE '%".$v."%'";
                                            break;
                                        case "location":
                                            $query .= "location LIKE '%".$v."%'";
                                            break;
                                        case "rating":
                                            $query .= "rating = ".$v;
                                            break;
                                        case "equipment":
                                            $count = count($v);
                                            for( $i = 0; $i < $count; $i++ ){
                                                $query .= "equipment LIKE '%".$v[$i]."%'";
                                                if( $i != $count-1 ) {
                                                    $query .= " AND ";
                                                }
                                            }
                                            break;
                                    }
                                }
                            }
                            $sql1 = "SELECT COUNT(hotelid) as recCount FROM hotels WHERE ". $query;
                            $statement1 = $pdo->query($sql1);
                            $record1 = $statement1->fetch();


                            $sql = "SELECT * FROM hotels WHERE " . $query. " ORDER BY businessTitle DESC LIMIT ".$startIndex.", ".$recordsPerPage.";";
                            $statement = $pdo->query($sql);
                            //echo '<p class="result-message">Αποτελέσματα για: '.$query.'</p>';
                        }
                        
                        $noResult = false;
                        while ( $record = $statement->fetch(PDO::FETCH_ASSOC) ) { 
                            
                            if ( !empty($record['hotelid'] ) ) {
                                $noResult = true;
                                echo '<div class="result" id="result">
                                    <a href="hotel-info-page.php?viewMode=search&srhotelid='.$record['hotelid'].'">
                                        <h3> '.$record['businessTitle'] .'</h3> 
                                    </a>
                                        <p>'. $record['location'].' | '. $record['rating'].'<img src="images/star.png" style="width:15px"/> </p>  
                                </div>';
                            } 
                        }

                        if ( !$noResult ) { echo '<p class="result-message">~ Δεν βρέθηκαν αποτελέσματα.~</p>'; }

                        $pages = ceil($record1['recCount']/$recordsPerPage);
                        

                        $statement->closeCursor();
                        $pdo = null;
                    } catch (PDOException $e) {
                        print "Database Error: " . $e->getMessage() . "<br/>";
                        die();
                    }
                ?>
                
                <div class="pagination">
                    <p>
                        <?php 
                            
                            for ($i=1; $i<=$pages; $i++) {
                                if ($i!=$curPage) { ?>
                                    <a class="page-sel" href="search-page.php?page=<?php echo $i ?>&search[name]=<?php echo $_GET['search']['name'] ?>&search[location]=<?php echo $_GET['search']['location'] ?>&search[rating]=<?php echo $_GET['search']['rating'] ?>&search[equipment][]=<?php echo implode( ",", $_GET['search']['equipment']) ?>">
                                        <?php echo $i ?>
                                    </a>

                        <?php   
                                } else
                                    echo '<span class="selected-page">'.$i.'</span>&nbsp;';
                            } 
                        ?>
                    </p>
                </div>
            
            
            
            </div>



        </div>

    </main>

<?php require('footer.php'); ?>
