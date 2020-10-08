<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php  
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 
?> 
<?php
  if(isset($_POST["submit"])){
     $PostTitle=$_POST["Title"];
     $Category = $_POST["Category"];
     $Image = $_FILES["Image"]["name"];
     $Target = "UPLOAD/".basename($_FILES["Image"]["name"]);
     $PostText = $_POST["Post"];
     $Admin=$_SESSION["FitUsername"];
     date_default_timezone_set("Asia/Kolkata");
      $CurrentTime=time();
       $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


     if(empty($PostTitle)){
     	$_SESSION["ErrorMessage"] = "Title Can't be empty";
        Redirect_to("AddNewPost.php");
       
       }elseif (strlen($PostTitle)<5) {  
         $_SESSION["ErrorMessage"] = "Post title should be greater than 5 characters";
        Redirect_to("AddNewPost.php");
       }elseif (strlen($PostText)>9999) {  
         $_SESSION["ErrorMessage"] = "Post description should be less than 10000 characters";
        Redirect_to("AddNewPost.php");
       }else{
       	// Query to insert post in db when everyting is fine
       	global $ConnectingDB;
       	$sql="INSERT INTO posts(datetime,title,category,author,image,post)";
       	$sql .="VALUES(:dateTime,:PostTitle,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt= $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':PostTitle',$PostTitle);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':imageName',$Image);
        $stmt->bindValue(':postDescription',$PostText);
        $Execute=$stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute)
        {
        	$_SESSION["SuccessMessage"]="Post with id: ".$ConnectingDB->lastInsertId()."Added Successfully";
        	Redirect_to("AddNewPost.php");
        }else{
        	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
        	Redirect_to("AddNewPost.php");
        }

       }
} //Ending of Submit Button if-condition

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script src="https://kit.fontawesome.com/9dd2d32fa7.js" crossorigin="anonymous"></script>
   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+HK&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/basicadmindesign.css">
       <link rel="stylesheet" type="text/css" href="css/privateonlyadmin.css">
	<title>Add New Post</title>
</head>
<body>
   <!-- navbar for small screen only -->
    <div class="mobile-screen-only">
        <a href="#"><img class="logo" src="logoandproimage/logosmall.png"></a>
          <button class="click-show"><i class="fas fa-bars fa-2x"></i></button>
    </div>
    <!-- end of navbar for small screen only -->
    <div class="wrapper">
    <!-- NAVBAR -->
      <div class="nav-parent">
        <nav>
         <a href="#"><img class="logo" src="logoandproimage/logosmall.png"></a>
          <button class="click-hide"><i class="fas fa-times fa-2x"></i></button><br>
       <p class="li-clone">Features</p> 
       <ul>  
            <li>
            <a href="Dashboard.php"><i class="fas fa-cog"></i> Dashboard</a>
          </li>
          <li>
            <a href="Posts.php"><i class="fab fa-readme"></i> Posts</a>
          </li>
          <li>
            <a href="Categories.php"><i class="fas fa-folder"></i> Categories</a>
          </li>
          <li>
            <a href="Admins.php"><i class="fas fa-users"></i> Manage Admins</a>
          </li>
          <li>
            <a href="Comments.php"><i class="fas fa-comments"></i> Comments</a>
          </li>
          <li>
            <a href="Blog.php?page=1"><i class="fas fa-blog"></i> Live Blog</a>
          </li>
            <li>
               <a href="Logout.php" ><i class="fas fa-user-times"></i> Logout</a>
           </li>
       </ul>    
     </nav>
  </div>
<!----- end of navbar -->
<!-- header start -->
<div class="main-area">
<header>
<p class="page-define"><i class="fa fa-edit"></i> Add New Post</p>
</header>
<!-- end of header -->
<!-- main area -->
<section>
   <?php 
       echo ErrorMessage();
       echo SuccessMessage();
        ?>
  <div class="sub-all-area">
    <!-- left side area start -->
    <div class="edit-form-container">
        <div class="form-container">
      <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
               <div class="admin-input">
                 <label for="title">Post Title:</label>
                  <input type="text" name="Title" id="title" placeholder="type title here">
                </div>
                <div class="admin-input">
                 <label for="CategoryTitle"> Choose Category</label>
                  <select id="CategoryTitle" name="Category">
                   <?php //fetching all the categories from categories table
                   global $ConnectingDB;
                   $sql="SELECT id,title FROM category";
                   $stmt=$ConnectingDB->query($sql);
                   while($DataRows = $stmt->fetch()){
                    $Id = $DataRows["id"];
                    $CategoryName = $DataRows["title"];
                    
                    ?>
                    <option> <?php echo $CategoryName; ?></option>
                  <?php } ?>
                  </select>
                </div> 
                <div class="admin-img-file">
                 <input class="admin-img-input" type="File" name="Image" id="imageSelect">
                 <label for="imageSelect" class="file-label">Select Image</label>
                </div>
                <div class="admin-input">
                <label for="Post">Post:</label><br>
                <textarea name="Post" rows="8" cols="80" id="Post"></textarea>
                </div>
                     <div class="admin-action-container">
                      <a href="Dashboard.php" class="btn-lg warning"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>  
                      <button type="submit" name="submit" class="btn-lg success"><i class="fas fa-check"></i> Publish</button>
                    </div>
     </form>
     </div>


</div>	
</div>	
</section>
</div>
</div>
<script src="slidemenu.js"></script>
</body>
</html>