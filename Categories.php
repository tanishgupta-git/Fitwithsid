<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"]; 
Confirm_Login();
 ?> 
<?php
  if(isset($_POST["submit"])){
     $Category=$_POST["Title"];
     $Admin=$_SESSION["FitUsername"];
     date_default_timezone_set("Asia/Kolkata");
      $CurrentTime=time();
       $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


     if(empty($Category)){
     	$_SESSION["ErrorMessage"] = "All fields must be fiiled out";
        Redirect_to("Categories.php");
       
       }elseif (strlen($Category)<3) {  
         $_SESSION["ErrorMessage"] = "Category title should be greater than 2 characters";
        Redirect_to("Categories.php");
       }elseif (strlen($Category)>49) {  
         $_SESSION["ErrorMessage"] = "Category title should be less than 50 characters";
        Redirect_to("Categories.php");
       }else{
       	// Query to insert category in db when everyting is fine
       	global $ConnectingDB;
       	$sql="INSERT INTO category(title,author,datetime)";
       	$sql .="VALUES(:categoryName,:adminName,:dateTime)";
       	$stmt= $ConnectingDB->prepare($sql);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':dateTime',$DateTime);
        $Execute=$stmt->execute();
        if($Execute)
        {
        	$_SESSION["SuccessMessage"]="Added Successfully";
        	Redirect_to("Categories.php");
        }else{
        	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
        	Redirect_to("Categories.php");
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
	   <title>Manage Categories</title>
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
<div class="main-area">
<!-- header start -->
<header>
<div>
<p class="page-define"><i class="fa fa-edit"></i> Manage Categories</p>
</div>
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
          <form action="Categories.php" method="post">
            <div class="edit-type">
	         <p>Add New Categories</p>
          </div>
               <div class="admin-input">
                 <label for="title">Category Title:</label><br>
                  <input type="text" name="Title" id="title" placeholder="Category title here">
                </div>
                  <div class="admin-action-container">
                      <a href="Dashboard.php" class="btn-lg warning"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>	
	                    <button type="submit" name="submit" class="btn-lg success"><i class="fas fa-check"></i> Publish</button>
                    </div>
           </form>
         </div>
        </div>
         <!-- left side area end -->

          <!-- right side area -->
       <div class="table-container">

        <p>Existing Categories</p>
         <div class="responsive-table">
                <table>
                    <thead>
                      <tr>
                        <th>No. </th>
                          <th>Date&Time</th>
                           <th>Category Name</th>
                            <th>Creator Name</th>
                             <th>Action</th>
                      </tr>                     
                    </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM category ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                $CategoryId = $DataRows["id"];
                $CategoryDate=$DataRows["datetime"];
                $CategoryName= $DataRows["title"];
                $CreatorName = $DataRows["author"];
                $SrNo++;
           
              ?>
              <tbody>
                 <tr>
                  <td><?php echo htmlentities($SrNo); ?></td>
                  <td><?php echo htmlentities($CategoryDate); ?></td>
                  <td><?php echo htmlentities($CategoryName); ?></td>
                  <td><?php echo htmlentities($CreatorName); ?></td>
                   <td><a class="btn delete" href="DeleteCategory.php?id=<?php echo $CategoryId; ?>">Delete</a></td>
                 </tr>
              </tbody>
              <?php } ?>
           </table>
         </div>
       </div>
         <!-- end right side area -->
              </div>		
           </section>
           <!-- end of main area -->
   </div>
    </div>
<script src="slidemenu.js"></script>
</body>
</html>