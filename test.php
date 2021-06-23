<style type="text/css">
    <?php require('style.css'); ?>
</style>

<main id="main">
            <div class="image-page">
                <div class="hotel-gallery">
                    <fieldset id="gallery-container">
                        <legend>Οι εικόνες σας</legend>
                        <?php
           
                            $fileArray= scandir('uploaded-pictures');
                            $filesInFolder= count($fileArray);
                            $imagesInRow = 0;
                            $closeDiv = false;
                            if ( $filesInFolder>2 ) {
                                for ($i=2; $i<=$filesInFolder-1;  $i++) {
                                    if (!is_dir('uploaded-pictures/'.$fileArray[$i])) {
                                        echo "  <div class=\"container\">
                                                <img class=\"image\" src=\"uploaded-pictures/$fileArray[$i]\"/>
                                                    <div class=\"overlay\">
                                                        <a href='delete.php?file=-------ΕΔΩ--------'>Del</a>
                                                        <a href='uploaded-pictures/$fileArray[$i]'>View</a>
                                                    </div>
                                                </div> ";
                                    }
                                }
                            } else {
                                echo '<p>-- Δεν έχετε ανεβάσει κάποια εικόνα ακόμα! --</p>';
                            }
                        ?>                       
                    </fieldset>

                </div>
                <div class="upload-form">
                    <fieldset>
                        <legend>Upload Image</legend>
                        <form class="form" name="upload-image" method="post" action="upload-image-action.php" enctype="multipart/form-data">
                            <label for="upload-image">Ανέβασε εικόνες του ξενοδοχείου</label><br><br>
                            <input type="hidden" name="MAX_FILE_SIZE" value="307200" />
                            <input type="file" name="imagefile" size="42"/>
                            <br><br>
                            <input class="btn" name="upload" type="submit" value="Upload"/>
                        </form>
                    </fieldset>
                </div>
  
            </div>

</main>