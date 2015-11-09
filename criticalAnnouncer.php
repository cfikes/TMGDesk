<?php session_start(); if(empty($_SESSION['name'])) { header("LOCATION: login.php"); } else { } ?>
<!DOCTYPE html>
<html>
    <head>
        <title>The Modern Group Helpdesk</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/uikit.almost-flat.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/uikit.docs.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/docs.css" rel="stylesheet" type="text/css"/>
        <link href="css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="uk-container-center uk-notouch">
        <h3><center>Lola is Announcing New Tickets</center></h3>
        <img src="img/criticalAnnouncer.jpg">
        
        <script src="js/jquery.js" type="text/javascript"></script>
        
        <script src="js/responsivevoice.js" type="text/javascript"></script>
        
        <script>
        function sayText(saytext){
            if (responsive.Voice.isPlaying()) { return; }
            if(responsiveVoice.voiceSupport(){
                responsiveVoice.speak(saytext,"US English Female");
            }
        }
        
        function pullCritical(){
            console.log("Checking for Tickets");
            var requestURL = "api.php?call=criticalannoncer";
            $.getJSON(requestURL, function(json) {
                $.each(json.tickets, function(i,ticket) {
                    if(typeof json.tickets !== 'undefined') {
                    var speakText = "New Critical Ticket! from " + ticket.FullName + ". Having " + ticket.IssueType + " issues. . .";
                    console.log(speakText);
                    sayText(speakText);
                    } else { console.log("No new critical tickets"); }
                });
            });
        }
        
        window.setInterval(function(){    
            pullCritical();
        }, 30000);
        </script>
     
    </body>