<?php
error_reporting(0);
date_default_timezone_set('America/Chicago');
include 'functions.php';

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === 'POST') {
    $call = filter_input(INPUT_POST, "call");
}
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === 'GET') {
    $call = filter_input(INPUT_GET, "call");
}

function getUserName() {
    $userName = $SERVER['REMOTE_USER'];
    if(empty($userName)){
        $userName = "NotAvailable";
    }
    $returnJSON = ["username" => "$userName"];
    print json_encode($returnJSON);
}

function getComputerName() {
    $computerName = gethostbyaddr(filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
    if(empty($computerName)){
        $computerName = "NotAvailable";
    }
    $returnJSON = ["computername" => "$computerName"];
    print json_encode($returnJSON);
}

function getComputerIP() {
    $remoteIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    if(empty($remoteIP)){
        $remoteIP = "NotAvailable";
    }
    $returnJSON = ["remoteip" => "$remoteIP"];
    print json_encode($returnJSON);
}

function backgroundEmailer() {
    exec("wget http://localhost/tmgdesk/backgroundEmailer.php?sendMail=1 -O NULL");
}
function returnOldestTickets($count) {
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    if(empty($count)){ $count = 5; }
    $query = "SELECT `ticketid`,`dateopened`,`fullname`,`status` FROM `tickets` WHERE `status`!=\"Closed\" ORDER BY `dateopened` ASC LIMIT $count";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                //Loop Variable Assignments
                $ticketId = $row['0'];
                $dateOpened = $row['1'];
                $fullName = $row['2'];
                $status = $row['3'];
                //Append Array
                array_push($returnJSON["tickets"],["ID" => "$ticketId", "DateOpen" => "$dateOpened", "Creator" => "$fullName", "Status" => "$status"]);
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnNewestTickets($count) {
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    if(empty($count)){ $count = 5; }
    $query = "SELECT `ticketid`,`dateopened`,`fullname`,`status` FROM `tickets` WHERE `status`!=\"Closed\" ORDER BY `dateopened` DESC LIMIT $count";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                //Loop Variable Assignments
                $ticketId = $row['0'];
                $dateOpened = $row['1'];
                $fullName = $row['2'];
                $status = $row['3'];
                //Append Array
                array_push($returnJSON["tickets"],["ID" => "$ticketId", "DateOpen" => "$dateOpened", "Creator" => "$fullName", "Status" => "$status"]);
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnUnassignedTickets($count) {
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    if(empty($count)){ $count = 5; }
    $query = "SELECT `ticketid`,`dateopened`,`fullname`,`status` FROM `tickets` WHERE `status`=\"Unassigned\" ORDER BY `dateopened` DESC LIMIT $count";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                //Loop Variable Assignments
                $ticketId = $row['0'];
                $dateOpened = $row['1'];
                $fullName = $row['2'];
                $status = $row['3'];
                //Append Array
                array_push($returnJSON["tickets"],["ID" => "$ticketId", "DateOpen" => "$dateOpened", "Creator" => "$fullName", "Status" => "$status"]);
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnTicketDetails($ticketID){
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "SELECT * FROM `tickets` WHERE `ticketid`=\"" . $ticketID . "\"";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                $fullname = $row['1'];
                $email = $row['2'];
                $telephone = $row['3'];
                $issuetype = $row['4'];
                $severity = $row['6'];
                $issuedetails = $row['5'];
                $screenshot = $row['7'];
                $dateopened = $row['8'];
                $dateclosed = $row['9'];
                $status = $row['10'];
                $technician = $row['11'];
                $metawinuser = $row['12'];
                $metacomputer = $row['13'];
                $metaremoteip = $row['14'];
                $metatags = $row['15'];
                $resolutionnoteid = $row['16'];
                //Append Array
                $returnJSON = ["FullName" => "$fullname", "Telephone" => "$telephone", "Email" => "$email","IssueType" => "$issuetype","Severity" => "$severity","Details" => "$issuedetails","Screenshot" => "$screenshot","TicketID" => "$ticketID","DateOpened" => "$dateopened","DateClosed" => "$dateclosed","Status" => "$status","Technician" => "$technician","ResolutionNoteID" => "$resolutionnoteid","MetaWinUser" => "$metawinuser","MetaComputer" => "$metacomputer","MetaRemoteIP" => "$metaremoteip","MetaTags" => "$metatags"];
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnMyTicketDetails($ticketID,$email){
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "SELECT * FROM `tickets` WHERE `ticketid`=\"" . $ticketID . "\" AND `email`=\"" . $email . "\"";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                $fullname = $row['1'];
                $email = $row['2'];
                $telephone = $row['3'];
                $issuetype = $row['4'];
                $severity = $row['6'];
                $issuedetails = $row['5'];
                $screenshot = $row['7'];
                $dateopened = $row['8'];
                $dateclosed = $row['9'];
                $status = $row['10'];
                $technician = $row['11'];
                $metawinuser = $row['12'];
                $metacomputer = $row['13'];
                $metaremoteip = $row['14'];
                $metatags = $row['15'];
                $resolutionnoteid = $row['16'];
                //Append Array
                $returnJSON = ["FullName" => "$fullname", "Telephone" => "$telephone", "Email" => "$email","IssueType" => "$issuetype","Severity" => "$severity","Details" => "$issuedetails","Screenshot" => "$screenshot","TicketID" => "$ticketID","DateOpened" => "$dateopened","DateClosed" => "$dateclosed","Status" => "$status","Technician" => "$technician","ResolutionNoteID" => "$resolutionnoteid","MetaWinUser" => "$metawinuser","MetaComputer" => "$metacomputer","MetaRemoteIP" => "$metaremoteip","MetaTags" => "$metatags"];
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnTicketNotes($ticketID){
    session_start();
    include 'globalSettings.php';
    $returnJSON = ["Notes" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    
    if(!empty($_SESSION['name'])){
       $query = "SELECT * FROM `notes` WHERE `ticketid`=\"" . $ticketID . "\" ORDER BY `notedate` DESC";
    }
        
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                $noteid = $row['0'];
                $notedate = $row['2'];
                $note = $row['4'];
                $noteauthor = $row['5'];
                //Loop Variable Assignments
                array_push($returnJSON["Notes"],["NoteID" => "$noteid", "TicketID" => "$ticketID", "NoteDate" => "$notedate", "NoteAuthor" => "$noteauthor", "Note" => "$note"]);
            }
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function returnMyTicketNotes($ticketID,$email){
    include 'globalSettings.php';
    $returnJSON = ["Notes" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    
    //if(!empty($_SESSION['name'])){
    //   $query = "SELECT * FROM `notes` WHERE `ticketid`=\"" . $ticketID . "\" ORDER BY `notedate` DESC";
    //} else {
        $query = "SELECT * FROM notes INNER JOIN tickets ON notes.ticketid=tickets.ticketid WHERE notes.ticketid=\"" . $ticketID . "\" AND tickets.email=\"" . $email . "\" ORDER BY notes.notedate DESC";
    //}
        
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                $noteid = $row['0'];
                $notedate = $row['2'];
                $note = $row['4'];
                $noteauthor = $row['5'];
                //Loop Variable Assignments
                array_push($returnJSON["Notes"],["NoteID" => "$noteid", "TicketID" => "$ticketID", "NoteDate" => "$notedate", "NoteAuthor" => "$noteauthor", "Note" => "$note"]);
            }
            mysqli_free_result($result);
        }
        return ($returnJSON);
}


function returnNoteDetails($noteID){
    include 'globalSettings.php';
    $returnJSON = [];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "SELECT * FROM `notes` WHERE `noteid`=\"" . $noteID . "\" LIMIT 1";
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                $ticketid = $row['1'];
                $notedate = $row['2'];
                $visibility = $row['3'];
                $note = $row['4'];
                $noteauthor = $row['5'];
                //Loop Variable Assignments
                $returnJSON = ["NoteID" => "$noteID", "TicketID" => "$ticketid", "NoteDate" => "$notedate", "NoteAuthor" => "$noteauthor","NoteVisibility" => "$visibility", "Note" => "$note"];
            }
            mysqli_free_result($result);
        }
        return ($returnJSON);
}

function newTicketNote($ticketID,$visibility,$note,$noteauthor){
    include 'globalSettings.php';
    $idHelper =  time() . rand(100,199);
    $returnJSON = [];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "INSERT INTO `notes` (`noteid`,`ticketid`,`notevisibility`,`note`,`noteauthor`) VALUES (\"" . $idHelper . "\",\"" . $ticketID . "\",\"" . $visibility . "\",\"" . $note . "\",\"" . $noteauthor . "\")";
    if ($result = mysqli_query($db, $query)) {
        $returnJSON = ["Note" => "Saved"];
    } else { $returnJSON = ["Note" => "Not Saved"]; }
    return($returnJSON);
}

function newComboNote($ticketID,$visibility,$note,$noteauthor,$status){
    include 'globalSettings.php';
    $idHelper =  time() . rand(100,199);
    $returnJSON = [];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "INSERT INTO `notes` (`noteid`,`ticketid`,`notevisibility`,`note`,`noteauthor`) VALUES (\"" . $idHelper . "\",\"" . $ticketID . "\",\"" . $visibility . "\",\"" . $note . "\",\"" . $noteauthor . "\")";
    if ($result = mysqli_query($db, $query)) {
        $updateStatus = updateStatus($ticketID,$status);
        $returnJSON = ["Note" => "Saved"];
    } else { $returnJSON = ["Note" => "Not Saved"]; }
    return($returnJSON);
}

function closeTicket($ticketID,$visibility,$note,$noteauthor,$status,$email){
    include 'globalSettings.php';
    $idHelper =  time() . rand(100,199);   
    $dateHelper = date('Y-m-d H:i:s');
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query0 = "INSERT INTO `notes` (`noteid`,`ticketid`,`notevisibility`,`note`,`noteauthor`) VALUES (\"" . $idHelper . "\",\"" . $ticketID . "\",\"" . $visibility . "\",\"" . $note . "\",\"" . $noteauthor . "\")";
    if ($result = mysqli_query($db, $query0)) {
         $query1 = "UPDATE `tickets` SET `status`=\"" . $status . "\",`dateclosed`=\"" . $dateHelper . "\" WHERE `ticketid`=\"" . $ticketID . "\"";
        if ($result = mysqli_query($db, $query1)) {
            $returnJSON = ["Note" => "Saved"];
        }
    } else { $returnJSON = ["Note" => "Not Saved"]; }
    return($returnJSON);
}

function updateTechnician($ticketID,$technician) {
    include 'globalSettings.php';
    $returnJSON = [];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "UPDATE `tickets` SET `technician`=\"" . $technician . "\" WHERE `ticketid`=\"" . $ticketID . "\"";
    if ($result = mysqli_query($db, $query)) {
        $returnJSON = ["Tech" => "Saved"];
    } else { $returnJSON = ["Tech" => "Not Saved"]; }
    return($returnJSON);
}

function updateStatus($ticketID,$status) {
    include 'globalSettings.php';
    $returnJSON = [];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "UPDATE `tickets` SET `status`=\"" . $status . "\" WHERE `ticketid`=\"" . $ticketID . "\"";
    if ($result = mysqli_query($db, $query)) {
        $returnJSON = ["Status" => "Saved"];
    } else { $returnJSON = ["Status" => "Not Saved"]; }
    return($returnJSON);
}

function sendMail($ticketID,$userEmail,$mailType) {
    include 'globalSettings.php';
    $userURL = $setting['BaseURL'] . "/myTicket.php?ticketid=" . $ticketID . "&email=" . $userEmail;
    $techURL = $setting['BaseURL'] . "/existingTicket.php?ticketid=" . $ticketID;
    $supportEmail = $setting['SMTPUsername'];
    switch ($mailType) {
        case "closure":
            $emailSubject = "Ticket Closed";
            break;
        case "note":
            $emailSubject = "New Ticket Note";
            break;
        case "status":
            $emailSubject = "Ticket Status Change";
            break;
            
    }
    include 'sendEmail.php';
    $userEmailBody = '<h2>' . $emailSubject . '</h2><p>You can access your tickets history <a href="' . $userURL . '">Ticket ' . $ticketID . '</a>.</p><p>The Modern Group Technical Support Team</p>';
    $technicianEmailBody = '<h2>' . $emailSubject . '</h2><p>You can access this tickets history at <a href="' . $techURL . '">Ticket ' . $ticketID . '</a>.</p>';
    $altBody = "Ticket Closed\n $userEmail \n Ticket ID: $ticketID";
    /*
    //Send User Mail
    $sendEmail = sendEmail($userEmail,$emailSubject,$userEmailBody,$altBody);
    //Send Tech Mail
    $sendTechEmail = sendEmail($supportEmail,$emailSubject,$technicianEmailBody,$altBody);
    if($sendEmail === "Sent"){
        $returnJSON = ["Message" => "Sent"];
    } else if ($sendEmail === "Not Sent") {
        $returnJSON = ["Message" => "Not Sent"];
    } else {
        $returnJSON = ["Message" => "Unknown"];
    }
    return $returnJSON;
    */
    addEmailToQueue($userEmail,$emailSubject,$ticketID);
    ////Send Email to Technician
    addEmailToQueue($setting['SupportE'],$emailSubject,$ticketID);
    
}

function returnReport($reportName) {
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    //$query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity` FROM `tickets` WHERE `status`!=\"Closed\" AND  ORDER BY `dateopened`";
    switch ($reportName){
        case "day":
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE DAY(dateopened) = DAY(CURRENT_TIMESTAMP) AND YEAR(dateopened) = YEAR(CURRENT_TIMESTAMP) ORDER BY `dateopened`";
            break;
        case "week" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE WEEK(dateopened) = WEEK(CURRENT_TIMESTAMP) AND YEAR(dateopened) = YEAR(CURRENT_TIMESTAMP) ORDER BY `dateopened`";
            break;
        case "month" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE MONTH(dateopened) = MONTH(CURRENT_TIMESTAMP) AND YEAR(dateopened) = YEAR(CURRENT_TIMESTAMP) ORDER BY `dateopened`";
            break;
        case "year" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE YEAR(dateopened) = YEAR(CURRENT_TIMESTAMP) ORDER BY `dateopened`";
            break;
        case "unassigned" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `status`=\"Unassigned\" ORDER BY `dateopened`";
            break;
        case "openassigned" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `status`=\"Assigned\" ORDER BY `dateopened`";
            break;
        case "awaitingapproval" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `status`=\"Awaiting\ Approval\" ORDER BY `dateopened`";
            break;
        case "awaitingparts" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `status`=\"Awaiting\ Parts\" ORDER BY `dateopened`";
            break;
        case "configuration" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `issuetype`=\"Configuration\" ORDER BY `dateopened`";
            break;
        case "network" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `issuetype`=\"Internet/Network\" ORDER BY `dateopened`";
            break;
        case "telephone" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `issuetype`=\"Telephone\" ORDER BY `dateopened`";
            break;
        case "printing" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `issuetype`=\"Printing\" ORDER BY `dateopened`";
            break;
        case "newequipment" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `issuetype`=\"New\ Equipment\" ORDER BY `dateopened`";
            break;
        case "critical" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `severity`=\"Critical\" ORDER BY `dateopened`";
            break;
        case "persistent" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `severity`=\"Persistent\" ORDER BY `dateopened`";
            break;
        case "intermittent" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `severity`=\"Intermittent\" ORDER BY `dateopened`";
            break;
        case "inconvenient" :
            $query = "SELECT `ticketid`,`dateopened`,`fullname`,`technician`,`status`,`severity`,`issuetype` FROM `tickets` WHERE `severity`=\"Inconvenient\" ORDER BY `dateopened`";
            break;
    }
    
    
    if ($result = mysqli_query($db, $query)) {
            while ($row = mysqli_fetch_row($result)) {
                //Loop Variable Assignments
                $ticketId = $row['0'];
                $dateOpened = $row['1'];
                $fullName = $row['2'];
                $technician = $row['3'];
                $status = $row['4'];
                $severity = $row['5'];
                $issueType = $row['6'];
                //Append Array
                array_push($returnJSON["tickets"],["ID" => "$ticketId", "DateOpen" => "$dateOpened", "Creator" => "$fullName","Technician" => "$technician", "Status" => "$status","Severity" => "$severity","IssueType" => "$issueType"]);
            }
            //print json_encode($returnJSON);
            mysqli_free_result($result);
        }
        return ($returnJSON);
}
function returnSettings() {
    include 'globalSettings.php';
    $returnJSON = ["Name" => $setting['Name'],"BaseURL" => $setting['BaseURL'], "Company" => $setting['Company'],"SupportE" => $setting['SupportE'],"SupportT" => $setting['SupportT'],"SMTPServer" => $setting['SMTPServer'],"SMTPUsername" => $setting['SMTPUsername'],"SMTPPassword" => $setting['SMTPPassword'],"SMTPSecurity" => $setting['SMTPSecurity'],"SMTPPort" => $setting['SMTPPort'],"MYSQLServer" => $setting['MYSQLServer'],"MYSQLPort" => $setting['MYSQLPort'],"MYSQLDatabase" => $setting['MYSQLDatabase'],"MYSQLUsername" => $setting['MYSQLUsername'],"MYSQLPassword" => $setting['MYSQLPassword']];
    return($returnJSON);
}

function loginUser($username,$password) {
    include_once 'globalSettings.php';
    //Check User Key and Action Call
    if (empty($username) || empty($password)) {
        $returnJSON = ["session" => "invalid"];
    }
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
    }
    $query = "SELECT * FROM `technicians` WHERE email=\"" . $username . "\" AND password =\"" . $password . "\" LIMIT 1";
    if ($result = mysqli_query($db, $query)) {
        if(mysqli_num_rows($result)<1){
            $returnJSON = ["session" => "invalid"];
        } else {
            session_start();
            while ($row = mysqli_fetch_row($result)) {
                    //Loop Variable Assignments
                    $_SESSION['email'] = $row['0'];
                    $_SESSION['name'] = $row['1'];
                    $returnJSON = ["session" => "valid"];
            }
        }
    } else {
        $returnJSON = ["session" => "invalid"];
    }
    return($returnJSON);
}

function returnTechnicians(){
    include_once 'globalSettings.php';
    $returnJSON = ["Technicians" => []];
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
    }
    session_start();

    $query = "SELECT `name` FROM `technicians` ORDER BY `name`";
    if ($result = mysqli_query($db, $query)) {
        while ($row = mysqli_fetch_row($result)) {
            //Loop Variable Assignments                    
            $name = $row['0'];
            array_push($returnJSON["Technicians"],["name" => $name]);
        }
    } else {
        $returnJSON = ["session" => "invalid"];
    }
    return($returnJSON);
}

function returnMySettings() {
    include_once 'globalSettings.php';
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
    }
    session_start();
    $techName = str_replace(' ', '\\ ', $_SESSION['name']);
    $query = "SELECT * FROM `technicians` WHERE name=\"" . $techName . "\"  LIMIT 1";
    if ($result = mysqli_query($db, $query)) {
        if(mysqli_num_rows($result)<1){
            $returnJSON = ["session" => "invalid"];
        } else {
            while ($row = mysqli_fetch_row($result)) {
                    //Loop Variable Assignments                    
                    $name = $row['1'];
                    $returnJSON = ["Name" => "$name"];
            }
        }
    } else {
        $returnJSON = ["session" => "invalid"];
    }
    return($returnJSON);
}
function updateMySettings($password) {
    include_once 'globalSettings.php';
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']+0);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
    }
    session_start();
    $techName = str_replace(' ', '\\ ', $_SESSION['name']);
    $query = "UPDATE `technicians` SET `password`=\"" . $password . "\" WHERE name=\"" . $techName . "\"";
    if ($result = mysqli_query($db, $query)) {
        $returnJSON = ["Password" => "Updated"];
    } else {
        $returnJSON = ["session" => "invalid"];
    }
    return($returnJSON);
}

