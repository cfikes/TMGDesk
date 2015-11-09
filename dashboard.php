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
        
        <nav class="tm-navbar uk-navbar uk-navbar-attached">
            <div class="uk-container uk-container-center">

                <ul class="uk-navbar-nav uk-hidden-small">
                    <li class="uk-active"><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="ticketReports.php">Reports</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a onclick="window.open('criticalAnnouncer.php', '_blank', 'toolbar=no, scrollbars=no, resizable=no, top=100, left=100, width=300, height=322');">Critical Announcer</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="img/DragonLogoHeaderSM.png" height="15" title="Dragon" alt="Dragon"></div>
            </div>
        </nav>
        
        <div class="uk-container uk-container-center uk-margin-large-bottom">
            <h1>Dashboard</h1>
            <div class="uk-grid">
                <div class="uk-width-1-2">
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin" id="unassignedTickets">
                            <h3>Unassigned Tickets <a id="refreshUnassigned"><i class="uk-icon-retweet"></i></a></h3>
                            <table class="uk-table uk-table-hover" id="unassignedTicketsTable">
                                <thead><tr><th>Date Opened</th><th>User</th><th>Status</th></tr></thead>
                            </table>
                        </div>
                        <div class="uk-width-1-1 uk-margin" id="todayTickets">
                            <h3>Todays Tickets <a id="refreshToday"><i class="uk-icon-retweet"></i></a></h3>
                            <table class="uk-table uk-table-hover" id="todayTicketsTable">
                                <thead><tr><th>User</th><th>Status</th><th>Severity</th></tr></thead>
                            </table>
                        </div>
                        <div class="uk-width-1-1 uk-margin" id="oldestTickets">
                            <h3>Oldest Tickets <a id="refreshOldest"><i class="uk-icon-retweet"></i></a></h3>
                            <table class="uk-table uk-table-hover" id="oldestTicketsTable">
                                <thead><tr><th>Date Opened</th><th>User</th><th>Status</th></tr></thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div id="openTickets" style="width: 100%; height: 200px"></div>
                    <div id="closedTickets" style="width: 100%; height: 200px"></div>
                </div>
            </div>
        </div>
        
        <script src="js/app.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/upload.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <!-- Google Charts API -->
        <script src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
        <script src="js/dashboard.js"></script>

        
        
    </body>