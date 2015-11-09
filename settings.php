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

                <!--<a class="uk-navbar-brand uk-hidden-small" href="../index.html">
                    <img class="uk-margin uk-margin-remove" src="img/DragonLogoHeaderSM.png" title="Dragon" alt="Dragon">
                </a>-->

                <ul class="uk-navbar-nav uk-hidden-small">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="ticketReports.php">Reports</a></li>
                    <li class="uk-active"><a href="settings.php">Settings</a></li>
                    <li><a onclick="window.open('criticalAnnouncer.php', '_blank', 'toolbar=no, scrollbars=no, resizable=no, top=100, left=100, width=300, height=322');">Critical Announcer</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="img/DragonLogoHeaderSM.png" height="15" title="Dragon" alt="Dragon"></div>
            </div>
        </nav>
        
        <div class="uk-container uk-container-center uk-margin-large-bottom">
            <h1>Settings</h1>
            <div class="uk-grid uk-margin uk-margin-right" id="mySettings">
                <form class="uk-form uk-form-horizontal" name="mySettingsForm" id="mySettingsForm">
                <h3>My Settings</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="myName">My Name</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="myName" readonly>
                    </div> 
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="myPassword">My Password</label>
                    <div class="uk-form-controls">
                        <input type="password" class="uk-form-width-large" id="myPassword" name="myPassword">
                    </div> 
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label"></label>
                    <div class="uk-form-controls">
                    <a class="uk-button uk-button-primary" id="saveMySettings">Save Password</a>
                    </div>
                </div>
                <input type="hidden" name="call" value="updatemysettings">
                </form>
            </div>
            <div class="uk-grid uk-margin uk-margin-right" id="settings">
                <form class="uk-form uk-form-horizontal" name="settingsForm" id="settingsForm">
                <h3>Basic Settings</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingName">Helpdesk Name</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="Name" name="Name" placeholder="Helpdesk Name">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingBaseURL">BaseURL</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="BaseURL" name="BaseURL" placeholder="http://helpdesk.local">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingCompany">Company Name</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="Company" name="Company" placeholder="Company Name">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingSupportE">Support Email</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="SupportE" name="SupportE" placeholder="Support Email">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingSupportT">Support Telephone</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="SupportT" name="SupportT" placeholder="Support Telephone">
                    </div>
                </div>
                <h3>SMTP Settings</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingSMTPServer">SMTP Server</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="SMTPServer" name="SMTPServer" placeholder="SMTP Server">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingSMTPUsername">SMTP Username</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="SMTPUsername" name="SMTPUsername" placeholder="SMTP Username">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingSMTPPassword">SMTP Password</label>
                    <div class="uk-form-controls">
                        <input type="password" class="uk-form-width-large" id="SMTPPassword" name="SMTPPassword" placeholder="SMTP Password">
                    </div>
                </div>
                <div class="uk-form-row">
                        <span class="uk-form-label">SMTP Port/Security</span>
                        <div class="uk-form-controls uk-form-controls-text">
                                <label for="settingSMTPPort">Port </label>
                                <input type="text" id="SMTPPort" name="SMTPPort" class="uk-form-width-mini uk-form-small uk-margin-right">
                                <label for="settingSMTPSecurity">Security Type </label>
                                <select class="uk-form-width-medium" id="SMTPSecurity" name="SMTPSecurity" class="uk-form-small">
                                        <option>none</option>
                                        <option>ssl</option>
                                        <option>tls</option>
                                </select>
                        </div>
                </div>
                <h3>Database Information</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingMYSQLServer">MySQL Server</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="MYSQLServer" name="MYSQLServer" placeholder="MySQL Server">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingMYSQLPort">MySQL Port</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="MYSQLPort" name="MYSQLPort" placeholder="MySql Port">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingMYSQLDatabase">MySQL Database</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="MYSQLDatabase" name="MYSQLDatabase" placeholder="MySQL Database">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingMYSQLUsername">MySQL Username</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="MYSQLUsername" name="MYSQLUsername" placeholder="MySQL Username">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingMYSQLPassword">MySQL Password</label>
                    <div class="uk-form-controls">
                        <input type="password" class="uk-form-width-large" id="MYSQLPassword" name="MYSQLPassword" placeholder="MySQL Password">
                    </div>
                </div>
                <h3>Critical Announcer</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="settingCriticalAnnouncer">Announcer Key</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-width-large" id="AnnouncerKey" name="AnnouncerKey" placeholder="Announcer Key">
                    </div>
                </div>
                <div class="uk-form-row">
                    <a class="uk-margin-top uk-button uk-button-primary uk-button-large uk-width-1-2" id="saveSettings">Save Changes</a>
                </div>
                </form>
            </div>
            <!-- END Grid -->
        </div>
    
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/upload.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <!-- Google Charts API -->
        <script src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
        <script src="js/settings.js"></script>
        
    </body>
    