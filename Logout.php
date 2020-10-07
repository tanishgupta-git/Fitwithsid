<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php 
        $_SESSION["FitUSER_Id"] =null;
  		$_SESSION["FitUsername"] =null;
        $_SESSION["FitAdminName"]=null;

        session_destroy();
        Redirect_to("Login.php");
?>