<?php require_once("INCLUDES/DB.php");?>
<?php
function Redirect_to($New_Location){
header("Location:".$New_Location);
exit;
}

// checking the Existence of user 
function CheckUserExistsOrNot($Username){
global $ConnectingDB ;
$sql = "SELECT username FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName',$Username);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1)
	{
		return true;
	}
else
  {
	return false;
   }
}
// end fo checking the existence of user

// Login attempt of user 
function Login_Attempt($Username,$Password){
global $ConnectingDB;
  	$sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
  	$stmt = $ConnectingDB->prepare($sql);
  	$stmt->bindValue(':userName',$Username);
  	$stmt->bindValue(':passWord', $Password);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
    	return $Found_Account=$stmt->fetch();
    }
    else
    {
    	return null;
    }
}
// end of login attempt of user 

// Confirm Login Function
function Confirm_Login(){
  if(isset($_SESSION["FitUSER_Id"])){
    return true;
  }
  else{
    $_SESSION["ErrorMessage"] = "Login Required";
    Redirect_to("Login.php");
  }
}
// end of confirm login function

// counting function for total posts dashboard page
function TotalPosts(){
                          global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $TotalRows = $stmt->fetch();
                        $TotalPosts = array_shift($TotalRows);
                        echo $TotalPosts;
}
// end of function for counting total posts 
// for blog page pagination post count 
function TotalBlogPosts(){
                          global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $TotalRows = $stmt->fetch();
                        $TotalPosts = array_shift($TotalRows);
                        return $TotalPosts;
}
// counting function for total categories dashboard page
function TotalCategories(){
  global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM category";
                        $stmt = $ConnectingDB->query($sql);
                        $TotalRows = $stmt->fetch();
                        $TotalCategories = array_shift($TotalRows);
                        echo $TotalCategories;
}
// end of function for counting total categories

// counting function for total admins dashboard page
function TotalAdmins(){
global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM admins";
                        $stmt = $ConnectingDB->query($sql);
                        $TotalRows = $stmt->fetch();
                        $TotalAdmins = array_shift($TotalRows);
                        echo $TotalAdmins;
}
// end of function for counting total admins

// counting function for total comments dashboard page
function TotalComments() {
  global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM comments";
                        $stmt = $ConnectingDB->query($sql);
                        $TotalRows = $stmt->fetch();
                        $TotalComment = array_shift($TotalRows);
                        echo $TotalComment;
}
// end of function for counting total comments

// Approve Comments according to posts
function ApproveCommentsAccordingtoPost($PostId){
  global $ConnectingDB;
                        $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
                        $stmtApprove = $ConnectingDB->query($sqlApprove);
                        $RowsTotal = $stmtApprove->fetch();
                        $Total = array_shift($RowsTotal);
                        return $Total;
}
// end of function for approve comments

// Disapprove Comments according to posts
function DisapproveCommentsAccordingtoPost($PostId){
                        global $ConnectingDB;
                        $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
                        $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
                        $RowsTotal = $stmtDisApprove->fetch();
                        $Total = array_shift($RowsTotal);
                        return $Total;
}
// end of function for disapprove comments
?>