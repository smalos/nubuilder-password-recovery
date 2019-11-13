<?php
// core configuration
include_once "config/config.php";

// set page title
$page_title = "Forgot Password";

// include classes
include_once "config/database.php";
include_once 'user.php';
include_once "utils.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$utils = new Utils();

// include page header HTML
include_once "layout_head.php";

// if the login form was submitted
if ($_POST)
{

    echo "<div class='col-sm-12'>";

    // check if username and password are in the database
    $user->email = $_POST['email'];

    $id = $user->emailExists();

    if ($id != "")
    {

        // update access code for user
        $access_code = $utils->getToken();

        $user->access_code = $access_code;

        if ($user->insertAccessCode($id))
        {

            // send reset link
			$body = "Hello,<br /><br />";
            $body .= "You have requested a password reset. Please click the following link to reset your password:<br /> <br> ";
            $body .= "<a href={$home_url}reset_password.php/?access_code={$access_code}&id={$id}>Reset link</a>";
            $body .= "<br><br>Please note this link is only valid for the next hour. If you didn't request this email, please ignore it.<br /><br />Thank you.";

            $subject = "Reset Password";
            $send_to_email = $_POST['email'];

            if ($utils->send_mail($from_name, $from_email, $send_to_email, $subject, $body))
            {
                echo "<div class='alert alert-success'>
                            A password reset link was sent to your email.
                            Click that link to reset your password within 1 hour.
                        </div>";
            }

            // message if unable to send email for password reset link
            else
            {
                echo "<div class='alert alert-danger'>ERROR: Unable to send reset link.</div>";
            }
        }

        // message if unable to update access code
        else
        {
            echo "<div class='alert alert-danger'>ERROR: Unable to update access code.</div>";
        }

    }

    // message if email does not exist
    else
    {
        echo "<div class='alert alert-danger'>Your email cannot be found.</div>";
    }

    echo "</div>";
}
else
{
    echo "<div class='alert alert-info'>Forgot your Password? Please enter your email address. You will receive a link to reset your password.</div>";
}

// show reset password HTML form
echo "<div class='col-md-4'></div>";
echo "<div class='col-md-4'>";


echo "<div class='account-wall'>
        <div id='my-tab-content' class='tab-content'>
            <div class='tab-pane active' id='login'>
                <img class='profile-img' src='login-icon.png'>
                <form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
				<fieldset>
				<div class='form-group'>
				<div class='input-group'>
						
				<span class='input-group-addon'><i class='glyphicon glyphicon-envelope color-blue'></i></span>
                    <input type='email' name='email' class='form-control' placeholder='Your email' required autofocus>
				</div>
					  </div>
					  <div class='form-group'>
					  
				<input type='submit' class='btn btn-lg btn-primary btn-block' value='Send Reset Link' style='margin-top:1em;' />
				
				 </div>
					</fieldset>					
                </form>	
                </form>
            </div>
        </div>
    </div>";

echo "</div>";
echo "<div class='col-md-4'></div>";

// footer HTML and JavaScript codes
include_once "layout_foot.php";

?>
