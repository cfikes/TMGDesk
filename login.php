<?php session_start(); if(empty($_SESSION['name'])) { } else { header("LOCATION: dashboard.php"); } ?>
<!DOCTYPE html>
<html lang="en-gb" dir="ltr" class="uk-height-1-1">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/uikit.almost-flat.min.css" />
        <link rel="stylesheet" href="css/components/notify.almost-flat.min.css" />
    </head>
    <body class="uk-height-1-1">
        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width: 250px;">             
                <form class="uk-panel uk-panel-box uk-form" name="loginform" id="loginform" action="api.php" method="POST">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" type="text" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" type="password" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="uk-form-row">
                        <a class="uk-width-1-1 uk-button uk-button-primary uk-button-large" id="btnLogin">Login</a>
                    </div>
                </form>    
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
        <script src="js/components/notify.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>