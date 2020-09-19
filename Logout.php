<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php 
        $_SESSION["USER_Id"] =null;
  		$_SESSION["Username"] =null;
        $_SESSION["AdminName"] =null;

        session_destroy();
        Redirect_to("Login.php");
?>