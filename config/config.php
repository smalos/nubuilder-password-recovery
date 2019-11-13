<?php
// show error reporting
error_reporting(E_ALL);
 
// start php session
session_start();
 
// set your default time-zone
// date_default_timezone_set('Europe/London');

// your site name
$site_name = 'My nuBuilder Site';
 
// home login url (nuBuilder login page). 
$login_url = "https://localhost/html/nuBuilder4/";
 
// Password Recovery URL (where forgot_password.php is)
$home_url = "https://localhost/html/nuBuilder4/libs/password-recovery/";

// Send email from (used to send the reset link)
$from_name = "nuBuilder";
$from_email = "nuBuilder@yourdomain.com";
	

?>