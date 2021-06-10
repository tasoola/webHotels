<?php session_start(); ?>

<style type="text/css">
    <?php require('style.css'); ?>
</style>

<?php
  $title='webHotels | Upload Image';
  require('header.php');
?>

<?php 
    if ( isset($_COOKIE['dark'] ) ) { ?>
        <style type="text/css">
            <?php require('style-dark.css'); ?>
        </style>
<?php } ?>

    <main id="main">

        <div class="form-container">
            <h1>Gallery</h1><br>
            <?php
                require("functions.php"); 
                echo_msg(); 
            ?>
            <div class="image-page" id="image-page">
                <div class="hotel-gallery">
                    <fieldset id="gallery-container">
                        <legend>Οι εικόνες σας</legend>
                        <?php
           
                            $fileArray= scandir('uploaded-pictures');
                            $filesInFolder= count($fileArray);
                            
                            if ( $filesInFolder>2 ) {
                                for ($i=2; $i<=$filesInFolder-1;  $i++) {
                                    if (!is_dir('uploaded-pictures/'.$fileArray[$i])) {
                                        $descr = getImageDescr('uploaded-pictures/'.$fileArray[$i]);
                                        echo "  <div class=\"thumbnail-container\">
                                                    <a href='uploaded-pictures/$fileArray[$i]'>
                                                        <img class=\"gallery-images\" src=\"uploaded-pictures/$fileArray[$i]\" alt=\"".$descr."\"/>
                                                    </a> <br>
                                                    <div class=\"overlay\">
                                                        <a href='del-image.php?file=uploaded-pictures/$fileArray[$i]'>
                                                            <img style=\"width:30px;\" src=\"images/delete.png\" onclick=\"confirm('Πρόκειται να διαγραφεί η φωτογραφία. Συνέχεια;')\"/>
                                                        </a>".$descr."
                                                    </div>
                                                </div>
                                                ";
                                    }
                                }
                            } else {
                                echo '<p>-- Δεν έχετε ανεβάσει κάποια εικόνα ακόμα! --</p>';
                            }
                        ?>                        
                    </fieldset>

                </div>
                <div class="upload-form">
                    <fieldset id="fieldset">
                        <legend>Upload Image</legend>
                        <form class="form" name="upload-image" id="upload-image" method="post" action="upload-image-action.php" enctype="multipart/form-data">
                            <label for="upload-image">Ανέβασε εικόνες του ξενοδοχείου</label><br><br>
                            <input type="hidden" name="MAX_FILE_SIZE" value="307200" />
                            <input type="file" name="imagefile" size="42"/>
                            <br><br>
                            <label for="image-descr">Περιγραφή</label>
                            <input type="text" name="image-descr" id="image-descr" size="50" maxlength="50"/>
                            <br><br>
                            <input class="btn" name="upload" type="submit" value="Upload"/>
                        </form>
                    </fieldset>
                </div>
  
            </div>          
        </div>

    </main>

<?php require('footer.php'); ?>