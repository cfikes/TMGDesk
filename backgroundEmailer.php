<?php

/* 
 * Background Emailer
 * Looks in Database for new emails to send, and sends them. Simple Right.
 */

if(filter_input(INPUT_GET, "sendMail")==="1"){ 
    include_once 'globalSettings.php';

    $db = mysqli_connect($setting['MYSQLServer'], $setting['MYSQLUsername'], $setting['MYSQLPassword'], $setting['MYSQLDatabase'],$setting['MYSQLPort']);
    //Check Connection
    if (mysqli_connect_errno()) {
        $errorText = mysqli_connect_error();
        $error = ["error" => "$errorText"];
        print json_encode($error);
        exit();
    }
    $query = "SELECT * FROM `emailqueue` WHERE `messagesent`=0 ORDER BY `dateopened`";
    if ($result = mysqli_query($db, $query)) {
        include_once 'sendEmail.php';
        while ($row = mysqli_fetch_row($result)) {
            $queueid = $row['0'];
            $emailto = $row['1'];
            $dateopened = $row['2'];
            $ticketid = $row['4'];
            $message = $row['5'];
            $emailsubject = $row['6'];
                       
            //Define Email Template
            $emailTemplate = '<!DOCTYPE html>
            <html>
            <head>
            <style>
                a {text-decoration:none;}
                a:hover {text-decoration:underline;}
                .afooter {color:#fff !important;}
                .afooter a {color:#fff !important;}
                table td {border-collapse:collapse;margin:0;padding:0;}
                    h1 { color:#fff; font-family:"Segoe UI Light","Segoe UI",Arial,sans-serif; font-size:38px; font-weight:100; line-height:38px; padding:0 0; }
                    td { color:#000; font-family:"Segoe UI",Arial,sans-serif; font-size:12px; padding:20px 0 10px; }
            </style>
            </head><body>

            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                     <td width="20" valign="middle" bgcolor="#00188f" >
                        &nbsp;
                     </td>
                     <td width="580" valign="middle" bgcolor="#00188f">				
                                    <h1>
                                    %TICKET_MESSAGE%
                                    </h1>
                     </td>
                     <td width="20" valign="middle" bgcolor="#00188f" >
                        &nbsp;
                     </td>
                </tr>
            </table>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="20">&nbsp;</td>
                    <td width="580" align="left" valign="top">
                                    <p>
                                            <strong>Ticket ID:</strong> %TICKET_ID%<br>
                                            <strong>Date Updated:</strong> %TICKET_DATE%</a>
                                    </p>

                                    <p>
                                    <strong><a href="' . $setting['BaseURL'] . '/myTicket.php?ticketid=' . '%TICKET_ID%&email=%TICKET_EMAIL%" style="color:#0044cc;">Click here View your ticket in the self service portal.</a></strong>
                                    </p>

                        <p>
                                    Using the helpdesk self service portal you can
                                    </p>
                                    <ul>
                                            <li>View Ticket Status and Assigned Technician</li>
                                            <li>View The Enclosed Screenshot</li>
                                            <li>Add, View and Reply to Technician Notes</li>
                                            <li>Close Ticket</li>
                                    </ul>



                    </td>
                    <td width="20">&nbsp;</td>
                </tr>
            </table>

            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                     <td width="20" valign="middle" bgcolor="#00188f" >
                        &nbsp;
                     </td>
                    <td width="480" colspan="2" align="left" valign="middle" bgcolor="#00188f" >
                        <p style="padding:0 0;">
                                    <span class="afooter">This message was sent from an unmonitored email address.<br>Please do not reply to this message.</span>
                                    </p>
                                    <p style="padding:0 0;">
                                    <span class="afooter">The Modern Group <br> 1655 Louisiana St,<br> Beaumont, TX 77701<br><br>IT Department | <a href="mailto:support@modernusa.com" style="color:#fff !important">support@modernusa.com</a> | 409.951.4060</span>
                                    </p>
                    </td>
                    <td width="120" colspan="2" align="right" valign="middle" bgcolor="#00188f">
                        &nbsp;
                    </td>
                     <td width="20" valign="middle" bgcolor="#00188f">
                        &nbsp;
                     </td>
                </tr>
            </table>
            </body></html>';

            $emailBody = str_replace("%TICKET_MESSAGE%", $message, $emailTemplate);
            $emailBody = str_replace("%TICKET_ID%", $ticketid, $emailBody);
            $emailBody = str_replace("%TICKET_EMAIL%", $emailto, $emailBody);
            $emailBody = str_replace("%TICKET_DATE%", $dateopened, $emailBody); 
            //include_once 'sendEmail.php';
            $returnStatus = sendEmail($emailto,$emailsubject,$emailBody ,$message);
            sleep(2);
            if ($returnStatus === "Sent") {
                $query1 = "UPDATE `emailqueue` SET `messagesent`=1 WHERE `queueid`=$queueid";
                if ($result = mysqli_query($db, $query1)) { }
            }
        }
        print "Mail Delivered"; 
    }
    
} else {
    print "No Mail To Send";
}


