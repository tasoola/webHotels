<?php 
    error_reporting(E_ALL);
    

    if ( isset($_GET['style'] ) ) {
        if ( $_GET['style'] == 'dark' ) {
            setcookie( "dark","dark",time()+86400*90 );
            header("Location: index.php");
        } elseif ( $_GET['style'] == 'light' ) {
            setcookie( "dark","dark",time()-3600 );
            header("Location: index.php");
        } else {
            header("Location: index.php?msg=Κατι Δεν παει καλα");
        }
    } else {
        header("Location: index.php?msg=Κατι Δεν παει καλα 2");
    }



?>