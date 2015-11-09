<?php
include 'globalSettings.php';
include 'sendEmail.php';

ob_start();
$ticketID = filter_input(INPUT_POST, "ticketid");
$userEmail = filter_input(INPUT_POST, "email");
$mailType = filter_input(INPUT_POST, "mailtype");
$userURL = $setting['BaseURL'] . "/myTicket.php?ticketid=" . $ticketID . "&email=" . $userEmail;
$techURL = $setting['BaseURL'] . "/existingTicket.php?ticketid=" . $ticketID;

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

$userEmailBody = '<h2>' . $emailSubject . '</h2><p>You can access your tickets history <a href="' . $userURL . '">Ticket ' . $ticketID . '</a>.</p><p>The Modern Group Technicial Support Team</p>';
$technicianEmailBody = '<h2>' . $emailSubject . '</h2><p>You can access this tickets history at <a href="' . $techURL . '">Ticket ' . $ticketID . '</a>.</p>';
$altBody = "Ticket Closed\n $userEmail \n Ticket ID: $ticketID";
//Send User Mail
sendEmail($userEmail,$emailSubject,$userEmailBody,$altBody);
//Send Tech Mail
sendEmail("chris.fikes@modernusa.com",$emailSubject,$technicianEmailBody,$altBody);
$returnJSON = ["Message" => "Sent"];
ob_end_clean();
print json_encode($returnJSON);
exit();