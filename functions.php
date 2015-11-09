<?php

function addEmailToQueue($to,$message,$ticketID) {
    include 'globalSettings.php';
    date_default_timezone_set('America/Chicago');
    $dateHelper = date('Y-m-d h:i:s');
    $idHelper =  time() . rand(100,199);
    
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        exit();
    }
    //Helper Variables
    $idHelper =  time() . rand(100,199);
    
    //Build Query
    $query = "INSERT INTO `modernsupport`.`emailqueue` (`queueid`, `emailto`, `ticketid`, `message`, `emailsubject`, `messagesent`) VALUES ('$idHelper', '$to', '$ticketID', '$message', '$message', '0')";    
    if ($result = mysqli_query($db, $query)) {
        
    } else {
        print "SOMETHING HAS GONE WRONG";
    }
}

