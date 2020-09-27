<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php  
Confirm_Login(); ?> 
<?php
  $SearchQueryParameter = $_GET["id"];
  if(isset($_POST["submit"])){
     $PostTitle=$_POST["Title"];
     $Category = $_POST["Category"];
     $Image = $_FILES["Image"]["name"];
     $Target = "UPLOAD/".basename($_FILES["Image"]["name"]);
     $PostText = $_POST["Post"];
     $Admin="Tanish";
     date_default_timezone_set("Asia/Kolkata");
      $CurrentTime=time();
       $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


     if(empty($PostTitle)){
     	$_SESSION["ErrorMessage"] = "Title Can't be empty";
        Redirect_to("EditPost.php?id=$SearchQueryParameter");
       
       }elseif (strlen($PostTitle)<5) {  
         $_SESSION["ErrorMessage"] = "Post title should be greater than 5 characters";
        Redirect_to("EditPost.php?id=$SearchQueryParameter");
       }elseif (strlen($PostText)>9999) {  
         $_SESSION["ErrorMessage"] = "Post description should be less than 10000 characters";
        Redirect_to("EditPost.php?id=$SearchQueryParameter");
       }else{
       	// Query to Update post in db when everyting is fine
       	global $ConnectingDB;
        if(!empty($_FILES["Image"]["name"])){
          $sql = "UPDATE posts SET title='$PostTitle', category='$Category',image='$Image',post='$PostText' WHERE id='$SearchQueryParameter'";
        }
        else{
          $sql = "UPDATE posts SET title='$PostTitle', category='$Category',post='$PostText' WHERE id='$SearchQueryParameter'";
        }
       $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute)
        {
        	$_SESSION["SuccessMessage"]="Post Updated Successfully";
        	Redirect_to("Posts.php");
        }else{
        	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
        	Redirect_to("Posts.php");
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
  <title>Posts</title>
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
	 <div>
     <p class="page-define"><i class="fa fa-edit"></i> Edit Post</p>
     </div>
  </header>
<!-- end of header -->
<!-- main area -->
<section>
  <div class="sub-all-area">
       <?php 
       echo ErrorMessage();
       echo SuccessMessage();
       global $ConnectingDB;
       $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
       $stmt=$ConnectingDB->query($sql);
      while($DataRows = $stmt->fetch())
      { $TitleToBeUpdated     = $DataRows['title'];
        $CategoryToBeUpdated  = $DataRows['category'];
        $ImageToBeUpdated     = $DataRows['image'];
        $PostToBeUpdated      = $DataRows['post'];
      }
        ?>
         <!-- left side area start -->
            <div class="edit-form-container">
          <div class="form-container">
      <form action="EditPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
               <div class="admin-input">
                 <label for="title">Post Title:</label>
                  <input class="form-control" type="text" name="Title" id="title" placeholder="type title here" value="<?php echo $TitleToBeUpdated; ?>">
                </div>
                
                <div class="admin-input">
                  <label>Existing Category: </label>
                  <?php echo $CategoryToBeUpdated; ?><br>
                 <label for="CategoryTitle"> Choose Category</label>
                  <select class="form-control" id="CategoryTitle" name="Category">
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
                <div>
                  <div class="center-label">
                  <label>Existing Image: </label>
                  <img src="UPLOAD/<?php echo $ImageToBeUpdated;?>" width="150px"; height="100px";>
                  </div> 
                <div class="admin-img-file">
                 <input class="admin-img-input" type="File" name="Image" id="imageSelect">
                 <label for="imageSelect" class="file-label">Select Image</label>
                </div>
                </div> 
                <div class="admin-input">
                <label for="Post">Post:</label><br>
                <textarea name="Post" rows="8" cols="80" id="Post"><?php echo $PostToBeUpdated; ?></textarea>
                </div>
                    <div class="admin-action-container">
                      <a href="Dashboard.php" class="btn-lg warning"><i class="fas fa-arrow-left"></i>Back TO Dashboard</a>	
	                     <button type="submit" name="submit" class="btn-lg success"><i class="fas fa-check"></i> Publish</button>
                    </div>
             </form>
            </div>
        </div>	
        </div>	
</section>
      </div>
      </div>
 <!-- end of main area -->

<script src="slidemenu.js"></script>
</body>
</html>