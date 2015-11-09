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
    <body class="uk-notouch uk-container-center">
        
        <nav class="tm-navbar uk-navbar uk-navbar-attached">
            <div class="uk-container uk-container-center">
                <ul class="uk-navbar-nav uk-hidden-small">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="ticketReports.php">Reports</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li class="uk-active"><a href="">Existing Ticket</a></li>
                </ul>
                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="img/DragonLogoHeaderSM.png" height="15" title="Dragon" alt="Dragon"></div>
            </div>
        </nav>

        <div class="uk-container uk-container-center uk-margin-large-bottom">
        
            <!-- BEGIN NEW TICKET -->
            <div class="uk-container" id="existingTicketContainer">
                <h1 class="uk-margin-top">Existing Ticket</h1>
                <div class="uk-grid">
                    <div class="uk-width-2-3">
                        <h3 class="uk-margin-top">Contact Information</h3>
                        <div class="uk-form-row">
                            <label class="uk-form-label" id="fullName">Full Name</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" id="telephone">Telephone Number</label>
                        </div>
                        <div class="uk-form-row margin-bottom">
                            <label class="uk-form-label" id="email">Email Address</label>
                        </div>
                        <br>
                        <h3 class="uk-margin-top">Issue</h3>
                        <div class="uk-form-row">
                            <label>Issue Type: </label>
                            <label id="issueType">Issue Type</label>
                        </div>
                        <div class="uk-form-row">
                            <label>Severity: </label>
                            <label id="severity">Severity</label>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-form-controls">
                                <a class="uk-button uk-button-primary uk-button-medium uk-width-1-4" id="viewScreenshot" href="#modalScreenshot" data-uk-modal>View Screenshot</a>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Details</label>
                            <div class="uk-form-controls">
                                <textarea id="issueDetails" name="issueDetails" class="uk-form uk-width-1-1" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <div class="uk-button-group uk-width-1-1">
                                <button class="uk-button" id="btnAssignTech">Assign Technician</button>
                                <button class="uk-button" id="btnChangeStatus">Change Status</button>
                            </div>
                        </div>
                        <h3 class="uk-margin-top">Meta Data</h3>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Windows User: </label>
                            <label class="uk-form-label" id="winUsername">chrisf</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Computer Name: </label>
                            <label class="uk-form-label" id="winComputername">TMGITDT</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Remote IP: </label>
                            <label class="uk-form-label" id="remoteIP">192.168.1.1</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Status: </label>
                            <label class="uk-form-label" id="status">Assigned</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Date Opened: </label>
                            <label class="uk-form-label" id="dateOpened">2015-05-01</label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Date Closed: </label>
                            <label class="uk-form-label" id="dateClosed"> </label>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label">Technician: </label>
                            <label class="uk-form-label" id="technician">Bob Dole</label>
                        </div>
                        <h3>Tags:</h3>
                        <div class="uk-form-row">
                           <label class="uk-form-label" id="tags">Outlook, Email, Signature, Configuration</label>
                        </div>
                    </div>
                    <div class="uk-width-1-1" id="ticketNotesFunctions">
                        <a class="uk-button uk-button-primary uk-width-1-6" id="btnNewNote">New Note</a>
                        <a class="uk-button uk-button-success uk-width-1-6" id="btnRemoteControl">Remote Control</a>
                        <a class="uk-button uk-button-danger uk-width-1-6" id="btnCloseTicket">Close Ticket</a>
                    </div>
                </div>  
                <div class="uk-grid" id="ticketNotes">
                    
                </div>
            </div>
        
        </div>

        <!-- Modals -->
        <!-- View Screenshot -->
        <!-- This is the modal -->
        <div id="modalScreenshot" class="uk-modal">
            <div class="uk-modal-dialog uk-modal-dialog-lightbox">
                <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
                <img class="uk-width-1-1" id="screenshot" src="">
            </div>
        </div>
        <!-- New Technician -->
        <div id="modalNewTechnician" class="uk-modal uk-open" aria-hidden="false">
            <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                            <h2>Assign New Technician</h2>
                    </div>
                    <p>
                        <select class="uk-form-large uk-width-1-1" id="listTechnicians">
                            <option>Unassigned</option>
                        </select>
                    </p>
                    <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="uk-button uk-button-primary" id="btnSaveTechnician">Save</button>
                    </div>
            </div>
        </div>
       <!-- New Status -->
        <div id="modalNewStatus" class="uk-modal uk-open" aria-hidden="false">
            <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                            <h2 id="newStatusTitle">Assign New Status</h2>
                    </div>
                    <p>
                        <select class="uk-form-large uk-width-1-1" id="listNewStatus">
                            <option>Awaiting Approval</option>
                            <option>Awaiting Parts</option>
                        </select>
                        <textarea id="newStatusNote" class="uk-form uk-width-1-1" rows="4" placeholder="Explain Status Change"></textarea>
                    </p>
                    <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="uk-button uk-button-primary" id="btnSaveNewStatus">Save</button>
                    </div>
            </div>
        </div>
        <!-- New Note -->
        <div id="modalNewNote" class="uk-modal uk-open" aria-hidden="false">
            <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                            <h2 id="newNoteTitle">New Note</h2>
                    </div>
                    <p>
                    <form id="newNoteForm"  method="POST">
                        <label class="uk-form-label">Note Visibility</label>
                        <select class="uk-form-large uk-width-1-1" id="listNoteVisibility">
                            <option>Public</option>
                            <option>Internal</option>
                        </select>
                        <textarea id="newNote" class="uk-form uk-width-1-1" rows="4" placeholder="Type Your Note"></textarea>
                        <input type="hidden" name="call" id="call" value="saveticketnote">
                    </form>
                    </p>
                    <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="uk-button uk-button-primary" id="btnSaveNewNote">Save</button>
                    </div>
            </div>
        </div>
        <!-- Remote Control -->
        <div id="modalRemoteControl" class="uk-modal uk-open" aria-hidden="false">
            <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                            <h2>Remote Control</h2>
                    </div>
                    <p>
                    <table class="uk-table" id="remoteControlTable">
                        
                    </table>
                    </p>
                    <div class="uk-modal-footer uk-text-right">
                        <p>Proper DNS resolution and firewall policies are required for links to function properly.</p>
                    </div>
            </div>
        </div>
        <!-- Close Ticket -->
        <div id="modalCloseTicket" class="uk-modal uk-open" aria-hidden="false">
            <div class="uk-modal-dialog">
                    <button type="button" class="uk-modal-close uk-close"></button>
                    <div class="uk-modal-header">
                            <h2 id="closeTicketTitle">Close Ticket</h2>
                    </div>
                    <p>
                    <form id="closeTicketForm"  method="POST">
                        <textarea id="closeNote" class="uk-form uk-width-1-1" rows="4" placeholder="Reason for Closure"></textarea>
                        <input type="hidden" name="call" id="call" value="combonote">
                    </form>
                    </p>
                    <div class="uk-modal-footer uk-text-right" id="closeTicketFooter">
                            <button type="button" class="uk-button uk-button-primary" id="btnSaveCloseTicket">Close Ticket</button>
                    </div>
            </div>
        </div>
        <script src="js/app.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/upload.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <script src="js/core/modal.min.js" type="text/javascript"></script>
        <script src="js/existingTicket.js" type="text/javascript"></script>
        
    </body>
</html>
 