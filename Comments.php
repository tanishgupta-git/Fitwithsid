<?php require_once("INCLUDES/DB.php");?>
<?php require_once("INCLUDES/Functions.php");  ?>
<?php require_once("INCLUDES/Sessions.php");   ?>
<?php  
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); 
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
	<title>Comments</title>
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
              	  <p class="page-define"><i class="fas fa-comments"></i> Manage Comments</p> 
             </div>    			
    </header>
<!-- end of header -->
   <!-- main area -->
    <section>
	  	<div class="sub-all-area">
	  		<?php 
       echo ErrorMessage();
       echo SuccessMessage();
        ?>
        <div class="table-container">
	  		<p>Un-Approved Comments</p>
               <div class="responsive-table">
                <table>
                    <thead>
                      <tr>
                      	<th>No. </th>
                      	 <th>Name</th>
                      	  <th>Date&Time</th>
                      	   <th>Comment</th>
                      	    <th>Approve</th>
                      	     <th>Delete</th>
                      	     <th>Details</th>
                      </tr>                    	
                    </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                $CommentId = $DataRows["id"];
                $DateTimeOfComment=$DataRows["datetime"];
                $CommenterName= $DataRows["name"];
                $CommentContent = $DataRows["comment"];
                $CommentPostId = $DataRows["post_id"];
                   $SrNo++;
           
              ?>
              <tbody>
              	 <tr>
              	 	<td><?php echo htmlentities($SrNo); ?></td>
              	 	<td><?php echo htmlentities($CommenterName); ?></td>
              	 	<td><?php echo htmlentities($DateTimeOfComment); ?></td>
              	 	<td><?php echo htmlentities($CommentContent); ?></td>
              	 	<td><a class="btn approve" href="ApproveComments.php?id=<?php echo $CommentId; ?>">Approve</a></td>
              	 	 <td><a class="btn delete" href="DeleteComments.php?id=<?php echo $CommentId; ?>">Delete</a></td>
              	 	<td><a class="btn preview" href="FullPost.php?id=<?php echo $CommentPostId; ?>">Preview</a></td>
              	 </tr>
              </tbody>
              <?php } ?>
          </table>
        </div>
        </div>
            <div class="table-container">
          	  		<p>Approved Comments</p>
                  <div class="responsive-table">
                <table>
                    <thead>
                      <tr>
                      	<th>No. </th>
                      	 <th>Name</th>
                      	  <th>Date&Time</th>
                      	   <th>Comment</th>
                      	    <th>Revert</th>
                      	     <th>Delete</th>
                      	     <th>Details</th>
                      </tr>                    	
                    </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                $Execute = $ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                $CommentId = $DataRows["id"];
                $DateTimeOfComment=$DataRows["datetime"];
                $CommenterName= $DataRows["name"];
                $CommentContent = $DataRows["comment"];
                $CommentPostId = $DataRows["post_id"];
                   $SrNo++;
           
              ?>
              <tbody>
              	 <tr>
              	 	<td><?php echo htmlentities($SrNo); ?></td>
              	 	<td><?php echo htmlentities($CommenterName); ?></td>
              	 	<td><?php echo htmlentities($DateTimeOfComment); ?></td>
              	 	<td><?php echo htmlentities($CommentContent); ?></td>
              	 	<td style="min-width: 153px;"><a class="btn disapprove" href="DisApproveComments.php?id=<?php echo $CommentId; ?>">Dis-Approve</a></td>
              	 	 <td><a class="btn delete" href="DeleteComments.php?id=<?php echo $CommentId; ?>">Delete</a></td>
              	 	<td><a class="btn preview" href="FullPost.php?id=<?php echo $CommentPostId; ?>">Preview</a></td>
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