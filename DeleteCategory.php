<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php"); ?>
<?php require_once("INCLUDES/Sessions.php");  ?>
<?php 
if(isset($_GET["id"])){
    $SearchQueryPaarameter = $_GET["id"];
    global $ConnectingDB;
    $Admin = $_SESSION["FitAdminName"];
    $sql = "DELETE FROM category WHERE id='$SearchQueryPaarameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute)
    {
        $_SESSION["SuccessMessage"] = "Category Deleted Successfully !";
        Redirect_to("Categories.php");
    }
    else
    {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
        Redirect_to("Categories.php");
    }
}

?>