<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php"); ?>
<?php require_once("INCLUDES/Sessions.php");  ?>
<?php 
if(isset($_GET["id"])){
	$SearchQueryPaarameter = $_GET["id"];
	global $ConnectingDB;
	$Admin = $_SESSION["FitAdminName"];
	$sql = "DELETE FROM admins WHERE id='$SearchQueryPaarameter'";
	$Execute = $ConnectingDB->query($sql);
    if($Execute)
    {
    	$_SESSION["SuccessMessage"] = "Admin Deleted Successfully !";
    	Redirect_to("Admins.php");
    }
    else
    {
    	$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
    	Redirect_to("Admins.php");
    }
}

?>