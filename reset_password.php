<?php
// core configuration
include_once "config/config.php";

// set page title
$page_title = "Reset Password";

// include classes
include_once "config/database.php";
include_once "user.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);

// include page header HTML
include_once "layout_head.php";

echo "<div class='col-sm-12'>";

// get given access code
$access_code = isset($_GET['access_code']) ? $_GET['access_code'] : die("Access code not found.");
// get given id (nBuilder user id)
$id = isset($_GET['id']) ? $_GET['id'] : die("Id not found.");

// check if access code exists
$user->access_code = $access_code;

$id = $user->accessCodeExists();
if ($id == "")
{
    die('Access code not found or already used.');
}
else
{

    // if form was posted
    if ($_POST)
    {
        // set values to object properties
        $user->password = $_POST['password'];

        // reset password
        if ($user->updatePassword($id))
        {
            echo "<div class='alert alert-success'>Password successfully reset! Please <a href='{$login_url}'>login.</a></div>";

            $user->setAccessCodeUsed($access_code);
        }
        else
        {
            echo "<div class='alert alert-danger'>Unable to reset password.</div>";
        }
    }
    else
    {
        echo "<div  id='alert-info' class='alert alert-info'>Enter a new password and click the 'Reset Password' button.</div>";
    }

    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?access_code={$access_code}&id={$id}' method='post'>
	<div style='width: 100%; max-width: 600px; display: flex; height: 100vh; justify-content: center; margin-left:auto;margin-right:auto'>
    <table style='margin-top: 20px' class='table table-hover table-responsive table-bordered'>
        <tr >
            <td align='right' style='max-width:160px'>New Password</td>
            <td><input type='password' name='password' id='password' class='form-control' style='max-width:200px' required minLength=8 onkeyup='check()';></td>
        </tr>
		<tr >
            <td align='right' style='max-width:160px'>Confirm Password</td>
            <td><input type='password' name='confirm_password' id='confirm_password' class='form-control' style='max-width:200px;float:left' required minLength=8 onkeyup='check()';>  
			</td>			
		</tr>	
		 <tr>
            <td></td>
            <td><button id='submit' type='submit' class='btn btn-primary' disabled>Reset Password</button></td>
        </tr>
    </table></div>
	</form>";

}

echo "</div>";

?>


<script>
var check = function() {
	
  document.getElementById('alert-info').classList.remove("alert-info");
  var p = document.getElementById('password');
  var c = document.getElementById('confirm_password');  
  var a = document.getElementById('alert-info');
  if (p.value == c.value) {
	a.innerHTML = 'Passwords match.';
	a.classList.remove("alert-danger");
	a.classList.add("alert-success");	
	document.getElementById("submit").disabled = false;
  } else {
 	a.innerHTML = 'Passwords do not match.';
	a.classList.add("alert-danger");
	a.classList.remove("alert-success");
	document.getElementById("submit").disabled = true;

  }
}
</script> 

<?php

// include page footer HTML
include_once "layout_foot.php";

?>