<?php
include 'functions.php';

$email = "chris.fikes@modernusa.com";
$ticketID = "987654321";

addEmailToQueue($email,"New Ticket Created",$ticketID);