function addTechnician(){
    
}

function deleteTicket($ticketID){    
    include 'globalSettings.php';
    //Define Database Connection
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "DELETE FROM `tickets`,`notes` USING `tickets` INNER JOIN `notes` WHERE tickets.ticketid=\"" . $ticketID . "\" AND notes.ticketid=tickets.ticketid";
    if ($result = mysqli_query($db, $query)) {
        $returnJSON = ["Ticket" => "Deleted"];
    } else { $returnJSON = ["Ticket" => "Not Deleted"]; }
    return($returnJSON);
}

function criticalAnnouncer(){
    include 'globalSettings.php';
    $returnJSON = ["tickets" => []];
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "SELECT `fullname`,`issuetype` FROM `tickets` WHERE DAY(dateopened) = DAY(CURRENT_TIMESTAMP) AND HOUR(dateopened) = HOUR(CURRENT_TIMESTAMP) AND YEAR(dateopened) = YEAR(CURRENT_TIMESTAMP) AND `severity`=\"Critical\" AND `status`=\"Unassigned\" ORDER BY `dateopened`";
    //$query = "SELECT `fullname`,`issuetype` WHERE `severity`=\"Critical\" AND `dateopened` < (NOW() - INTERVAL 30 SECONDS)";
    if ($result = mysqli_query($db, $query)) {
        while ($row = mysqli_fetch_row($result)) {
            array_push($returnJSON['tickets'], ["FullName" => $row['0'], "IssueType" => $row['1']]);
        }
    } else { $returnJSON = ["Error" => "No New Tickets"]; }
    return ($returnJSON);
}

