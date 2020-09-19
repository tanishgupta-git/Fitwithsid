<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php  Confirm_Login(); ?> 
<?php
  $SearchQueryParameter = $_GET["id"];
         global $ConnectingDB;
       $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
       $stmt=$ConnectingDB->query($sql);
      while($DataRows = $stmt->fetch())
      { $TitleToBeDeleted     = $DataRows['title'];
        $CategoryToBeDeleted  = $DataRows['category'];
        $ImageToBeDeleted     = $DataRows['image'];
        $PostToBeDeleted      = $DataRows['post'];
      }
  if(isset($_POST["submit"])){
       	// Query to Delete post in db when everyting is fine
       	global $ConnectingDB;
        $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
       $Execute = $ConnectingDB->query($sql);
        if($Execute)
        {
          $Target_Path_TO_DELETE_Image = "UPLOAD/$ImageToBeDeleted";
          unlink($Target_Path_TO_DELETE_Image);
        	$_SESSION["SuccessMessage"]="Post Deleted Successfully";
        	Redirect_to("Posts.php");
        }else{
        	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
        	Redirect_to("Posts.php");
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
	<title>Delete Post</title>
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
            <a href="MyProfile.php"><i class="fas fa-user"></i> My Profile</a>
          </li>
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
   <div>
     <p class="page-define"><i class="fa fa-edit"></i> Delete Post</p>
     </div>
  </header>
<!-- end of header -->
<!-- main area -->
<section class="container py-2 mb-4">
  <div class="sub-all-area">
       <?php 
       echo ErrorMessage();
       echo SuccessMessage();
        ?>
       <div class="edit-form-container">
         <div class="form-container">
             <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                  <div class="admin-input">
                    <label for="title">Post Title:</label>
                     <input readonly class="form-control" type="text" name="Title" id="title" value="<?php echo $TitleToBeDeleted; ?>">
                </div>

                <div class="admin-input">
                  <label>Existing Category: </label>
                  <?php echo $CategoryToBeDeleted; ?><br>
                </div>

                <div class="center-label">
                  <span>Existing Image: </span>
                  <img class="mb-1" src="UPLOAD/<?php echo $ImageToBeDeleted;?>" width="120px"; height="120px";> 
                </div>

                <div class="admin-input">
                <label for="Post">Post:</label><br>
                <textarea readonly name="Post" rows="8" cols="80" id="Post"><?php echo $PostToBeDeleted; ?></textarea>
                </div>


                     <div class="admin-action-container">
                      <a href="Dashboard.php" class="btn-lg warning"><i class="fas fa-arrow-left"></i>Back TO Dashboard</a> 
                       <button type="submit" name="submit" class="btn-lg delete"><i class="fas fa-check"></i> Delete</button>
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