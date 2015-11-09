<?php
include 'globalSettings.php';
include 'sendEmail.php';
include 'functions.php';
$idHelper =  time() . rand(100,199);

if (empty($_FILES['screenshot']['name'])) {
    $target_file = "NONE";
} else {
    $ext = end((explode(".", $_FILES['screenshot']['name'])));
    $target_dir = "screenshots/";
    $target_file = $target_dir . $idHelper . "." . $ext;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["screenshot"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        //echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["screenshot"]["size"] > 5000000) {
        //echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["screenshot"]["name"]). " has been uploaded.";
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    }
}

$ticketid = $idHelper;
$fullname = filter_input(INPUT_POST,'userFullName');
$telephone = filter_input(INPUT_POST,'userTelephone');
$email = filter_input(INPUT_POST,'userEmail');
$metawinuser = filter_input(INPUT_POST,'userWinUsername');
$metacomputer = filter_input(INPUT_POST,'userComputerName');
$metaremoteip = filter_input(INPUT_POST,'userRemoteIP');
$issuetype = filter_input(INPUT_POST,'issueType');
$severity = filter_input(INPUT_POST,'severity');
$issuedetails = filter_input(INPUT_POST,'issueDetails');
$screenshot = $target_file;
$userURL = $setting['BaseURL'] . "/myTicket.php?ticketid=" . $idHelper . "&email=" . $email;
$techURL = $setting['BaseURL'] . "/existingTicket.php?ticketid=" . $idHelper;
$emailSubject = "New Ticket Created";
$userEmailBody = '<h2>New Ticket Created</h2><p>You can access your ticket at <a href="' . $userURL . '">Ticket ' . $ticketid . '</a>.</p><p>The Modern Group Technicial Support Team</p>';
$emailAltBody = 'New Ticket Created';
$technicianEmailBody = '<h2>New Ticket Created</h2><p>You can access this ticket at <a href="' . $techURL . '">Ticket ' . $ticketid . '</a>.</p>';
$altBody = "New Ticket Created\n $email \n Ticket ID: $idHelper";
//Define Database Connection
$db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
//Check Connection
if (mysqli_connect_errno()) {
    $errorText = mysqli_connect_error();
    $error = ["error" => "$errorText"];
    print json_encode($error);
    exit();
}
$query0 = "INSERT INTO `tickets` (ticketid,fullname,telephone,email,metawinuser,metacomputer,metaremoteip,issuetype,severity,issuedetails,screenshot) VALUES (\"$ticketid\",\"$fullname\",\"$telephone\",\"$email\",\"$metawinuser\",\"$metacomputer\",\"$metaremoteip\",\"$issuetype\",\"$severity\",\"$issuedetails\",\"$screenshot\")";
$query1 = "INSERT INTO `notes` (noteid,ticketid,notevisibility,noteauthor,note) VALUES (\"$ticketid\",\"$ticketid\",\"Public\",\"System\",\"New Ticket Created\")";
if (mysqli_query($db, $query0)) {
    if (mysqli_query($db, $query1)) {
        //Send Email to User
        //sendEmail($email,$emailSubject,$userEmailBody,$altBody);
        addEmailToQueue($email,"New Ticket Created",$ticketid);
        ////Send Email to Technician
        //sendEmail($supportEmail,$emailSubject,$technicianEmailBody,$altBody);
        addEmailToQueue($setting['SupportE'],"New Ticket Created",$ticketid);
        $returnJSON = ["message" => "created"];
        print json_encode($returnJSON);
        exit();
    } else {
    $errorText = mysqli_error($db);
    $error = ["error" => "$errorText"];
    print json_encode($error);
    exit();
    }
    $returnJSON = ["message" => "success"];
    print json_encode($returnJSON);
    exit();
}