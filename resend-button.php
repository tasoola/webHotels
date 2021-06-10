<?php
    require('functions.php');   
    $valCode = rand(10000,99999);
    session_start(); 
    $_SESSION['valCode'] = $valCode;
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    sendValMail($email, $username, $valCode);
    $sendTime = time();
    $_SESSION['sendTime'] = $sendTime;

?>