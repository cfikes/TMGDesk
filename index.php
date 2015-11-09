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
        
        <nav class="tm-navbar uk-navbar uk-navbar-attached uk-notouch">
            <div class="uk-container uk-container-center">

                <!--<a class="uk-navbar-brand uk-hidden-small" href="../index.html">
                    <img class="uk-margin uk-margin-remove" src="img/DragonLogoHeaderSM.png" title="Dragon" alt="Dragon">
                </a>-->

                <ul class="uk-navbar-nav uk-hidden-small">
                    <li class="uk-active"><a href="index.php">Create New Ticket</a></li>
                    <li><a href="login.php">Technician Login</a></li>
                </ul>
                <a href="#tm-offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img src="img/DragonLogoHeaderSM.png" height="15" title="Dragon" alt="Dragon"></div>
            </div>
        </nav>

        <div class="uk-container uk-container-center uk-margin-large-bottom">
        
            <!-- BEGIN NEW TICKET -->
            <div class="uk-container" id="newTicketContainer">
                <h1 class="uk-margin-top">New Ticket</h1>                                                                 
                <form class="uk-form uk-form-horizontal uk-margin" id="newTicketForm"  method="POST" enctype="multipart/form-data">
                    <fieldset data-uk-margin>
                        <h3 class="uk-margin-top">Contact Information</h3>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Full Name</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" id="userFullName" name="userFullName" placeholder="Ex: John Doe">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Telephone Number</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" id="userTelephone" name="userTelephone" placeholder="Ex: 4099514060">
                            </div>
                        </div>
                        <div class="uk-form-row margin-bottom">
                            <label class="uk-form-label" for="">Email Address</label>
                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" id="userEmail" name="userEmail" placeholder="Ex: John.Doe@modernusa.com">
                            </div>
                        </div>
                        <br>
                        <h3 class="uk-margin-top">Issue</h3>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Issue Summary</label>
                                <label for="issueType"></label>
                                <select class="uk-margin-left" name="issueType" id="issueType" class="uk-form">
                                    <option selected disabled>Please Select an Option</option>
                                    <option>Configuration</option>
                                    <option>Internet/Network</option>
                                    <option>Telephone</option>
                                    <option>Printing</option>
                                    <option>New Equipment</option>
                                </select>
                                <label for="severity">&nbsp;&nbsp;Severity</label>
                                <select class="uk-margin-left" name="severity" id="severity" class="uk-form">
                                    <option selected disabled>Please Select an Option</option>
                                    <option>Inconvenient</option>
                                    <option>Intermittent</option>
                                    <option>Persistent</option>
                                    <option>Critical</option>
                                </select>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">Details</label>
                            <div class="uk-form-controls">
                                <textarea id="issueDetails" name="issueDetails" class="uk-form uk-width-1-1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="">File/Screenshot Upload</label>
                            <div class="uk-form-controls uk-margin-top">
                                <input class="uk-form-button" name="screenshot" id="screenshot" accept="image/jpeg" type="file">
                                <!--<a id="screenshotHelp">How to Take a Screenshot</a>-->
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-form-controls uk-margin-top">
                                <div class="uk-progress uk-progress-striped uk-active">
                                    <div class="uk-progress-bar" id="fileProgress" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="userWinUsername" id="userWinUsername" value="">
                        <input type="hidden" name="userComputerName" id="userComputerName" value="">
                        <input type="hidden" name="userRemoteIP" id="userRemoteIP" value="">
                        <div class="uk-form-row">
                            <div class="uk-margin-top">
                                <a id="btnCreateTicket" name="btnCreateTicket" class="uk-button uk-button-primary uk-button-large uk-width-1-4">Create Ticket</a>
                            </div>
                        </div>
                    </fieldset>                   
                </form>        
            </div>
    
        </div>
        <script src="js/app.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/upload.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <script src="js/newTicket.js" type="text/javascript"></script>
    </body>
</html>
 