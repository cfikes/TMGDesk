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
    <body class="uk-container-center">
        
        <nav class="tm-navbar uk-navbar uk-navbar-attached">
            <div class="uk-container uk-container-center">

                <!--<a class="uk-navbar-brand uk-hidden-small" href="../index.html">
                    <img class="uk-margin uk-margin-remove" src="img/DragonLogoHeaderSM.png" title="Dragon" alt="Dragon">
                </a>-->

                <ul class="uk-navbar-nav uk-hidden-small">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li class="uk-active"><a href="ticketReports.php">Reports</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a onclick="window.open('criticalAnnouncer.php', '_blank', 'toolbar=no, scrollbars=no, resizable=no, top=100, left=100, width=300, height=322');">Critical Announcer</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="img/DragonLogoHeaderSM.png" height="15" title="Dragon" alt="Dragon"></div>
            </div>
        </nav>
        
        <div class="uk-container uk-container-center uk-margin-large-bottom">
            <h1>Ticket Reports</h1>
            <div class="uk-grid">
                <div class="uk-width-3-4">
                    <h3 id="reportTitle">Report Title</h3>
                    <table class="uk-table uk-table-striped" id="renderArea">
                        
                    </table>
                </div>
                <div class="uk-width-1-4" id="reports">
                    <div class="uk-panel uk-panel-box">

                        <h3 class="uk-panel-title">Pre-Fab Reports</h3>

                        <ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav="">
                            <li class="uk-nav-header">Tickets by Date</li>
                            <li><a report="week" class="btnReport"><i class="uk-icon-calendar"></i> This Week</a></li>
                            <li><a report="month" class="btnReport"><i class="uk-icon-calendar"></i> This Month</a></li>
                            <li><a report="year" class="btnReport"><i class="uk-icon-calendar"></i> This Year</a></li>
                            <li class="uk-nav-header">Tickets by Status</li>
                            <li><a report="unassigned" class="btnReport"><i class="uk-icon-star"></i> New Unassigned</a></li>
                            <li><a report="openassigned" class="btnReport"><i class="uk-icon-user"></i> Open and Assigned</a></li>
                            <li><a report="awaitingapproval" class="btnReport"><i class="uk-icon-thumbs-up"></i> Awaiting Approval</a></li>
                            <li><a report="awaitingparts" class="btnReport"><i class="uk-icon-cogs"></i> Awaiting Parts</a></li>
                            <li class="uk-nav-header">Tickets by Type</li>
                            <li><a report="configuration" class="btnReport"><i class="uk-icon-cog"></i> Configuration</a></li>
                            <li><a report="network" class="btnReport"><i class="uk-icon-cloud"></i> Internet/Network</a></li>
                            <li><a report="telephone" class="btnReport"><i class="uk-icon-phone"></i> Telephone</a></li>
                            <li><a report="printing" class="btnReport"><i class="uk-icon-print"></i> Printing</a></li>
                            <li><a report="newequipment" class="btnReport"><i class="uk-icon-tablet"></i> New Equipment</a></li>
                            <li class="uk-nav-header">Tickets by Severity</li>
                            <li><a report="critical" class="btnReport"><i class="uk-icon-exclamation-triangle"></i> Critical</a></li>
                            <li><a report="persistent" class="btnReport"><i class="uk-icon-exclamation-circle"></i> Persistent</a></li>
                            <li><a report="intermittent" class="btnReport"><i class="uk-icon-circle"></i> Intermittent</a></li>
                            <li><a report="inconvenient" class="btnReport"><i class="uk-icon-circle-o"></i> Inconvenient</a></li>
                            <li class="uk-nav-divider"></li>
                            <li class="uk-nav-header">Special Functions</li>
                            <li><a function="deleteticket" class="btnSpecial"  href="#deleteTicketModal" data-uk-modal><i class="uk-icon-bomb"></i> Delete Ticket</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Special Function Modals -->
        
        <!-- Delete Ticket Modal-->
        <div id="deleteTicketModal" class="uk-modal">
            <div class="uk-modal-dialog">
                <button type="button" class="uk-modal-close uk-close"></button>
                <div class="uk-modal-header">
                    <h2><i class="uk-icon-bomb"></i> DELETE TICKET AND HISTORY</h2>
                </div>
                <form class="uk-form">
                    <div class="uk-grid">
                        <div class="uk-width-3-4"><input type="text" placeholder="Ticket ID" class="uk-form-large uk-width-1-1" id="ticketIDforRemoval"></div>
                        <div class="uk-width-1-4"><input type="text" placeholder="Type 'YES'" class="uk-form-large uk-width-1-1" id="deleteVerify"></div>
                    </div>

                </form>
                <div class="uk-modal-footer uk-text-right">
                    <a class="uk-button uk-button-danger" id="bntDeleteTicket">DELETE</a>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        
        <script src="js/app.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/upload.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <script src="js/core/modal.min.js" type="text/javascript"></script>
        <script src="js/ticketReports.js"></script>
    </body>
</html>