function voiceCountTickets($status) {
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "SELECT COUNT(*) FORM `tickets` WHERE `status`=\"" . $status . "\"";
    //$query = "SELECT `fullname`,`issuetype` WHERE `severity`=\"Critical\" AND `dateopened` < (NOW() - INTERVAL 30 SECONDS)";
    if ($result = mysqli_query($db, $query)) {
        while ($row = mysqli_fetch_row($result)) {
            $returnJSON = ["Count" => $row['0']];
        }
    } else {  $returnJSON = ["Error" => "nothing to count"]; }
    return($returnJSON);    
}

function logTicketAction($ticketID, $logMessage){
    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $returnJSON = ["error" => "$errorText"];
        //print json_encode($error);
        exit();
    }
    $query = "INSERT INTO `logs` (ticketid, message) VALUES ($ticketID, $logMessage)";
    if ($result = mysqli_query($db, $query)) {    }
}

switch ($call){
    case "username":
        getUserName();
        break;
    case "computername":
        getComputerName();
        break;
    case "remoteip":
        getComputerIP();
        break;
    case "oldest":
        $oldestTickets = returnOldestTickets(5);
        print json_encode($oldestTickets);
        break;
    case "newest":
        $newestTickets = returnNewestTickets(5);
        print json_encode($newestTickets);
        break;
    case "unassigned":
        $unassignedTickets = returnUnassignedTickets(5);
        print json_encode($unassignedTickets);
        break;
    case "details":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $ticketDetails = returnTicketDetails($ticketID);
        print json_encode($ticketDetails);
        break;
    case "myticketdetails":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $email = filter_input(INPUT_GET, "email");
        $myTicketDetails = returnMyTicketDetails($ticketID,$email);
        print json_encode($myTicketDetails);
        break;
    case "myticketnotes":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $email = filter_input(INPUT_GET, "email");
        $ticketNotes = returnMyTicketNotes($ticketID,$email);
        print json_encode($ticketNotes);
        break;
    case "note":
        $noteID = filter_input(INPUT_GET, "noteid");
        $noteDetails = returnNoteDetails($noteID);
        print json_encode($noteDetails);
        break;
    case "assign":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $technician = filter_input(INPUT_GET, "technician");
        $assignTechnician = updateTechnician($ticketID,$technician);
        print json_encode($assignTechnician);
        break;
    case "statuschange":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $status = filter_input(INPUT_GET, "status");
        $assignStatus = updateStatus($ticketID,$status);
        print json_encode($assignStatus);
        break;
    case "ticketnotes":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $ticketNotes = returnTicketNotes($ticketID);
        print json_encode($ticketNotes);
        break;
    case "saveticketnote":
        $ticketID = filter_input(INPUT_POST, "ticketid");
        $visibility = filter_input(INPUT_POST, "visibility");
        $note = filter_input(INPUT_POST,"note");
        $noteauthor = filter_input(INPUT_POST, "noteauthor");
        $ticketNote = newTicketNote($ticketID,$visibility,$note,$noteauthor);
        print json_encode($ticketNote);
        break;
    case "combonote":
        $ticketID = filter_input(INPUT_POST, "ticketid");
        $visibility = filter_input(INPUT_POST, "visibility");
        $note = filter_input(INPUT_POST,"note");
        $noteauthor = filter_input(INPUT_POST, "noteauthor");
        $status = filter_input(INPUT_POST, "status");
        $comboNote = newComboNote($ticketID,$visibility,$note,$noteauthor,$status);
        print json_encode($comboNote);
        break;
    case "closeticket":
        $ticketID = filter_input(INPUT_POST, "ticketid");
        $visibility = filter_input(INPUT_POST, "visibility");
        $note = filter_input(INPUT_POST,"note");
        $noteauthor = filter_input(INPUT_POST, "noteauthor");
        $status = filter_input(INPUT_POST, "status");
        $closeTicket = closeTicket($ticketID,$visibility,$note,$noteauthor,$status,$email);
        print json_encode($closeTicket);
        break;
    case "sendmail" :
        $ticketID = filter_input(INPUT_POST, "ticketid");
        $userEmail = filter_input(INPUT_POST, "email");
        $mailType = filter_input(INPUT_POST, "mailtype");
        $sendEmail = sendMail($ticketID, $userEmail,$mailType);
        print json_encode($sendEmail);
        break;
    case "report" : 
        $reportName = filter_input(INPUT_GET, 'reportname');
        $report = returnReport($reportName);
        print json_encode($report);
        break;
    case "adminsettings":
        session_start();
        if(empty($_SESSION['name'])){
            print '{"Error" : "Not Signed In"}';
        } else {
            $returnSettings = returnSettings();
            print json_encode($returnSettings);
        }
        break;
    case "login":
        $username = filter_input(INPUT_POST, 'username');
        $password = sha1(filter_input(INPUT_POST, 'password'));
        $validLogin = loginUser($username,$password);
        print json_encode($validLogin);
        break;
    case "mysettings":
        $mySettings = returnMySettings();
        print json_encode($mySettings);
        break;
    case "updatemysettings":
        $password = sha1(filter_input(INPUT_POST, 'myPassword'));
        $updateMySettings = updateMySettings($password);
        print json_encode($updateMySettings);
        break;
    case "technicians":
        $technicians = returnTechnicians();
        print json_encode($technicians);
        break;
    case "deleteticket":
        session_start();
        if(empty($_SESSION['name'])){
            print '{"Error" : "Not Signed In"}';
        } else {
        $ticketID = filter_input(INPUT_POST, "ticketid");
        $deleteTicket = deleteTicket($ticketID);
        print json_encode($deleteTicket);
        }
        break;
    case "criticalannoncer":
        $announcement = criticalAnnouncer();
        print json_encode($announcement);
        break;
    case "voicecountopentickets":
        session_start();
        if(empty($_SESSION['name'])){
            print '{"Error" : "Not Signed In"}';
        } else {
        $status = filter_input(INPUT_GET, "status");
        $countTickets = voiceCountTickets($status);
        print json_encode($countTickets);
        }
        break;
    case "log":
        $ticketID = filter_input(INPUT_GET, "ticketid");
        $message = filter_input(INPUT_GET, "message");
        $logEvent = logTicketAction($ticketID, $message);
        break;
    case "backgroundemailer":
        $backgroundEmailer = backgroundEmailer();
        break;
}
