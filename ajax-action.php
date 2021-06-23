<?php 
	error_reporting(E_ALL);
	require('db-parameters.php');

	if ( !isset($_GET['val'],$_GET['ch']) ) {
		echo "ERROR: Missing data for AJAXcall";
		exit();
	}

	if ( $_GET['ch'] == 'e' ) {

		$email = $_GET['val'];
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        	$pdoObject -> exec('set names utf8');
			$pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

			$sql = 'SELECT email FROM users WHERE email LIKE :email';

			$statement = $pdoObject -> prepare($sql);
            $statement->execute( array(':email'=>$email));

			if ( $record = $statement -> fetch() ) {
				echo "Το email αυτό χρησιμοποιείται ήδη.";
			} else {
				echo "";
			}
		} else {
			echo  "Μη έγκυρο email.";
		}


	} elseif ( $_GET['ch'] == 'u' ) {
		$username = $_GET['val'];
		if ( !empty($username) ) {
			$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        	$pdoObject -> exec('set names utf8');
			$pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

			$sql = "SELECT username FROM users WHERE username=:username" ;

			$statement = $pdoObject -> prepare($sql);
            $statement->execute( array(':username'=>$username));
			$record = $statement -> fetch();
			$rows = $statement->rowCount();

			if ( $rows > 0 ) {
				echo "Το username αυτό χρησιμοποιείται ήδη.";
			} else {
				echo "";
			}
		} else echo "Το username είναι απαραίτητο πεδίο.";


	} else {
		echo "Μη αποδεκτή κλήση.";
		exit();
	}



?>