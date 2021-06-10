<?php
    
    function sendValMail($to, $username, $code) {

        $subject  = 'Welcome to webHotels!';
        $message  = '<html>
	<body style="margin:0; background-color: #f9813a; text-align:center; font-family:\'Trebuchet MS\', \'Lucida Sans Unicode\', \'Lucida Grande\', \'Lucida Sans\', Arial, sans-serif;">
		<h1 style="padding:20px; background-color: #1F2C9D; color:whitesmoke; height:50px;">
			Καλωσήρθες στο webHotels '.$username.'! 
		</h1>
		<br><br><br>
		<div style="height:250px; color:whitesmoke;">
			<p style="font-size:22px;">Ολοκλήρωσε την εγγραφή σου, βάζοντας τον παρακάτω κωδικό στην <a href="Project2021/validate-user.php">σελίδα</a> που ανακατευθύνθηκες.</p>
			<h2 style="font-size:26px font-weight:bold;">'.$code.'</h2>
		</div>
		<h1 style="background-color: #1F2C9D; color:whitesmoke; >
			<a href="Project2021/index.php" style="background-color: #1f2c9d; color: whitesmoke; text-decoration:none;" >webHotels</a>
		</h1>
	</body>
</html>';
        $headers  = 'From: webhotelsgreece@gmail.com' . "\r\n" .
                    'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
        if( mail($to, $subject, $message, $headers) )
			echo '<script>alert("Ένα email επιβεβαίωσης στάλθηκε στο email σου!");</script>';
        else
            echo '<script>alert("Το email επιβεβαίωσης δεν στάλθηκε!");</script>';
    }


	function randString($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));
	
		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return $key;
	}

	function echo_msg() {

		if (isset($_SESSION['msg'])) { 
		  echo '<p style="color:tomato; font-weight:lighter; font-size: 14px;">'.$_SESSION['msg'].'</p>';
		  unset($_SESSION['msg']);
		} elseif (isset($_GET['msg'])) { 
		  $sanitizedMsg= filter_var($_GET['msg'], FILTER_SANITIZE_STRING);
		  echo '<p style="color:tomato; font-weight:lighter; font-size: 14px;">'.$sanitizedMsg.'</p>';
		}
		  
	}

	function getImageDescr($file) {
		require('db-parameters.php');
    	try {
        	$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        	$pdoObject -> exec('set names utf8');

        	$sql = 'SELECT description FROM images WHERE imageName=:imageName';

        	$statement = $pdoObject->prepare($sql);
        	$statement->execute( array( ':imageName'=> $file )  );

			if ( $record = $statement -> fetch() ) {
				$result = true;
				$descr = $record['description'];
			} else  $result = false; 

        	$statement->closeCursor();
        	$pdoObject = null;

    	} catch (PDOException $e) {
        	echo 'PDO Exception: '.$e->getMessage();
    	}

		if ($result==true) {
			return $descr;
		} else {
			return -1;
		}
	}

?>